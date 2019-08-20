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

    Route::namespace('User/Admin')->group(function () {
        Route::source();
    });

    Route::namespace('Lesson/Admin')->group(function () {

    });

    Route::namespace('Question/Admin')->group(function () {

    });
});

