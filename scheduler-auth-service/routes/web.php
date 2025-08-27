<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



// <?php

// use App\Http\Controllers\UserController;
// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

// Route::prefix('v1')->group(function () {
//     dd('v1');
//     Route::prefix('users')->group(function () {
//         Route::post('/register', [UserController::class, 'register']);
        
//     });
    
// });