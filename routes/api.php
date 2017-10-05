<?php

use Illuminate\Http\Request;
use App\User;


// Доступны только админу
Route::group(['middleware' => 'auth'], function (){

    Route::get('users/{user}', 'UserController@show'); // solo user


});


Route::get('/home', 'HomeController@index')->name('home');
// Маршруты аутентификации...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Маршруты регистрации...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');








Route::get('users', 'UserController@index'); // all users
Route::put('users/{user}', 'UserController@update'); // edit post
Route::delete('users/{user}', 'UserController@delete'); // delete post


Route::post('register', 'Auth\RegisterController@register'); // add new admin
Route::post('logout', 'Auth\LoginController@logout'); // exit
Route::get('admins', 'UserController@admins'); // reutrn list admin

Route::post('users', 'UserController@store'); // add new post


// Доступны всем
Route::post('login', 'Auth\LoginController@login'); //login
Route::get('users', 'UserController@index'); // all users


// Перенести в управление DB
Route::get('field', 'FiledController@index'); // all field in data base
Route::post('field', 'FiledController@add'); // create field in data base
