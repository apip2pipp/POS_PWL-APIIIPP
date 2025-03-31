<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StokController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PenjualanDetailController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;


// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/level',[LevelController::class,'index']);
// Route::get('/kategori',[KategoriController::class,'index']);
// Route::get('/user',[UserController::class,'index']);


// //practicum 2.6 jobsheet 4
// Route::get('/user/tambah',[UserController::class,'tambah'])->name('/user/tambah');
// Route::get('/user/ubah/{id}',[UserController::class,'ubah'])->name('/user/ubah');
// Route::get('/user/hapus/{id}',[UserController::class,'hapus'])->name('/user/hapus');
// Route::get('/user',[UserController::class,'index'])->name('/user');
// Route::post('/user/tambah_simpan',[UserController::class,'tambah_simpan'])->name('/user/tambah_simpan');
// Route::put('/user/ubah_simpan/{id}',[UserController::class,'ubah_simpan'])->name('/user/ubah_simpan');


// //jobsheet 5
// Route::get('/',[WelcomeController::class,'index']);

// Route :: get ('/public/user', [UserController::class, 'index' ]);
// Route :: get ('/user', [UserController::class, 'index' ]);
Route::get('/', [WelcomeController::class, 'index']);


//user
Route::group(['prefix'=>'user'], function(){
    Route::get('/', [UserController::class, 'index']);
    Route::post('/list', [UserController::class, 'list']);
    Route::get('/create', [UserController::class, 'create']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/create_ajax', [UserController::class, 'create_ajax']);
    Route::post('/ajax', [UserController::class, 'store_ajax']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::get('/{id}/edit', [UserController::class, 'edit']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
    Route::delete('/{id}', [UserController::class, 'destroy']); 
});

// Level
Route::prefix('level')
->controller(LevelController::class)
->group(function () {
Route::get('/', 'index')->name('level.index');
Route::post('/list','list')->name('level.list');
Route::get('/create','create')->name('level.create');
Route::get('/create-ajax', 'createAjax')->name('level.create-ajax');
Route::post('/','store')->name('level.store');
Route::post('/store-ajax', 'storeAjax')->name('level.store-ajax');
Route::get('/{id}', 'show')->name('level.show');
Route::get('/{id}/edit', 'edit')->name('level.edit');
Route::get('/{id}/edit-ajax', 'editAjax')->name('level.edit-ajax');
Route::put('/{id}', 'update')->name('level.update');
Route::put('/{id}/update-ajax', 'updateAjax')->name('level.update-ajax');
Route::delete('/{id}', 'destroy')->name('level.destroy');
Route::get('/{id}/delete-ajax', 'confirmDeleteAjax')->name('level.confirm-delete-ajax');
Route::delete('/{id}/delete-ajax', 'deleteAjax')->name('level.delete-ajax');
});

// Kategori
Route::prefix( 'kategori')
->controller(KategoriController::class)
->group(function () {
Route::get('/', 'index')->name('kategori.index');
Route::post('/list',  'list')->name('kategori.list');
Route::get('/create', 'create')->name('kategori.create');
Route::get('/create-ajax', 'createAjax')->name('kategori.create-ajax');
Route::post('/', 'store')->name('kategori.store');
Route::post('/store-ajax', 'storeAjax')->name('kategori.store-ajax');
Route::get('/{id}', 'show')->name('kategori.show');
Route::get('/{id}/edit', 'edit')->name('kategori.edit');
Route::get('/{id}/edit-ajax', 'editAjax')->name('kategori.edit-ajax');
Route::put('/{id}', 'update')->name('kategori.update');
Route::put('/{id}/update-ajax', 'updateAjax')->name('kategori.update-ajax');
Route::delete('/{id}', 'destroy')->name('kategori.destroy');
Route::get('/{id}/delete-ajax', 'confirmDeleteAjax')->name('kategori.confirm-delete-ajax');
Route::delete('/{id}/delete-ajax', 'deleteAjax')->name('kategori.delete-ajax');
});

// Barang
Route::prefix('barang')
->controller(BarangController::class)
->group(function () {
Route::get('/', 'index')->name('barang.index');
Route::post('/list',  'list')->name('barang.list');
Route::get('/create', 'create')->name('barang.create');
Route::get('/create-ajax', 'createAjax')->name('barang.create-ajax');
Route::post('/', 'store')->name('barang.store');
Route::post('/store-ajax', 'storeAjax')->name('barang.store-ajax');
Route::get('/{id}', 'show')->name('barang.show');
Route::get('/{id}/edit', 'edit')->name('barang.edit');
Route::get('/{id}/edit-ajax', 'editAjax')->name('barang.edit-ajax');
Route::put('/{id}', 'update')->name('barang.update');
Route::put('/{id}/update-ajax', 'updateAjax')->name('barang.update-ajax');
Route::delete('/{id}', 'destroy')->name('barang.destroy');
Route::get('/{id}/delete-ajax', 'confirmDeleteAjax')->name('barang.confirm-delete-ajax');
Route::delete('/{id}/delete-ajax', 'deleteAjax')->name('barang.delete-ajax');
});
