<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PresentasiController extends Controller
{
    public function index(Request $request)
    {
        $deck = DB::table('presentasi')
            ->where('id_produk', $request->session()->get('id_produk'))
            ->get();

        return view('dashboard.tahap_presentasi', [
            'deck' => $deck,
            'countDeck' => $deck->count(),
        ]);
    }

    public function setDeck(Request $request)
    {
        $validated = $request->validate([
            'deck' => ['required', 'url', 'max:2000'],
        ]);

        DB::table('presentasi')->updateOrInsert(
            ['id_produk' => $request->session()->get('id_produk')],
            ['deck' => $validated['deck']]
        );

        return redirect('/presentasi')->with('success', 'Link pitch deck tersimpan.');
    }

    public function updateTrackDeck(Request $request)
    {
        $idProduk = $request->session()->get('id_produk');

        if ($idProduk) {
            DB::table('track_step')
                ->where('id_produk', $idProduk)
                ->update(['id_step' => '6', 'status' => '1']);

            $request->session()->put(['track' => '6', 'track_status' => '1']);
        }

        return redirect('/');
    }
}
