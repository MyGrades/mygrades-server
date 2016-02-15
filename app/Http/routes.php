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

Route::get('impressum', function () {
    return view('impressum');
})->name("impressum");

Route::get('datenschutz', function () {
    return view('datenschutz');
})->name("datenschutz");

Route::group(['prefix' => 'admin', 'middleware' => ['auth.adminbasic']],  function () {
    Route::get('wishes', 'WishController@indexAdmin')->name("adminWishes");
    Route::post('wishes/update', 'WishController@updateAdmin')->name('adminWishesUpdate');

    Route::get('errors', 'ErrorController@indexAdmin')->name("adminErrors");
    Route::post('errors/update', 'ErrorController@updateAdmin')->name('adminErrorsUpdate');
});

Route::group(['prefix' => 'api/v1', 'middleware' => ['logging', 'auth.basic']], function () {
    Route::get('universities', ['uses' => 'UniversityController@index']);
    Route::get('universities/{university}', ['uses' => 'UniversityController@show']);

    Route::post('/wishes', ['uses' => 'WishController@create']);
    Route::post('/errors', ['uses' => 'ErrorController@create']);
});
