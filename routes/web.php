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
//看字面意思, 一个是显示登陆页面, 一个是登入, 一个是登出
Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');

//这个路由有个通配符或者说正则, 将token传到UsersController的confirmEmail这个function处理
//http://weibo.test/signup/confirm/O1TTEr3faVq4fpzFXaOVQD4EAO9mQL
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');