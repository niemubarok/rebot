<?php

use App\Http\Controllers\agController;
use Illuminate\Support\Facades\Route;

Route::post('ag', [agController::class, 'replyMessage']); //atlantic-group.id
Route::get('ag', function(){
    return "work";
}); //atlantic-group.id