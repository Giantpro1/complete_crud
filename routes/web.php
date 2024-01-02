<?php

use App\Http\Controllers\ProductCategory;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
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
    Route::post('register', 'StoreUsers');
    Route::get('login', 'login')->name('login');
    Route::post('login', '__LoginUSer');
    Route::get('logout', 'logoutUser')->middleware('auth')->name('logout');
});

Route::get('/', function () {
    return view('welcome');
});


// Route::get('/index', function () {
//     return view('index');
// });

Route::middleware('auth')->group(function(){
    Route::get('index', function(){
        return view('index');
    })->name('index');
    Route::get('/profile', [App\Http\Controllers\AuthController::class, 'profile'])->name('profile');
    Route::get('/userProfileSetting', [App\Http\Controllers\AuthController::class, 'userProfileSetting'])->name('userProfileSetting');
    Route::get('/usersecuritysetting', [App\Http\Controllers\AuthController::class, 'userSecuritySetting'])->name('usersecuritysetting');
    Route::put('/userProfileSetting/update', [App\Http\Controllers\AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/update-password', [App\Http\Controllers\AuthController::class, 'updatePassword'])->name('updatePassword');
    Route::get('/productlist', [ProductController::class, 'productList']);
    Route::get('/addproduct', [ProductController::class, 'addProducts']);
    Route::get('/categorylist', [ProductCategory::class, 'productCategory'])->name('productCategory');
    Route::post('/submit-category', [ProductCategory::class, 'submitCategory'])->name('submitCategory');
});

