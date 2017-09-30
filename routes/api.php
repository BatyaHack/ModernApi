<?php

use Illuminate\Http\Request;
use App\User;


// Доступны только админу
Route::group(['middleware' => 'auth'], function (){

});


Route::put('users/{user}', 'UserController@update'); // edit post
Route::delete('users/{user}', 'UserController@delete'); // delete post


Route::post('register', 'Auth\RegisterController@register'); // add new admin
Route::post('logout', 'Auth\LoginController@logout'); // exit
Route::get('admins', 'UserController@admins'); // reutrn list admin

Route::post('users', 'UserController@store'); // add new post


// Доступны всем
Route::post('login', 'Auth\LoginController@login'); //login
Route::get('users', 'UserController@index'); // all users
Route::get('users/{user}', 'UserController@show'); // solo user


// Перенести в управление DB
Route::get('field', 'FiledController@index'); // all field in data base
Route::post('field', 'FiledController@add'); // create field in data base
