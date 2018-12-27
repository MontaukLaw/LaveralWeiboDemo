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

//getConfirm
//Route::post('get_confirm','UsersController@getConfirm')->name('get_confirm');

//Route::get('/users/{user}', 'UsersController@show')->name('users.show');
//看字面意思, 一个是显示登陆页面, 一个是登入, 一个是登出
Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');

//这个路由有个通配符或者说正则, 将token传到UsersController的confirmEmail这个function处理
//http://weibo.test/signup/confirm/O1TTEr3faVq4fpzFXaOVQD4EAO9mQL
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');

//忘记密码页面, 这个路由链接一般在哪儿呢? 当然是登陆页面
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//发送link email
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//密码更新页面
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//更新密码
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

//微博发帖删帖相关的路由
Route::resource('statuses', 'StatusesController', ['only' => ['store', 'destroy']]);

//显示粉丝跟你粉的人数
Route::get('/users/{user}/followings', 'UsersController@followings')->name('users.followings');
Route::get('/users/{user}/followers', 'UsersController@followers')->name('users.followers');
