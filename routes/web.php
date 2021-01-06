<?php

use App\Http\Controllers\CheckInController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "not allowed";
});

Route::get('/checkin', [CheckInController::class, 'index'])->name('form');
Route::post('/checkin', [CheckInController::class, 'checkedIn'])->name('checkedIn');
Route::post('/print', [CheckInController::class, 'print'])->name('print');
Route::get('/tes', [CheckInController::class, 'tesGuzzle']);

