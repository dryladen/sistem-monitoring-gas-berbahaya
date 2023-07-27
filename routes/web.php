<?php

use App\Http\Controllers\FuzzyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('login');
Route::post('/', [HomeController::class, 'login']);

// Route::get('/')
Route::group(['middleware' => ['auth']], function () {
    Route::get('/logout', [HomeController::class, 'logout']);
    Route::get('/home', [HomeController::class, 'home']);
    Route::get('/riwayat_monitoring', [FuzzyController::class, 'index']);

    // Crud data user
    Route::get('/user',[UserController::class,'index']);
    Route::post('/user/store',[UserController::class,'store']);
    Route::post('/user/update/{id}',[UserController::class,'update']);
    Route::get('/user/delete/{id}',[UserController::class,'destroy']);
});
