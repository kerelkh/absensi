<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginPage(Request $request) {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if(Auth::user()->role->id == 2){
                return redirect('/admin/kepegawaian')->with('success', 'Selamat Datang');
            }else if(Auth::user()->role->id = 3) {
                return redirect('/admin/dinas')->with('success', 'Selamat Datang');
            }else{
                return redirect('/')->with('success', 'Selamat Datang');
            }
        }

        return back()->with('error', 'Gagal Login');
    }

    public function logout(Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
