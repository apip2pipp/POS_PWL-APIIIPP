<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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
    
    public function showSignup()
    {
        $levels = LevelModel::all();
        return view('auth.signup', compact('levels'));
    }
    

    public function postSignup(Request $req)
{
    if (!$req->ajax() && !$req->wantsJson()) {
        return redirect()->back();
    }

    $validator = Validator::make($req->all(), [
        'username' => 'required|string|min:5|max:20|unique:m_user,username',
        'nama' => 'required|string|min:5|max:100',
        'password' => 'required|string|min:6|confirmed',
        'level_id' => 'required|exists:m_level,level_id' // Validate that the level exists
    ]);
    
    

    if ($validator->fails()) {
        return response()->json([
            'message' => 'Validasi Gagal',
            'msgField' => $validator->errors()
        ], Response::HTTP_BAD_REQUEST);
    }

    $user = UserModel::create([
        'username' => $req->username,
        'nama' => $req->nama,
        'level_id' => $req->level_id,
        'password' => Hash::make($req->password)
    ]);

    Auth::login($user);
    
    return response()->json([
        'message' => 'Data pengguna berhasil dibuat',
        'redirect' => url('/')
    ], Response::HTTP_OK);
}
}