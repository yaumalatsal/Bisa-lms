<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\Models\artikelInkubasi;

class DashboardController extends Controller
{

    public function __construct() {}

    public function showMateriBMC()
    {
        // Ambil semua materi dengan kategori 'bmc'
        $materi = artikelInkubasi::where('kategori', 'bmc')->get();

        // Pisahkan artikel dan video
        $artikel = $materi->filter(function ($item) {
            return $item->bentuk_kategori == 'artikel';
        });

        $video = $materi->filter(function ($item) {
            return $item->bentuk_kategori == 'video';
        });

        return view('dashboard.materi.index', compact('artikel', 'video'));
    }

    public function showMateriIde()
    {
        // Ambil semua materi dengan kategori 'bmc'
        $materi = artikelInkubasi::where('kategori', 'ide bisnis')->get();

        // Pisahkan artikel dan video
        $artikel = $materi->filter(function ($item) {
            return $item->bentuk_kategori == 'artikel';
        });

        $video = $materi->filter(function ($item) {
            return $item->bentuk_kategori == 'video';
        });

        return view('dashboard.materi.index', compact('artikel', 'video'));
    }

    public function showMateriCara()
    {
        // Ambil semua materi dengan kategori 'bmc'
        $materi = artikelInkubasi::where('kategori', 'cara memulai bisnis')->get();

        // Pisahkan artikel dan video
        $artikel = $materi->filter(function ($item) {
            return $item->bentuk_kategori == 'artikel';
        });

        $video = $materi->filter(function ($item) {
            return $item->bentuk_kategori == 'video';
        });

        return view('dashboard.materi.index', compact('artikel', 'video'));
    }

    public function penilaian_siswa()
    {
        $id_produk = Session::get('id_produk');
        $masterstep = DB::table('master_step')->get();


        $nilai = DB::table('penilaian')
            ->select('master_step.*', 'master_step.id as id_step', 'penilaian.*', 'penilaian.id as penilaian_id')
            ->join('master_step', 'penilaian.id_step', 'master_step.id')
            ->where('penilaian.id_produk', $id_produk)
            ->get();

        return view('dashboard.dashboard')->with(compact('masterstep', 'nilai'));
    }

    function laporan()
    {
        return view('dashboard.laporan');
    }

    function inkubasi()
    {
        $track = Session::get('track');
        $track_status = Session::get('track_status');
        $id_siswa = Session::get('id_siswa');
        if (Session::has('id_siswa')) {
            if ($track == 1 && $track_status == 1) {
                $cektahap = DB::table('track_step')
                    ->where('id_ceo', $id_siswa)
                    ->get();

                $cek_track = 0;
                $cek_status = 0;
                foreach ($cektahap as $cek) {
                    $cek_track = $cek->id_step;
                    $cek_status = $cek->status;
                }

                session(['track' => $cek_track]);
                session(['track_status' => $cek_status]);

                if ($cek_track == 2) {
                    return redirect('/tahap_team');
                } else {
                    session(['track' => '1']);
                    session(['track_status' => '1']);
                    return view('dashboard/ongoing');
                }
            } elseif ($track == 1 && $track_status == 0) {
                session()->forget('id_produk');
                return redirect('/product_abstract');
            } elseif ($track == 1 && $track_status == 2) {
                session()->forget('id_produk');
                return redirect('dashboard/ongoing');
            } else {
                $id_produk = Session::get('id_produk');
                $gettahap = DB::table('master_step')
                    ->select('master_step.*', 'track_step.*')
                    ->join('track_step', 'track_step.id_step', 'master_step.id')
                    ->join('product', 'product.id', 'track_step.id_produk')
                    ->where('product.id', $id_produk)
                    ->get();

                $data_step = 0;
                foreach ($gettahap as $data) {
                    $data_step = $data->step_number;
                    session(['track' => $data->step_number]);
                    session(['track_status' => $data->status]);
                }

                // $tampilan_tahap = DB::table('master_step')
                // ->leftJoin('track_step', 'track_step.id_step', '=', 'master_step.id')
                // ->where('step_number','<=', $data_step)
                // ->where('track_step.id_produk', $id_produk)
                // ->orderBy('master_step.step_number','ASC')
                // ->get();

                $tampilan_tahap = DB::table('master_step')
                    ->select('master_step.*', 'virtualtable.*')
                    ->leftJoin(
                        DB::raw('(SELECT * FROM track_step WHERE id_produk =' . $id_produk . ') virtualtable'),
                        function ($join) {
                            $join->on('master_step.id', '=', 'virtualtable.id_step');
                        }
                    )
                    ->where('master_step.step_number', '<=', $data_step)
                    ->orderBy('master_step.step_number', 'ASC')
                    ->get();

                $tim = DB::table('product')->where('id', $id_produk)->get();

                $track = Session::get('track');
                $track_status = Session::get('track_status');


                if ($track == 1 && $track_status == 0) {
                    return redirect('/product_abstract');
                } else {
                    return view('dashboard/inkubasi')
                        ->with(compact('tampilan_tahap', 'tim'));
                }
            }
        } else {
            return redirect('/login');
        }
    }

    function login()
    {
        return view('page/login');
    }

    function register_siswa()
    {
        return view('page/register_siswa');
    }

    function register_mentor()
    {
        return view('page/register_mentor');
    }
}
