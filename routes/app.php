<?php

/*
|--------------------------------------------------------------------------
| App Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
if (App::environment('production')) {
	URL::forceScheme("https");
}
Route::get('/get-question', 'App\AppController@getQuestion')->name('getQuestion');
Route::get('/get-lythuyet', 'App\AppController@getLythuyet')->name('getLythuyet');
