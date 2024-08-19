<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\Models\Product;
use App\Models\MonthlyReport;

class MentorController extends Controller
{
    public function index(){
        $id_mentor = Session::get('id_mentor');
        $data = DB::table('mentor')
        ->where('id',$id_mentor)
        ->get();

        return view('mentor/page/dashboard')->with(compact('data'));
    }

    public function login(){
        return view('mentor/page/login');
    }

    public function laporanNilai(){
         // Ambil ID mentor yang sedang login dari sesi
    $id_mentor = Session::get('id_mentor');

    // Ambil produk yang terkait dengan mentor yang sedang login
    $products = Product::where('id_mentor', $id_mentor)->get();

    // Ambil laporan bulanan yang terkait dengan produk-produk tersebut
    $monthlyReports = MonthlyReport::whereIn('product_id', $products->pluck('id'))->get();

    // Tampilkan halaman dengan laporan bulanan dan produk yang difilter
    return view('mentor.page.laporan_produk', compact('monthlyReports'));
        
    }

    public function approveReport($id)
{
    // Cari laporan bulanan berdasarkan ID
    $report = MonthlyReport::findOrFail($id);

    // Ubah status laporan menjadi disetujui
    $report->status = 'Disetujui';
    $report->save();

    return redirect()->back()->with('success', 'Laporan berhasil disetujui.');
}

public function rejectReport($id)
{
    // Cari laporan bulanan berdasarkan ID
    $report = MonthlyReport::findOrFail($id);

    // Ubah status laporan menjadi ditolak
    $report->status = 'Ditolak';
    $report->save();

    return redirect()->back()->with('error', 'Laporan telah ditolak.');
}

    public function signin(Request $req){
        $enc =   md5($req->password);
		$logins = DB::table('mentor')
		->where('email',$req->email)
		->where('password',$enc)
		->count(); 

        if($logins != 0 ){
            $data = DB::table('mentor')
            ->where('email',$req->email)
            ->where('password',$enc)
            ->get();

            foreach ($data as $val) {
                $id_mentor =  $val->id;
            }
            session(['id_mentor' => $id_mentor]);
            return redirect('/mentor');
        }else{
            return view('mentor/page/login')->with('login_error','Maaf Login Gagal');;
        }

    }
    public function logout(Request $request){        
        Session::flush();
        return redirect('/mentor/login');
    }
}
