<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
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

Route::get('/login', function () {
    return view('login');
    
})->middleware('guest');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register'); // ユーザー登録フォームの表示
Route::post('/register', [RegisterController::class, 'register']); // ユーザー登録処理

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [ProductController::class, 'index'])->name('home');
    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::resource('products', ProductController::class);
    
});
    
