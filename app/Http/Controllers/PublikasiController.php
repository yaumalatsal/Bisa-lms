<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class PublikasiController extends Controller
{
    public function index(){
        $id_produk =  Session::get('id_produk');
        $playerVideo = '';
        $dataVideo =  DB::table('video_produk')
        ->where('id_produk',$id_produk)
        ->get();

        foreach($dataVideo as $datas){
            $playerVideo = htmlspecialchars_decode($datas->link_video);
        }


        $dataPoster =  DB::table('poster_produk')
        ->where('id_produk',$id_produk)
        ->get();

        $countVideo =  DB::table('video_produk')
        ->where('id_produk',$id_produk)
        ->count();

        $countPoster =  DB::table('poster_produk')
        ->where('id_produk',$id_produk)
        ->count();

        $track = Session::get('track');
        $track_status = Session::get('track_status');
        return view('dashboard/tahap_publikasi')
        ->with(compact('dataVideo','playerVideo','dataPoster','countVideo','countPoster'));
        // if($track == 5 && $track_status == 0){
        // }else{
        //     return redirect('/');
        // }
        

    }

    public function setVideo(Request $request){
        $id_produk = Session::get('id_produk');
        $cek = DB::table('video_produk')
        ->where('id_produk',$id_produk)
        ->count();

        if($cek == 0){
            $insertVideo = DB::table('video_produk')->insert([
                'link_video' => $request->link_video,
                'id_produk'  => $id_produk
            ]);

            return redirect('/publikasi');
        }else{
            $updateFigma = DB::table('video_produk')
            ->where('id_produk',$id_produk)
            ->update([
                'link_video' => $request->link_video,
            ]);
            return redirect('/publikasi');
        }
    }

    public function uploadPoster(Request $req,$act){
        $id_produk =  Session::get('id_produk');
        $tgl = date("d_m_Y_h_i_s");
        $time_upload = $tgl;
        $tujuan_file = 'poster_produk/';           
        $file = $req->poster_produk;
        $ekstensi = $file->getClientOriginalExtension();
        $namafile = "$time_upload"."_"."$id_produk".'.'.$ekstensi;
        $pindahin =  $file->move($tujuan_file,$namafile);
        if($pindahin){
            if($act == 'insertgan'){
                $insert = DB::table('poster_produk')->insert([
                    'poster_produk'       =>  $namafile,
                    'id_produk'         =>  $id_produk   
                ]);       
                return '1';     
            }else{
                $updategan = DB::table('poster_produk')
                ->where('id_produk',$id_produk)
                ->update([
                    'poster_produk'       =>  $namafile 
                ]); 
                return '1';
            }
        }else{                                                                                                             
            return '0';

        }        
    }  
    public function deletePoster($lokasigan){
        $hapus = unlink($lokasigan);
        if($hapus){
            return '1';
        }else{
            return '0';
        }
    }

    public function setPoster(Request $req){
        $id_prod = Session::get('id_produk');
        
        $cek = DB::table('poster_produk')
        ->where('id_produk',$id_prod)
        ->count();

        if($cek == 0){
            $uploadgan =  $this->uploadPoster($req,'insertgan');
            if($uploadgan == 1){ 
                return redirect('/publikasi');
            }else{
                return redirect('/publikasi');
            }
        }else{
            $cekfile = DB::table('poster_produk')
            ->where('id_produk',$id_prod)
            ->get();

            $cekname = '';
            foreach($cekfile as $datas){
                $cekname = $datas->poster_produk;
            }

            $myfile = 'poster_produk/'.$cekname;
            if(file_exists($myfile)){
                $delgan = $this->deletePoster($myfile);
                if($delgan == '1'){
                    $uploadgan =  $this->uploadPoster($req,'updategan');
                    if($uploadgan == 1){
                        return redirect('/publikasi');
                    }else{
                        return redirect('/publikasi');
                    }
                }else{
                    return 'Hapus file gagal';
                }
            }else{
                $uploadgan =  $this->uploadPoster($req,'updategan');
                if($uploadgan == 1){
                    return redirect('/publikasi');
                }else{
                    return redirect('/publikasi');
                }
            }
        }
    }

    public function updateTrackPublikasi(){
        $id_produk = Session::get('id_produk');
        $updatetrack = DB::table('track_step')
        ->where('id_produk', $id_produk)
        ->update([
            'id_step'   => '5',
            'status'    => '1'
        ]);

        return redirect("/");
    }
}