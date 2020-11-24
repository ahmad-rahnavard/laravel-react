<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function () {

    Route::post("register", "RegisterController")->name('register');
    Route::post("login", "LoginController@login")->name('login');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post("logout", "LoginController@logout")->name('logout');
        Route::get("table-data", "TableDataController@index")->name('table-data');
    });

});
