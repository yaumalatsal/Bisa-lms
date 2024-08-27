<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class BmcController extends Controller
{
    public function index(){
        $track = Session::get('track');
        $track_status = Session::get('track_status');
        $getBMC = DB::table('master_bmc')->get();
        return view('dashboard/bmc')->with('bmc', $getBMC);
        // if($track == 3 && $track_status == 0){
        // }else{
        //     return redirect('/');
        // }
    }

    public function detail($id){
        $id_produk = Session::get('id_produk');
        
        $databmc = DB::table('pertanyaan_bmc')
        ->select('pertanyaan_bmc.*','pertanyaan_bmc.id as id_pertanyaan_bmc', 'virtualtable.*','master_bmc.*')
        ->leftJoin(DB::raw('(SELECT * FROM jawaban_bmc WHERE id_produk ='.$id_produk.') virtualtable'),
                function($join){
                    $join->on('pertanyaan_bmc.id','=','virtualtable.id_pertanyaan');
                })
        ->join('master_bmc','master_bmc.id','pertanyaan_bmc.id_poin_bmc')
        ->where('pertanyaan_bmc.id_poin_bmc',$id)
        ->get();
        
        $getmasterbmc = DB::table('master_bmc')->where('id',$id)->get();
        //  return var_dump($get);
        return view('dashboard/bmc_detail')->with(compact('databmc', 'getmasterbmc'));
    }

    public function insertJawaban(Request $request){
        $id_produk =  $request->id_produk;
        $id_pertanyaan =  $request->id_pertanyaan;

        
        
        $cek = DB::table('jawaban_bmc')
        ->where('id_produk',$id_produk)
        ->where('id_pertanyaan',$id_pertanyaan)
        ->count();

        if($cek == 0){
            $input = DB::table('jawaban_bmc')->insert([
                'jawaban'       => $request->jawaban,
                'id_produk'     => $request->id_produk,
                'id_siswa'      => $request->id_siswa,
                'id_pertanyaan' => $request->id_pertanyaan
            ]);
            return redirect()->back();
        }else{
            $id_tanya = 0;
            $getid = DB::table('jawaban_bmc')
            ->where('id_produk',$id_produk)
            ->where('id_pertanyaan',$id_pertanyaan)
            ->get();

            if($getid != ''){
                foreach($getid as $pertanyaan){
                    $id_tanya = $pertanyaan->id;
                }
                
                $update = DB::table('jawaban_bmc')
                ->where('id',$id_tanya)
                ->update([
                    'jawaban'     => $request->jawaban,
                ]);

                    return redirect()->back();
            }


        }
    }

    public function updateTrack(){
        $id_produk = Session::get('id_produk');
        $updatetrack = DB::table('track_step')
        ->where('id_produk', $id_produk)
        ->update([
            'id_step'   => '3',
            'status'    => '1'
        ]);

        return redirect("/");
    }


    public function resultBMC($id_bmc,$id_produk){
        $getmaster = DB::table('master_bmc')
        ->where('id',$id_bmc)
        ->get();

        $getResult = DB::table('jawaban_bmc')
        ->join('pertanyaan_bmc','pertanyaan_bmc.id','jawaban_bmc.id_pertanyaan')
        ->where('pertanyaan_bmc.id_poin_bmc',$id_bmc)
        ->where('jawaban_bmc.id_produk',$id_produk)
        ->get();
        
        return view('mentor/page/detail_result_bmc')->with(compact('getResult','getmaster'));
    }

    public function resultSiswaBMC($id_bmc,$id_produk){
        $getmaster = DB::table('master_bmc')
        ->where('id',$id_bmc)
        ->get();

        $getResult = DB::table('jawaban_bmc')
        ->join('pertanyaan_bmc','pertanyaan_bmc.id','jawaban_bmc.id_pertanyaan')
        ->where('pertanyaan_bmc.id_poin_bmc',$id_bmc)
        ->where('jawaban_bmc.id_produk',$id_produk)
        ->get();
        
        return view('dashboard/detail_result_bmc')->with(compact('getResult','getmaster'));
    }
}
