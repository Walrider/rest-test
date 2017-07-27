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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', 'AdminDashboardController@index')
    ->name('dashboard');

Route::resource('admin/publications', 'PublicationsController', ['except' => ['show']]);

Route::resource('admin/tags', 'TagsController', ['except' => ['show']]);
