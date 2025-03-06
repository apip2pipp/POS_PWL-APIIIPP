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
        // $data = [
        //     'level_id' => 2,
        //     'username' => 'manager_TIGA',
        //     'name' => 'Manager 3',
        //     'password' => Hash::make('12345')
            
        //     // 'name' => 'Pelanggan Pertama'
        // ];
        // UserModel::create($data);
        // UserModel::insert($data); // tambahkan data ke table m_user
        // UserModel::where('username', 'customer-1') -> update($data); // update data user
        //  coba akses model UserModel
        $user = UserModel::find(1); // ambil semua data dari tabel m_user
        return view('user', ['data' => $user]);
    }
}