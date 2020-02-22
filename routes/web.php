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

Route::get('/')
    ->name('wants')
    ->uses('WantsController@index');

Route::get('wants/{want}/{category}/{slug}')
    ->name('want')
    ->uses('WantsController@show');

// Route::get('categories', function () {
//     return view('categories');
// });
