<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use DB;
use Session;

class ProdukController extends Controller
{
    
    public function index(){
        $getmentor = DB::table('mentor')->get();
        $track = Session::get('track');
        $track_status = Session::get('track_status');
        return view('dashboard/tahap_abstract')->with(compact('getmentor'));

        // if($track == 1 && $track_status == 0){
        // }elseif($track == NULL && $track_status == NULL)
        //     return view('dashboard/tahap_abstract')->with(compact('getmentor'));        
        // {
        //     return redirect('/');
        // }
    }

    // pendaftaran produk
    public function registerProduk(Request $request){
        $id_ceo = Session::get('id_siswa');
        $nama_produk = $request->nama_produk;
        $cek = DB::table('product')
        ->where('nama_produk',$nama_produk)
        ->count();

        $siswa = Siswa::with('members','members.produk')->findOrFail($id_ceo);

        
        if($cek == 0 && !$siswa->members[0]->produk){
            $input = DB::table('product')->insert([
                'nama_produk'   => $request->nama_produk,
                'deskripsi'     => $request->deskripsi,
                'id_mentor'     => $request->mentor,
                'id_ceo'        => $id_ceo
            ]);
            if($input){

                $getproduk = DB::table('product')
                ->where('product.nama_produk',$request->nama_produk)
                ->get();
                $getidproduk = 0;
                foreach($getproduk as $prod){
                    $getidproduk = $prod->id;
                }
                
                $inputceo = DB::table('member')->insert([
                    'id_siswa'  =>$id_ceo,
                    'id_produk' => $getidproduk,
                    'position'  => '1'
                ]);


                $input_track = DB::table('track_step')->insert([
                    'id_ceo' => $id_ceo,
                    'id_produk' => $getidproduk,
                    'id_step'   => '1',
                    'status'    => '1'
                ]);                
                // session(['produk' => $request->nama_produk]);
                session(['track' => '1']);
                session(['track_status' => '1']);
                return redirect('/');
            } 
        }else{
            return redirect('/product_abstract')->with('status', 'Maaf produk sudah ada / Anda tergabung dalam tim');
        }
    }

    public function getProduk()
    {
        $id_mentor = Session::get('id_mentor');
        $produk = DB::table('product')
            ->select('product.*', 'mentor.*', 'siswa.*', 'product.id as product_id', 'logo_produk.logo_produk', 'mentor.nama as nama_mentor', 'siswa.nama as nama_siswa')
            ->leftJoin('logo_produk', 'logo_produk.id_produk', 'product.id')
            ->join('mentor', 'product.id_mentor', 'mentor.id')
            ->join('siswa', 'product.id_ceo', 'siswa.id')
            ->where('product.id_mentor', $id_mentor)
            ->get();
    
        // Generate group chat URL for each product
        foreach ($produk as $item) {
            $item->group_chat_url = route('mentor.page.groupchat', ['id_produk' => $item->product_id]);
        }
    
        return view('mentor/page/produk')->with(compact('produk'));
    }
    

    public function detail_produk($id){
        $id_mentor = Session::get('id_mentor');
        $produk = DB::table('product')
        ->select('product.*','mentor.*','siswa.*','product.id as product_id','logo_produk.logo_produk','mentor.nama as nama_mentor', 'siswa.nama as  nama_siswa')
        ->leftJoin('logo_produk', 'logo_produk.id_produk','product.id')
        ->join('mentor', 'product.id_mentor','mentor.id')
        ->join('siswa', 'product.id_ceo','siswa.id')
        ->where('product.id_mentor',$id_mentor)
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
        

        return view('mentor/page/detail_produk')
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

    public function siswaProduk(){
        $id = Session::get('id_produk');
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
        

        return view('dashboard/produk')
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

    public function editTrack(Request $req){
        $id_mentor = Session::get('id_mentor');
        $update = DB::table('track_step')
        ->where('id',$req->id_track)
        ->update([
            'id_step' => $req->step,
            'status'  => $req->status
        ]);

        if($req->feedback != ''){
            $feeding = DB::table('feedback')->insert([
                'id_step'   => $req->step,
                'judul'     => $req->judul_feedback,
                'komentar'  => $req->feedback, 
                'id_produk' => $req->id_produk, 
                'id_mentor' => $id_mentor, 
            ]);
            return redirect()->back();
        }else{
            return redirect()->back();

        }

    }
}
