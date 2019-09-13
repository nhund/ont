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

Route::namespace('Auth')->group(function () {
    Route::post('login', 'LoginController@store');
    Route::post('register', 'RegisterController@store');
});


Route::middleware(['auth:api'])->namespace('Api')->group(function () {

    Route::namespace('User')->group(function () {

        Route::prefix('me')->group(function () {
            Route::get('/', 'UserController@show');
            Route::post('/', 'UserController@update');
        });
    });

//    Route::namespace('Lesson')->group(function () {
//
//    });
//
//    Route::namespace('Question')->group(function () {
//
//    });
});



Route::namespace('Api')->group(function () {

    Route::namespace('Slide')->prefix('slide')->group(function () {
        Route::get('/', 'SlideController@index');
    });

    Route::namespace('Course')->prefix('courses')->group(function () {
        Route::get('/free', 'CourseController@freeCourses');
        Route::get('/sticky', 'CourseController@StickyCourses');
        Route::get('/other', 'CourseController@otherCourses');
        Route::get('/search', 'CourseController@search');
        Route::get('/{course}/detail', 'CourseController@show');
    });

    Route::namespace('School')->prefix('schools')->group(function () {
        Route::get('/{school_id}/courses', 'SchoolController@index');
        Route::get('/{school_id}/free', 'SchoolController@freeCourses');
        Route::get('/{school_id}/sticky', 'SchoolController@StickyCourses');
        Route::get('/{school_id}/other', 'SchoolController@otherCourses');

    });
});
