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

use Illuminate\Support\Facades\Artisan;

Artisan::call('cache:clear');

Route::get('/', function () {
   return view('layout.master');
});

Route::get('/login', function () {
   return view('layout.master');
});

