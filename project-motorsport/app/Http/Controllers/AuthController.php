<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Cek jika sudah login, lempar ke index
        if (session()->has('user')) return redirect()->route('home');
        return view('login');
    }

    public function login(Request $request)
    {
        $valid_user = "admin";
        $valid_pass = "123";

        if ($request->username == $valid_user && $request->password == $valid_pass)
        {
            // Set Session Laravel
            session(['user' => $request->username]);
            return redirect()->route('home');
        }

        // Jika gagal, kembalikan ke login dengan pesan error
        return back()->with('error', 'Username atau Password salah!');
    }

    public function logout()
    {
        session()->forget('user'); // Hapus session
        return redirect()->route('home');
    }
}