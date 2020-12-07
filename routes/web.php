<?php

use App\Http\Controllers\handleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pasienBaruController;


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

Route::get('/', function () {
    return "not allowed";
});

Route::get('/pasienbaru', [pasienBaruController::class, 'input']);
Route::post('/proses', [pasienBaruController::class, 'proses']);
