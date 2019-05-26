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

Route::group(['namespace' => 'API\V1', 'prefix' => 'v1' ], function () {

    Route::post('/user/edit', 'UserController@update');
    Route::post('/update/verify', 'UserController@verificationUpdate');
    Route::post('/register/verify', 'UserController@verification');
    Route::post('/register', 'UserController@register');
    Route::post('/login', 'UserController@login');
    Route::post('/logout', 'UserController@logout');

});


