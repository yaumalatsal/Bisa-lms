<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;


class FeedbackController extends Controller
{
    public function getFeedback(){
        $id_mentor = Session::get('id_mentor');
        $feed = DB::table('feedback')
        ->join('master_step','master_step.id','feedback.id_step')
        ->join('product','product.id','feedback.id_produk')
        ->where('feedback.id_mentor', $id_mentor)
        ->get();

        $masterstep = DB::table('master_step')
        ->get();
        return view('mentor/page/feedback')->with(compact('feed','masterstep'));
    }

    public function siswaFeedback(){
        $id_produk = Session::get('id_produk');
        $feed = DB::table('feedback')
        ->select('product.*','feedback.*','feedback.id as id_feedback', 'master_step.*')
        ->join('master_step','master_step.id','feedback.id_step')
        ->join('product','product.id','feedback.id_produk')
        ->where('feedback.id_produk', $id_produk)
        ->get();

        return view('dashboard/feedback')->with(compact('feed'));
    }

    public function konfirmFeed(Request $req){
        $update = DB::table('feedback')
        ->where('id',$req->id_feed)
        ->update([
            'status' => '1'
        ]);
        return redirect('/feedback');
    }
}
