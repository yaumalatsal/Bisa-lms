<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

class TeamController extends Controller
{
    public function index(){
        $id_ceo = Session::get('id_siswa');
        $produk = 0;

        $getproduk = DB::table('product')
        ->where('id_ceo',$id_ceo)
        ->get();
        foreach($getproduk as $dataproduk){
            $produk = $dataproduk->id;
        }

        session(['id_produk' => $produk]);
        
        $getceo = DB::table('siswa')
        ->where('id', $id_ceo)
        ->get();



        $position = DB::table('position')
        ->where('id','!=',1 )
        ->get();

        $countmember = DB::table('member')
        ->where('id_produk',$produk)
        ->count();
        
        $getmember = DB::table('member')
        ->join('siswa','siswa.id', '=','member.id_siswa')
        ->select('siswa.*', 'member.*')
        ->where('position','!=', 1)
        ->where('id_produk',$produk)
        ->get();

        $track = Session::get('track');
        $track_status = Session::get('track_status');
        return view('dashboard/tahap_team')
        ->with(compact('getproduk'))
        ->with(compact('getceo'))
        ->with(compact('getmember'))
        ->with(compact('position'))
        ->with(compact('countmember'));
        // if($track == 2 && $track_status == 0){
        // }else{
        //     return redirect('/');
        // }

    }

    public function tambah_member(Request $req)
    {

        $cekmember = DB::table('member')
        ->where('id_siswa', $req->id_siswa)
        ->where('id_produk', $req->id_produk)
        ->count();

        if($cekmember == 0){
            $cekrole = DB::table('member')
            ->where('position',$req->position)
            ->where('id_produk', $req->id_produk)
            ->count();

            if($cekrole ==  0){
                $input = DB::table('member')->insert([
                    'id_siswa'   => $req->id_siswa,
                    'id_produk' => $req->id_produk,
                    'position'  => $req->position
                ]);
                if($input == 1){
                    return redirect("/tahap_team");
                }else{
                    return redirect("/tahap_team")->with('status', 'Gagal menambah member');
                }
            }else{
                $current_posisi = 'posisi';
                if($req->position == 2){
                    $current_posisi = 'HIPSTER';
                }else{
                    $current_posisi = 'HACKER';
                }
                return redirect("/tahap_team")->with('status', "Role  yang ".$current_posisi." sudah ada di tim anda");
            }
        }else{
            return redirect("/tahap_team")->with('status', 'Siswa dengan NIS tersebut sudah menjadi bagian tim anda');
        }
    }

    public function delete_member($id){
        $del = DB::table('member')->where('id',$id)->delete();
        return redirect('tahap_team')->with('status', 'Member berhasil dihapus dari tim');
    }

    public function lock_team(Request $req){
        $updateTrack = DB::table('track_step')
        ->where('id_ceo',$req->id_siswa)
        ->update([
            'id_produk' => $req->id_produk,
            'status' => 1,
        ]);

        return redirect('/');
    }
}
