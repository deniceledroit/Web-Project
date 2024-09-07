<?php

use Illuminate\Support\Facades\Auth;
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

Route::redirect('/', '/login');

Auth::routes();
Route::middleware('apirest.check')->group(function(){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('booking',\App\Http\Controllers\BookingController::class);
    Route::resource('car',\App\Http\Controllers\CarController::class);
    Route::resource('customer',\App\Http\Controllers\CustomerController::class);
    Route::resource('user',\App\Http\Controllers\UserController::class);
});

