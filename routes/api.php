<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LevelController;
use App\Http\Controllers\Api\KategoriController;
use App\Models\KategoriModel;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('/register', RegisterController::class)->name('register');
Route::post('/login', LoginController::class)->name('login');
Route::post('/logout', LogoutController::class)->name('logout');

Route::get('/level', [LevelController::class, 'index']);
Route::post('/level', [LevelController::class, 'store']);
Route::get('/level/{level}', [LevelController::class, 'show']);
Route::put('/level/{level_id}', [LevelController::class, 'update']);
Route::delete('/level/{level_kode}', [LevelController::class, 'destroy']);


Route::prefix('user')
    ->controller(UserController::class)
    ->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{user}', 'show');
    Route::put('/{user}', 'update');
    Route::delete('/{user}', 'destroy');
});

Route::get('/kategori', [KategoriController::class, 'index']);
Route::post('/kategori', [KategoriController::class, 'store']);
Route::get('/kategori/{kategori}', [KategoriController::class, 'show']);
Route::put('/kategori/{kategori_id}', [KategoriController::class, 'update']);
Route::delete('/kategori/{kategori_kode}', [KategoriController::class, 'destroy']);
