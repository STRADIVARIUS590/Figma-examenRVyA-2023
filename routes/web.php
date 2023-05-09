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
});



Route::get('draw/{id}', [DrawController::class, 'show']);
Route::get('home', [DrawController::class, 'index']);


/* 
CANVAS{
    width:100
    heigth: 100
}
,
FIGURES[
    {
        type: SQUARE
        position_x = 10,
        position_y = 20,
    },
    {
        type: LINE
        position_x = 10,
        position_y = 20,
    }
]




*/
