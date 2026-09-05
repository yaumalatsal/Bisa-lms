<?php

namespace App\Http\Controllers;

use App\Services\ProductAssetUploader;
use App\Support\Embed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublikasiController extends Controller
{
    private const POSTER_DIR = 'poster_produk';

    public function __construct(private ProductAssetUploader $uploader) {}

    public function index(Request $request)
    {
        $idProduk = $request->session()->get('id_produk');

        $dataVideo = DB::table('video_produk')->where('id_produk', $idProduk)->get();
        $dataPoster = DB::table('poster_produk')->where('id_produk', $idProduk)->get();

        return view('dashboard.tahap_publikasi', [
            'dataVideo' => $dataVideo,
            'dataPoster' => $dataPoster,
            // Dulu berisi HTML mentah dari input siswa; kini hanya URL embed
            // yang sudah divalidasi (atau null).
            'playerVideo' => Embed::youtubeEmbedUrl(optional($dataVideo->last())->link_video),
            'countVideo' => $dataVideo->count(),
            'countPoster' => $dataPoster->count(),
        ]);
    }

    public function setVideo(Request $request)
    {
        $validated = $request->validate([
            'link_video' => ['required', 'string', 'max:2000'],
        ]);

        $idProduk = $request->session()->get('id_produk');

        DB::table('video_produk')->updateOrInsert(
            ['id_produk' => $idProduk],
            ['link_video' => $validated['link_video']]
        );

        return redirect('/publikasi')->with('success', 'Video produk tersimpan.');
    }

    public function setPoster(Request $request)
    {
        $request->validate([
            'poster_produk' => ProductAssetUploader::rules(),
        ], [
            'poster_produk.mimes' => 'Poster harus berupa gambar JPG, PNG atau WebP.',
        ]);

        $idProduk = $request->session()->get('id_produk');

        $name = $this->uploader->store($request->file('poster_produk'), self::POSTER_DIR);

        if ($name === null) {
            return redirect('/publikasi')->with('error', 'Ekstensi file tidak sesuai.');
        }

        $existing = DB::table('poster_produk')->where('id_produk', $idProduk)->first();

        DB::table('poster_produk')->updateOrInsert(
            ['id_produk' => $idProduk],
            ['poster_produk' => $name]
        );

        // Buang berkas lama hanya setelah yang baru tercatat.
        if ($existing) {
            $this->uploader->delete($existing->poster_produk, self::POSTER_DIR);
        }

        return redirect('/publikasi')->with('success', 'Poster produk tersimpan.');
    }

    public function updateTrackPublikasi(Request $request)
    {
        $idProduk = $request->session()->get('id_produk');

        if ($idProduk) {
            DB::table('track_step')
                ->where('id_produk', $idProduk)
                ->update(['id_step' => '5', 'status' => '1']);

            $request->session()->put(['track' => '5', 'track_status' => '1']);
        }

        return redirect('/');
    }
}
