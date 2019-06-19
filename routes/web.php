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
    Route::get('/profile', 'AdminController@Profile')->name('profile');
    Route::resource('/products', 'ProductController')->except('show');
    Route::get('/dashboard', 'UserController@dashboard')->name('adminpannel');
    Route::get('user/{user}/profile', 'UserController@showProfile')->name('users.profile');
    Route::post('profile/update/{user}', 'AdminController@update')->name('profile.update');
});

Route::get('/', 'admin\AdminController@index')->name('index');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

