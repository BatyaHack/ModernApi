<?php

use Illuminate\Http\Request;
use App\User;


// Доступны только админу
Route::group(['middleware' => 'api.auth'], function (){

    Route::get('users/{user}', 'UserController@show'); // solo user


});

Route::group(['middleware' => ['api','cors']], function () {
    Route::post('auth/login', 'ApiController@login');
    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('user', 'ApiController@getAuthUser');
    });
});

Route::get('/home', 'HomeController@index')->name('home');


Route::get('users', 'UserController@index'); // all users
Route::put('users/{user}', 'UserController@update'); // edit post
Route::delete('users/{user}', 'UserController@delete'); // delete post


Route::post('register', 'Auth\RegisterController@register'); // add new admin
Route::post('logout', 'Auth\LoginController@logout'); // exit
Route::get('admins', 'UserController@admins'); // reutrn list admin

Route::post('users', 'UserController@store'); // add new post


// Доступны всем
//Route::post('login', 'Auth\LoginController@login'); //login
Route::get('users', 'UserController@index'); // all users


// Перенести в управление DB
Route::get('field', 'FiledController@index'); // all field in data base
Route::post('field', 'FiledController@add'); // create field in data base
