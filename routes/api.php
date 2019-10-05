<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', 'AuthenticationController@login');
    Route::post('/register', 'AuthenticationController@register');
    Route::get('/check', 'AuthenticationController@check');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::get('/logout', 'AuthenticationController@logout');
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::get('/callbacks', 'AdminController@callbacks');
        Route::get('/callbacks/{callback}', 'AdminController@view');
        Route::post('/callbacks/{callback}/archive', 'AdminController@archive');
        Route::post('/callbacks/{callback}/comment', 'AdminController@comment');
    });
});

Route::post('/callback/times', 'CallbackController@times');
Route::post('/callback/submit', 'CallbackController@submit');
