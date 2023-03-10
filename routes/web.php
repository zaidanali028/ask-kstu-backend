<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/ref', function () {
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('route:cache');
    Artisan::call('clear-compiled');
    Artisan::call('config:clear');
    Artisan::call('config:cache');

    $routes = Route::getRoutes();
    $result = [];
    foreach ($routes as $route) {
        $result[] = [
            'method' => $route->methods()[0], // get HTTP method
            'uri' => $route->uri(), // get URI
            'name' => $route->getName(), // get route name
            'action' => $route->getActionName(), // get controller action name
        ];
    }
    $result['success_msg']="Routes Cleared Successfully :)";
    return $result;
});


Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function () {

    Route::get('login', 'adminController@login');

    Route::group(['middleware' => ['admin']], function () {
        // ensure the client is an authernticated admin
    Route::get('dashboard', 'adminController@dashboard');
    Route::get('logout', 'adminController@logout');

    // announcement utilities
    Route::get('/announcement-util/categories', 'adminController@categories');
    Route::get('/announcement-util/anouncements', 'adminController@anouncements');
    Route::get('/announcement-util/announcement-details', 'adminController@announcement_details');


    //faculty utilities
    Route::get('/school-util/faculties', 'adminController@faculties');
    Route::get('/school-util/programs', 'adminController@programs');
    Route::get('/school-util/departments', 'adminController@departments');







        Route::get('/linkstorage', function () {
            Artisan::call('storage:link');
            dd('Storage link :)');
        });



    });



});