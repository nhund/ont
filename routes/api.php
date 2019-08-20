<?php

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

Route::namespace('Api')->group(function () {

    Route::namespace('User')->group(function () {
        Route::prefix('me')->group(function () {
            Route::get('/', 'UsersController@show');
            Route::post('/', 'UsersController@update');
        });
    });

    Route::namespace('Lesson')->group(function () {

    });

    Route::namespace('Question')->group(function () {

    });
});
