<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()       
    {
        // // tambah data user dengan Eluquenr Model
        $data = [
            'username' => 'customer-1',
            'name' => 'Pelanggan',
            'password' => Hash::make('12345'),
            'level_id' => 18
        
       

        
            // 'name' => 'Pelanggan Pertama'
        ];
        // UserModel::insert($data); // tambahkan data ke table m_user
        // UserModel::where('username', 'customer-1') -> update($data); // update data user
        //  coba akses model UserModel
        $user = UserModel::all(); // ambil semua data dari tabel m_user
        return view('user', ['data' => $user]);
    }
}