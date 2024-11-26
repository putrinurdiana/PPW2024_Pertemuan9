<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
use App\Http\Controllers\InfoController;
Route::get('/info', [InfoController::class, 'index'])->name('info');

use App\Http\Controllers\GreetController;
Route::get('/greet', [GreetController::class, 'greet'])->name('greet');

use App\Http\Controllers\GaleryController;
Route::get('/gallery', [GaleryController::class, 'api']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
