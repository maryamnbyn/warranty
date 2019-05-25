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

//product route

Route::group(['namespace' => 'API\V1', 'prefix' => 'v1' ,'middleware' => 'auth:api'], function () {

    Route::post('/verification', 'UserController@verification');
    Route::post('/user/edit', 'UserController@update');
    Route::post('/sendsms', 'UserController@sendSMS');
});
//login and register route

Route::group(['namespace' => 'API\V1', 'prefix' => 'v1'], function () {
    Route::post('/register', 'UserController@register');
    Route::post('/login', 'UserController@login');
});

