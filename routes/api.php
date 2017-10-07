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


Route::post('auth/register', 'UserController@register');
Route::post('auth/login', 'UserController@login');
Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('user', 'UserController@getAuthUser');
});


// роуты для работы с персоналом
Route::get('personal', 'PersonalController@index');
Route::get('personal/{persona}', 'PersonalController@show');
Route::post('personal', 'PersonalController@store');
Route::put('personal/{persona}', 'PersonalController@update');
Route::delete('personal/{persona}', 'PersonalController@delete');

