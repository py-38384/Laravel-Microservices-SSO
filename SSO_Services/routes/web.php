<?php

use App\Http\Controllers\PrimaryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthManagementController;

Route::get('/', function () {
    return view('welcome');
});
Route::group(["middleware" => ["guest"]], function () {
    Route::get('/login',[AuthManagementController::class, 'show_login'])->name('show.login');
    Route::post('/login',[AuthManagementController::class, 'login'])->name('login');
});
Route::group(["middleware" => ["auth"]], function () {
    Route::get('/dashboard',[PrimaryController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout',[AuthManagementController::class, 'logout'])->name('logout');
    Route::get('/token-logout',[AuthManagementController::class, 'token_logout'])->name('token_logout');
});
Route::get('/check-auth',[AuthManagementController::class, 'checkAuth'])->name('check.auth');