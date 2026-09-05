<?php

namespace App\Http\Controllers;

use App\Models\Mentor;
use App\Models\Product;
use App\Services\ProductDetailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    public function __construct(private ProductDetailService $details)
    {
    }

    /**
     * Form pendaftaran produk (tahap abstract).
     */
    public function index()
    {
        return view('dashboard.tahap_abstract', [
            'getmentor' => Mentor::orderBy('nama')->get(),
        ]);
    }

    /**
     * Pendaftaran produk baru oleh siswa. Siswa yang sudah tergabung dalam
     * sebuah tim tidak boleh membuat produk lagi.
     */
    public function registerProduk(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'mentor' => ['required', 'integer', 'exists:mentor,id'],
        ]);

        $idCeo = Auth::guard('siswa')->id();

        $sudahPunyaTim = DB::table('member')->where('id_siswa', $idCeo)->exists();
        $namaTerpakai = DB::table('product')->where('nama_produk', $validated['nama_produk'])->exists();

        if ($sudahPunyaTim || $namaTerpakai) {
            return redirect('/product_abstract')
                ->with('status', 'Maaf produk sudah ada / Anda tergabung dalam tim');
        }

        // Satu transaksi: produk, keanggotaan CEO dan langkah pertama harus
        // tercipta bersama-sama, atau tidak sama sekali.
        $productId = DB::transaction(function () use ($validated, $idCeo) {
            $productId = DB::table('product')->insertGetId([
                'nama_produk' => $validated['nama_produk'],
                'deskripsi' => $validated['deskripsi'],
                'id_mentor' => $validated['mentor'],
                'id_ceo' => $idCeo,
            ]);

            DB::table('member')->insert([
                'id_siswa' => $idCeo,
                'id_produk' => $productId,
                'position' => '1',
            ]);

            DB::table('track_step')->insert([
                'id_ceo' => $idCeo,
                'id_produk' => $productId,
                'id_step' => '1',
                'status' => '1',
            ]);

            return $productId;
        });

        $request->session()->put([
            'id_produk' => $productId,
            'track' => '1',
            'track_status' => '1',
        ]);

        return redirect('/');
    }

    /**
     * Daftar produk yang dibimbing mentor yang sedang login.
     */
    public function getProduk()
    {
        $produk = DB::table('product')
            ->select(
                'product.*',
                'product.id as product_id',
                'logo_produk.logo_produk',
                'mentor.nama as nama_mentor',
                'siswa.nama as nama_siswa'
            )
            ->leftJoin('logo_produk', 'logo_produk.id_produk', '=', 'product.id')
            ->join('mentor', 'product.id_mentor', '=', 'mentor.id')
            ->join('siswa', 'product.id_ceo', '=', 'siswa.id')
            ->where('product.id_mentor', Auth::guard('mentor')->id())
            ->get()
            ->each(function ($item) {
                $item->group_chat_url = route('mentor.page.groupchat', ['id_produk' => $item->product_id]);
            });

        return view('mentor.page.produk', compact('produk'));
    }

    /**
     * Detail produk untuk mentor — dibatasi pada produk bimbingannya sendiri.
     */
    public function detail_produk($id)
    {
        return view(
            'mentor.page.detail_produk',
            $this->details->forProduct($id, Auth::guard('mentor')->id())
        );
    }

    /**
     * Detail produk milik tim siswa yang sedang login.
     */
    public function siswaProduk(Request $request)
    {
        return view('dashboard.produk', $this->details->forProduct($request->session()->get('id_produk')));
    }

    /**
     * Mentor menyetujui / mengembalikan sebuah tahap, dengan feedback opsional.
     */
    public function editTrack(Request $request)
    {
        $validated = $request->validate([
            'id_track' => ['required', 'integer'],
            'id_produk' => ['required', 'integer'],
            'step' => ['required', 'integer'],
            'status' => ['required', 'integer'],
            'judul_feedback' => ['nullable', 'string', 'max:255'],
            'feedback' => ['nullable', 'string'],
        ]);

        $idMentor = Auth::guard('mentor')->id();

        // Hanya mentor pembimbing produk ini yang boleh mengubah tahapannya.
        $membimbing = Product::whereKey($validated['id_produk'])
            ->where('id_mentor', $idMentor)
            ->exists();

        if (! $membimbing) {
            return redirect()->back()->with('error', 'Anda bukan pembimbing produk ini.');
        }

        DB::transaction(function () use ($validated, $idMentor) {
            DB::table('track_step')
                ->where('id', $validated['id_track'])
                ->where('id_produk', $validated['id_produk'])
                ->update([
                    'id_step' => $validated['step'],
                    'status' => $validated['status'],
                ]);

            if (! empty($validated['feedback'])) {
                DB::table('feedback')->insert([
                    'id_step' => $validated['step'],
                    'judul' => $validated['judul_feedback'],
                    'komentar' => $validated['feedback'],
                    'id_produk' => $validated['id_produk'],
                    'id_mentor' => $idMentor,
                ]);
            }
        });

        return redirect()->back()->with('success', 'Tahap produk berhasil diperbarui.');
    }
}
