<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenjualanDetailController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/level',[LevelController::class,'index']);
Route::get('/kategori',[KategoriController::class,'index']);
Route::get('/user',[UserController::class,'index']);


//practicum 2.6 jobsheet 4
Route::get('/user/tambah',[UserController::class,'tambah'])->name('/user/tambah');
Route::get('/user/ubah/{id}',[UserController::class,'ubah'])->name('/user/ubah');
Route::get('/user/hapus/{id}',[UserController::class,'hapus'])->name('/user/hapus');
Route::get('/user',[UserController::class,'index'])->name('/user');
Route::post('/user/tambah_simpan',[UserController::class,'tambah_simpan'])->name('/user/tambah_simpan');


// Route :: get ('/public/user', [UserController::class, 'index' ]);
// Route :: get ('/user', [UserController::class, 'index' ]);