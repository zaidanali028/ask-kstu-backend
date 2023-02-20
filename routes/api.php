<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::get('me', 'get_auth_user');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('login', 'login');
    // Route::post('refresh', 'refresh');

});


// Route::post('/register', [AuthController::class, 'register']);
// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/logout', [AuthController::class, 'logout']);
