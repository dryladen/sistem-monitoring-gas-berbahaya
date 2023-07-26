<?php

use App\Http\Controllers\HomeController;
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
Route::post('/',[HomeController::class, 'login']);

// Route::get('/')
Route::group(['middleware'=>['auth']],function(){
    Route::get('/logout',[HomeController::class,'logout']);
    Route::get('/home',[HomeController::class,'home']);
    });

