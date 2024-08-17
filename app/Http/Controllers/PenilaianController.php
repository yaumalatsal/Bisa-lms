<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class PenilaianController extends Controller
{
    public function index_mentor(){
        $id_mentor = Session::get('id_mentor');
        $produk = DB::table('product')
        ->select('product.*','mentor.*','siswa.*','product.id as product_id','logo_produk.logo_produk','mentor.nama as nama_mentor', 'siswa.nama as  nama_siswa')
        ->leftJoin('logo_produk', 'logo_produk.id_produk','product.id')
        ->join('mentor', 'product.id_mentor','mentor.id')
        ->join('siswa', 'product.id_ceo','siswa.id')
        ->where('product.id_mentor',$id_mentor)
        ->get();

        return view('mentor/page/penilaian')->with(compact('produk'));
    }


    public function detail_penilaian($id){
        $id_mentor = Session::get('id_mentor');
        $produk = DB::table('product')
        ->select('product.*','mentor.*','siswa.*','product.id as product_id','logo_produk.logo_produk','mentor.nama as nama_mentor', 'siswa.nama as  nama_siswa')
        ->leftJoin('logo_produk', 'logo_produk.id_produk','product.id')
        ->join('mentor', 'product.id_mentor','mentor.id')
        ->join('siswa', 'product.id_ceo','siswa.id')
        ->where('product.id_mentor',$id_mentor)
        ->where('product.id',$id)
        ->get();

        $masterstep = DB::table('master_step')->get();


        $nilai = DB::table('penilaian')
                ->select('master_step.*','master_step.id as id_step', 'penilaian.*', 'penilaian.id as penilaian_id')
                ->join('master_step', 'penilaian.id_step', 'master_step.id')
                ->get();

        return view('mentor/page/detail_penilaian')->with(compact('produk','masterstep','nilai'));
    }

    public function siswaPenilaian(){
        $id_produk = Session::get('id_produk');
        $masterstep = DB::table('master_step')->get();


        $nilai = DB::table('penilaian')
                ->select('master_step.*','master_step.id as id_step', 'penilaian.*', 'penilaian.id as penilaian_id')
                ->join('master_step', 'penilaian.id_step', 'master_step.id')
                ->where('penilaian.id_produk', $id_produk)
                ->get();

        return view('dashboard/penilaian')->with(compact('masterstep','nilai'));
    }

    public function inputNilai(Request $req)
    {   
        $id_mentor = Session::get('id_mentor');
        $input = DB::table('penilaian')->insert([
            'id_step'       => $req->step,
            'id_mentor'     => $id_mentor,
            'id_produk'     => $req->id_produk,
            'file_nilai'    => $req->nilai
        ]);

        return redirect()->back();
    }

    public function editNilai(Request $req)
    {   
        $update = DB::table('penilaian')
        ->where('id', $req->id_penilaian)
        ->update([
            'file_nilai'    => $req->nilai
        ]);

        return redirect()->back();
    }
}
