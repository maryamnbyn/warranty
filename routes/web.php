<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(['as'=>'admin.','namespace' => 'Admin' ,'prefix' => 'admin' ] ,function(){
    Route::resource('/users', 'UserController')->except('show');
    Route::resource('/products', 'ProductController')->except('show');
    Route::get('/dashboard', 'UserController@dashboard')->name('adminpannel');
});