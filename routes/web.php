<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'UrlController@create');
Route::post('/', 'UrlController@store');
Route::get('/{shorten}', 'UrlController@show');
Route::get('/{shorten}/info', 'UrlInfoController@show');
