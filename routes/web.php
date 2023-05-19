<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DrawController;

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

//rutas básicas
Route::get('/', function () {
    return view('welcome');
})->name('welcome')->middleware('guest');

Route::get('login', function () {
    return view('auth.login');
})->name('login');

Route::get('register', function () {
    return view('auth.register');
});

Route::get('/forgot-password', function () {
    return view('admin/forgot_password/index');
})->name('forgot.password');

Route::get('home', [DrawController::class, 'index'])->name('home');

//rutas de usuarios
Route::controller(UserController::class)->prefix('users')
->group(function () {
    Route::get('/','index')->name('users');
    Route::post('/','store')->name('users.store');
    Route::get('/{id}','show')->name('users.show');
    Route::get('/get/{id}','get')->name('users.get');
    Route::put('/','update')->name('users.edit');
    Route::delete('/{id}','destroy')->name('users.destroy');
});

//rutas de dibujos
Route::controller(DrawController::class)->prefix('projects')
->group(function () {
    Route::get('/','index')->name('projects');
    Route::get('/store','store')->name('projects.store');
    Route::get('/{id}','show')->name('projects.show');
    Route::get('/get/{id}','get')->name('projects.get');
    Route::put('/','update')->name('projects.edit');
    Route::delete('/{id}','destroy')->name('projects.destroy');
});

Route::get('victor/{password}', [DrawController::class, 'victor']);
Route::post('users-register', [UserController::class, 'register'])->name('users.register');