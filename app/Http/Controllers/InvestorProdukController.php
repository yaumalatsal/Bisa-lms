<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvestorProdukController extends Controller
{
    public function index(){
        $products = Product::with([
            'logoProduk', // Load logo_produk relation
            'mentor',                      // Load mentor relation
            'ceo'                        // Load siswa relation
        ])->get();

        // Log::info($products);

        return view('investor/page/produk')->with(compact('products'));
    }

    public function detail($id){
        $produk = DB::table('product')
        ->select('product.*','mentor.*','siswa.*','product.id as product_id','logo_produk.logo_produk','mentor.nama as nama_mentor', 'siswa.nama as  nama_siswa')
        ->leftJoin('logo_produk', 'logo_produk.id_produk','product.id')
        ->join('mentor', 'product.id_mentor','mentor.id')
        ->join('siswa', 'product.id_ceo','siswa.id')
        ->where('product.id',$id)
        ->get();

        $member = DB::table('member')
        ->join('siswa', 'siswa.id','member.id_siswa')
        ->where('member.id_produk',$id)
        ->orderBy('member.position','ASC')
        ->get();

        $bmc = DB::table('master_bmc')->get();

        $track = DB::table('track_step')
        ->select('master_step.*', 'track_step.*', 'track_step.id as id_track')
        ->join('master_step','master_step.id','track_step.id_step')
        ->where('track_step.id_produk',$id)
        ->get();

        $masterstep = DB::table('master_step')->get();

        $proto = DB::table('protolink')
        ->where('id_produk',$id)
        ->get();

        $logo = DB::table('logo_produk')
        ->where('id_produk',$id)
        ->get();

        $video = DB::table('video_produk')
        ->where('id_produk',$id)
        ->get();

        $poster = DB::table('poster_produk')
        ->where('id_produk',$id)
        ->get();
        
        $presentasi = DB::table('presentasi')
        ->where('id_produk',$id)
        ->get();

        // Log::info($produk);
        

        return view('investor/page/detail_produk')
        ->with(compact(
            'produk',
            'track',
            'masterstep',
            'member',
            'bmc',
            'proto',
            'logo',
            'video',
            'poster',
            'presentasi'
        ));
    }

    public function result_bmc($id_bmc,$id_produk){
        $getmaster = DB::table('master_bmc')
        ->where('id',$id_bmc)
        ->get();

        $getResult = DB::table('jawaban_bmc')
        ->join('pertanyaan_bmc','pertanyaan_bmc.id','jawaban_bmc.id_pertanyaan')
        ->where('pertanyaan_bmc.id_poin_bmc',$id_bmc)
        ->where('jawaban_bmc.id_produk',$id_produk)
        ->get();
        
        return view('investor/page/detail_result_bmc')->with(compact('getResult','getmaster'));
    }
}
