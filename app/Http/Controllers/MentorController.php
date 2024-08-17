<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

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
