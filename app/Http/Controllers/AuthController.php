<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login()
    {
        if (!Auth::check()) {
            return view('auth.login');
        }

        return redirect('/');
    }

    public function postLogin(Request $req)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            return redirect(route('login'));
        }

        $credentials = $req->only('username', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Login Gagal!'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'message' => 'Login Berhasil',
            'redirect' => url('/')
        ]);
    }

    public function logout(Request $req)
    {
        Auth::logout();

        $req->session()->invalidate();
        $req->session()->regenerateToken();

        return redirect('login');
    }

   
}