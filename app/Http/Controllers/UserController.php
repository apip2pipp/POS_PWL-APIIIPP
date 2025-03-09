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
        // $user = UserModel::findOr(2,['username','name'],function(){
        //     abort(404);
        // });
        // return view ('user',['data'=>$user]);
        
        //PRAKTIKUM 2.2 JOBSHEET 4 STEP 1
        // $user = UserModel::findOrFail(1);
        // return view('user',['data'=>$user]);

        //PRAKTIKUM 2.3 JOBSHEET 4 STEP 1
        // $user = UserModel::where('level_id',2)->count();
        // dd($user);
        // return view('user',['data'=>$user]);

        //PRAKTIKUM 2.4 JOBSHEET 4 STEP 3
        // $user = UserModel::firstOrCreate(
        // [
        //         'username' => 'manager',
        //         'name' => 'Manager',
        // ],
        // );
        // return view('user',['data'=>$user]);
        
        //PRAKTIKUM 2.4 JOBSHEET 4 STEP 5
        // $user = UserModel::firstOrCreate(
        // [
        //         'username' => 'manager22',
        //         'name' => 'Manager dua duaa',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2,
        // ],
        // );
        // return view('user',['data'=>$user]);

         //PRAKTIKUM 2.4 JOBSHEET 4 STEP 7
        // $user = UserModel::firstOrNew(
        // [
        //         'username' => 'manager33',
        //         'name' => 'Manager ',
                
        // ],
        // );
        // return view('user',['data'=>$user]);
        
        //PRAKTIKUM 2.4 JOBSHEET 4 STEP 9
        // $user = UserModel::firstOrNew(
        // [
        //         'username' => 'manager33',
        //         'name' => 'Manager tigaHJ Tigahj',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2,
        // ],
        // );
        // return view('user',['data'=>$user]);
        
        //PRAKTIKUM 2.4 JOBSHEET 4 STEP 11
        // $user = UserModel::firstOrNew(
        // [
        //         'username' => 'manager33',
        //         'name' => 'Manager tigaHJ Tigahj',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2,
        // ],
        // );
        // $user->save();
        // return view('user',['data'=>$user]);

        //PRAKTIKUM 2.5 JOBSHEET 4 STEP 2
        // $user = UserModel::create([
        //     'username' => 'manager55',
        //     'name' => 'Manage55',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2,
        // ]);

        // $user->username = 'manager56';

        // $user->isDirty(); // true
        // $user->isDirty('username'); // true
        // $user->isDirty('name'); // false
        // $user->isDirty(['name', 'username']); // true

        // $user->isClean(); // false
        // $user->isClean('username'); // false
        // $user->isClean('name'); // true
        // $user->isClean(['name', 'username']); // false

        // $user->save();

        // $user->isDirty(); // false
        // $user->isClean(); // true
        // dd($user->isDirty());
        
        //PRAKTIKUM 2.5 JOBSHEET 4 STEP  4
        // $user = UserModel::create([
        //     'username' => 'manager13',
        //     'name' => 'Manager11', 
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2,
        // ]);

        // $user->username = 'manager13';

        // $user->save();

        // $user->wasChanged(); // true
        // $user->wasChanged('username'); // true 
        // $user->wasChanged(['username', 'level_id']); // true
        // $user->wasChanged('name'); // false
        // $user->wasChanged(['name', 'username']); // true
        // dd($user->wasChanged(['name','username']));

        //PRAKTIKUM 2.6 JOBSHEET 4 STEP  4
        // $user = UserModel::all();
        // return view('user',['data'=>$user]);
    
        //praktikum2.7 jobsheet 4 step2
        $user = UserModel::with('level')->get();
        return view('user',['data'=>$user]);
    }

    
        //PRAKTIKUM 2.6 JOBSHEET 4 STEP  5
        public function tambah(){
            return view('user_tambah');
        }
        
        //PRAKTIKUM 2.6 JOBSHEET 4 STEP  10
        public function tambah_simpan(Request $request){
            UserModel::create([
                'username'=> $request->username,
                'name'=> $request->name,
                'password'=> Hash::make($request->password),
                'level_id'=> $request->level_id
            ]);
            return redirect('/user');
        }

        //PRAKTIKUM 2.6 JOBSHEET 4 STEP  12
        public function ubah($id){
            $user=UserModel::find($id);
            return view('user_ubah',['data'=>$user]);
        }
        
        
        public function ubah_simpan($id, Request $request){
            $user = UserModel::find($id);
            $user->username = $request->username;
            $user->name = $request->name;
            $user->level_id = $request->level_id;
            $user->save();
    
            return redirect('/user');
        }

         // Menghapus user
    // public function hapus($id)
    // {
    //     UserModel::destroy($id);
    //     return redirect('/user');
    // }

    //PRAKTIKUM 2.6 JOBSHEET 4 STEP  16
    public function hapus($id)
    {
        $user = UserModel::find($id);
        $user->delete();
        return redirect('/user');
    }

    
}