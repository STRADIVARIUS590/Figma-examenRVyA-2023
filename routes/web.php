<?php

use App\Http\Controllers\DrawController;
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

Route::get('/', function () {
    return view('welcome');
})->name('welcome')->middleware('guest');

Route::get('login', function () {
    return redirect('/');
})->name('login');

Route::get('register', function () {
    return redirect('/');
});

Route::get('/forgot-password', function () {
    return view('admin/forgot_password/index');
})->name('forgot.password');

Route::get('draw/{id}', [DrawController::class, 'show']);
Route::get('home', [DrawController::class, 'index']);