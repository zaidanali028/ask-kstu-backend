<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route::controller(AuthController::class)->group(function () {
//     Route::get('me', 'get_auth_user');
//     Route::post('register', 'register');
//     Route::post('logout', 'logout');
//     Route::post('login', 'login');
//     Route::post('refresh', 'refresh');

// });

// prefix of api is /api/v1/{route-here}
// Example: http://127.0.0.1:8000/api/v1/login|me|register.....
Route::prefix('/v1')->namespace('App\Http\Controllers')->group(function () {
        Route::get('me', 'AuthController@get_auth_user');
    Route::post('register', 'AuthController@register');
    Route::post('logout', 'AuthController@logout');
    Route::post('login', 'AuthController@login');
    Route::post('refresh', 'AuthController@refresh');
   
   



});