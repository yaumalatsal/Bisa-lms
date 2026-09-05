<?php

namespace App\Http\Controllers;

use App\Services\ProductAssetUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProtoController extends Controller
{
    private const LOGO_DIR = 'logo_produk';

    public function __construct(private ProductAssetUploader $uploader) {}

    public function index(Request $request)
    {
        $idProduk = $request->session()->get('id_produk');

        $dataFigma = DB::table('protolink')->where('id_produk', $idProduk)->get();
        $dataLogo = DB::table('logo_produk')->where('id_produk', $idProduk)->get();

        return view('dashboard.tahap_workflow', [
            'dataFigma' => $dataFigma,
            'dataLogo' => $dataLogo,
            'countFigma' => $dataFigma->count(),
            'countLogo' => $dataLogo->count(),
            'dataMentor' => DB::table('product')
                ->select('mentor.nama', 'mentor.email', 'mentor.nomor_telepon', 'mentor.instansi')
                ->join('mentor', 'product.id_mentor', '=', 'mentor.id')
                ->where('product.id', $idProduk)
                ->get(),
        ]);
    }

    public function setFigma(Request $request)
    {
        $validated = $request->validate([
            'link_figma' => ['required', 'url', 'max:2000'],
        ]);

        DB::table('protolink')->updateOrInsert(
            ['id_produk' => $request->session()->get('id_produk')],
            ['link_figma' => $validated['link_figma']]
        );

        return redirect('/proto')->with('success', 'Link prototype tersimpan.');
    }

    public function setLogo(Request $request)
    {
        $request->validate([
            'logo_produk' => ProductAssetUploader::rules(),
            'deskripsi' => ['nullable', 'string', 'max:2000'],
        ], [
            'logo_produk.mimes' => 'Logo harus berupa gambar JPG, PNG atau WebP.',
        ]);

        $idProduk = $request->session()->get('id_produk');

        $name = $this->uploader->store($request->file('logo_produk'), self::LOGO_DIR);

        if ($name === null) {
            return redirect('/proto')->with('error', 'Ekstensi tidak sesuai. Gunakan PNG, JPG atau WebP.');
        }

        $existing = DB::table('logo_produk')->where('id_produk', $idProduk)->first();

        DB::table('logo_produk')->updateOrInsert(
            ['id_produk' => $idProduk],
            [
                'logo_produk' => $name,
                'deskripsi' => $request->input('deskripsi'),
            ]
        );

        // Berkas lama dihapus setelah yang baru tercatat, bukan sebelumnya —
        // dulu kegagalan upload bisa menyisakan produk tanpa logo sama sekali.
        if ($existing) {
            $this->uploader->delete($existing->logo_produk, self::LOGO_DIR);
        }

        return redirect('/proto')->with('success', 'Logo produk tersimpan.');
    }

    public function updateTrack(Request $request)
    {
        $idProduk = $request->session()->get('id_produk');

        if ($idProduk) {
            DB::table('track_step')
                ->where('id_produk', $idProduk)
                ->update(['id_step' => '4', 'status' => '1']);

            $request->session()->put(['track' => '4', 'track_status' => '1']);
        }

        return redirect('/');
    }
}
