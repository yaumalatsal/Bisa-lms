<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class PresentasiController extends Controller
{
    public function index(){
        $id_produk =  Session::get('id_produk');
        $countDeck = DB::table('presentasi')->where('id_produk',$id_produk)->count();
        $deck = DB::table('presentasi')->where('id_produk',$id_produk)->get();

        $track = Session::get('track');
        $track_status = Session::get('track_status');
        if($track == 6 && $track_status == 0){
            return view('dashboard/tahap_presentasi')->with(compact('countDeck','deck'));
        }else{
            return redirect('/');
        }
    }

    public function setDeck(Request $request){
        $id_produk = Session::get('id_produk');
        $cek = DB::table('presentasi')
        ->where('id_produk',$id_produk)
        ->count();

        if($cek == 0){
            $insertFigma = DB::table('presentasi')->insert([
                'deck' => $request->deck,
                'id_produk'  => $id_produk
            ]);

            return redirect('/presentasi');
        }else{
            $updateFigma = DB::table('presentasi')
            ->where('id_produk',$id_produk)
            ->update([
                'deck' => $request->deck,
            ]);
            return redirect('/presentasi');
        }
    }

    public function updateTrackDeck(){
        $id_produk = Session::get('id_produk');
        $updatetrack = DB::table('track_step')
        ->where('id_produk', $id_produk)
        ->update([
            'id_step'   => '6',
            'status'    => '1'
        ]);

        return redirect("/");
    }
}
