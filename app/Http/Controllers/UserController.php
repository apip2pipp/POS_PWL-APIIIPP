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
        // $user = UserModel::all(); // ambil semua data dari tabel m_user
        

        //PRAKTIKUM 2.1 JOBSHEET 4 STEP 1
        // $user = UserModel::find(1);
        // return view('user', ['data' => $user]);

        //PRAKTIKUM 2.1 JOBSHEET 4 STEP 4
        // $user = UserModel::where('level_id',1)->first();
        // return view('user', ['data' => $user]);

        //PRAKTIKUM 2.1 JOBSHEET 4 STEP 6
        // $user = UserModel::firstWhere('level_id',2);
        // return view ('user', ['data' => $user]);

        //PRAKTIKUM 2.1 JOBSHEET 4 STEP 9
        // $user = UserModel::findOr(1,['username','name'],function(){
        //     abort(404);
        // });

        // return view ('user',['data'=>$user]);
        
        //PRAKTIKUM 2.1 JOBSHEET 4 STEP 11
        $user = UserModel::findOr(2,['username','name'],function(){
            abort(404);
        });

        return view ('user',['data'=>$user]);
    }
}