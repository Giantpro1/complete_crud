<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::controller(AuthController::class)->group(function(){
    Route::get('register', 'register')->name('register');
    // Route::post('register', 'registerSave')->name('register.save');
    Route::get('login', 'login')->name('login');
    // Route::post('login', 'loginAction')->name('login.action');
    // Route::get('logout', 'logout')->middleware('auth')->name('logout');
});

Route::get('/', function () {
    return view('welcome');
});


Route::get('/index', function () {
    return view('index');
});
