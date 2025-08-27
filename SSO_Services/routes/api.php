<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrimaryController;
use App\Http\Controllers\AuthManagementController;

Route::post('/user', [AuthManagementController::class, 'get_user_data']);

Route::get('/check-auth',[PrimaryController::class, 'checkAuth'])->name('check.auth');
