<?php

use App\Http\Controllers\TokenController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // dd(base64_encode(random_bytes(32)));
    return view('welcome');
})->name('home');
Route::get('/identity', [TokenController::class,'identify'])->name('identify');
Route::post('/check-token-from-front-end',[TokenController::class,'check_token'])->name('check.token');
Route::post('/logout-by-frontend',[TokenController::class,'logout_by_frontend'])->name('logout.by.frontend');