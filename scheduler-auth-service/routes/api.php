<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('v1')->group(function () {

    Route::prefix('users')->group(function () {
        Route::post('/register', [UserController::class, 'register']);
        Route::post('/verify', [UserController::class, 'verify']);
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::prefix('users/info')->middleware('auth:sanctum')->group(function () {
        Route::post('/social-accounts', [UserController::class, 'socialDocuments']);
        Route::post('/work-place', [UserController::class, 'userWorkPlaceInfo']);
        Route::post('/interests', [UserController::class, 'interest']);
    });


    Route::prefix('auth')->group(function () {
        Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink']);
        Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);
    });
});
