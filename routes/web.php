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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', 'StaticPagesController@home')->name('home');

Route::get('/help', 'StaticPagesController@help')->name('help');

Route::get('/about', 'StaticPagesController@about')->name('about');

Route::get('signup', 'UsersController@create')->name('signup');

//相当于 get:index,get:create,get:show,post:store,patch:update,delete:destroy
Route::resource('users','UsersController');

//Route::get('/users/{user}', 'UsersController@show')->name('users.show');