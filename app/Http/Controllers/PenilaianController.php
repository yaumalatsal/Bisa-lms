<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    public function index_mentor()
    {
        return view('mentor.page.penilaian', [
            'produk' => $this->supervisedProducts()->get(),
        ]);
    }

    public function detail_penilaian($id)
    {
        $idMentor = Auth::guard('mentor')->id();

        return view('mentor.page.detail_penilaian', [
            'produk' => $this->supervisedProducts()->where('product.id', $id)->get(),
            'masterstep' => DB::table('master_step')->orderBy('step_number')->get(),
            'nilai' => $this->nilaiQuery()
                ->where('penilaian.id_mentor', $idMentor)
                ->where('penilaian.id_produk', $id)
                ->get(),
        ]);
    }

    public function siswaPenilaian(Request $request)
    {
        return view('dashboard.penilaian', [
            'masterstep' => DB::table('master_step')->orderBy('step_number')->get(),
            'nilai' => $this->nilaiQuery()
                ->where('penilaian.id_produk', $request->session()->get('id_produk'))
                ->get(),
        ]);
    }

    public function inputNilai(Request $request)
    {
        $validated = $request->validate([
            'step' => ['required', 'integer'],
            'id_produk' => ['required', 'integer'],
            'nilai' => ['required', 'numeric', 'min:0', 'max:100'],
            'keterangan' => ['nullable', 'string', 'max:2000'],
        ]);

        // Dulu id_produk diambil apa adanya dari form, sehingga mentor mana pun
        // bisa menilai produk yang bukan bimbingannya.
        if (! $this->supervises($validated['id_produk'])) {
            return redirect()->back()->with('error', 'Anda bukan pembimbing produk ini.');
        }

        DB::table('penilaian')->insert([
            'id_step' => $validated['step'],
            'id_mentor' => Auth::guard('mentor')->id(),
            'id_produk' => $validated['id_produk'],
            'file_nilai' => $validated['nilai'],
            'keterangan' => $validated['keterangan'],
        ]);

        return redirect()->back()->with('success', 'Nilai tersimpan.');
    }

    public function editNilai(Request $request)
    {
        $validated = $request->validate([
            'id_penilaian' => ['required', 'integer'],
            'nilai' => ['required', 'numeric', 'min:0', 'max:100'],
            'keterangan' => ['nullable', 'string', 'max:2000'],
        ]);

        $updated = DB::table('penilaian')
            ->where('id', $validated['id_penilaian'])
            ->where('id_mentor', Auth::guard('mentor')->id())
            ->update([
                'file_nilai' => $validated['nilai'],
                'keterangan' => $validated['keterangan'],
            ]);

        return redirect()->back()->with(
            $updated ? 'success' : 'error',
            $updated ? 'Nilai diperbarui.' : 'Nilai tidak ditemukan.'
        );
    }

    public function deleteNilai(Request $request)
    {
        $validated = $request->validate([
            'id_penilaian' => ['required', 'integer'],
        ]);

        // Dibatasi pada nilai yang diberikan mentor ini sendiri.
        $deleted = DB::table('penilaian')
            ->where('id', $validated['id_penilaian'])
            ->where('id_mentor', Auth::guard('mentor')->id())
            ->delete();

        return response()->json(['success' => (bool) $deleted], $deleted ? 200 : 403);
    }

    private function supervisedProducts()
    {
        return DB::table('product')
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
            ->where('product.id_mentor', Auth::guard('mentor')->id());
    }

    private function nilaiQuery()
    {
        return DB::table('penilaian')
            ->select(
                'master_step.*',
                'master_step.id as id_step',
                'penilaian.*',
                'penilaian.id as penilaian_id'
            )
            ->join('master_step', 'penilaian.id_step', '=', 'master_step.id');
    }

    private function supervises($productId): bool
    {
        return Product::whereKey($productId)
            ->where('id_mentor', Auth::guard('mentor')->id())
            ->exists();
    }
}
