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

Route::group( ['prefix' => 'v1' ,'middleware' => ['auth:api']], function () {
    Route::get('/publications', 'Api\PublicationsController@index')->name('api.publications.index');
    Route::get('/publications/{publicationAPI}', 'Api\PublicationsController@show')->name('api.publications.show');

    Route::post('/publications', 'Api\PublicationsController@store')->name('api.publications.store');

    Route::put('/publications/{publication}', 'Api\PublicationsController@update')->name('api.publications.update');

    Route::delete('/publications/{publication}', 'Api\PublicationsController@destroy')->name('api.publications.destroy');
});
