<?php

namespace App\Http\Controllers;

use App\Models\Investor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class InvestorController extends Controller
{
    
    public function showLoginForm()
    {
        return view('investor.page.login');
    }
    
    public function showRegisterForm()
    {
        return view('investor.page.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        
        if (Auth::guard('investor')->attempt($credentials)) {
            return redirect()->route('investor.index');
        }else {
            Log::info('fail');
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:investors',
            'nomor_telepon' => 'required|',
            'password' => 'required|string|min:8',
        ]);
        $validated['password'] = Hash::make($validated['password']);

        Investor::create($validated);

        return redirect('/investor/login')->with('success','Registrasi Berhasil, Silahkan Login');


        // Auth::guard('investor')->login($investor);

        // return redirect()->intended('/investor-dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('investor')->logout();
        return redirect()->route('investor.login');
    }

    public function index()
    {
        return view('investor.page.dashboard');
    }

    
}
