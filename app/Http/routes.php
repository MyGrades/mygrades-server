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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'api/v1', 'middleware' => 'auth.basic'], function () {
    Route::get('universities', ['uses' => 'UniversityController@index']);
    Route::get('universities/{university}', ['uses' => 'UniversityController@show']);

    // TODO: implement Controller
    //Route::post('universities/{university}/wish', ['uses' => '']);
    //Route::post('universities/{university}/errors', ['uses' => '']);
});
