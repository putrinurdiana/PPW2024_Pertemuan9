<?php

use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BukuController;




Route::resource('products', ProductController::class);


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

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/about', function () {
//     return view('about', [
//         'name' => 'Putri Nurdiana',
//         'email' => 'putinurdiana@mail.com']);
// });


// Route::get('/tambah', function () {
//     return view('tambah', [
//         'name' => 'Putri Nurdiana',
//         'email' => 'putinurdiana@mail.com']);
// });

// Route::get('/contoh', function () {
//     return view('contoh'
//     );
// });

Route::get('/app', function () {
    return view('app'
    );
});

Route::get('/navbar', function () {
    return view('navbar');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/services', function () {
    return view('services');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/layout', function () {
    return view('layout');
});

Route::get('/posts', [PostController::class, 'index']);

Route::get('/products', [ProductController::class, 'index'])->name('index');

Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::post('/logout', 'logout')->name('logout');
});

Route::middleware('auth')->group(function() {
    Route::resource('/buku', BukuController::class);
});