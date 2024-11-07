<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(){
        return view('backend.v_login.login', [
            'judul' => 'halaman login'
        ]);
    }
    public function auth(Request $request){
        $credential = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (Auth::attempt($credential)){
            if (Auth::user()->status  == 0){
                Auth::logout();
                return back()->with('error', 'login dlu bang!!');
            }
            $request->session()->regenerate();
            return redirect()->intended(Route('backend.index'));
        }
        return back()->with('error', 'Loginnya gagal!!!');
    }
    public function logout(){
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect(Route('backend.login'));
    }
}
