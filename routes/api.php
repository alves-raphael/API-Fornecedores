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
Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/users', "UserController@getAll");

    Route::post('/provider', 'ProviderController@create');

    Route::get('/providers', 'ProviderController@get');

    Route::delete('/provider', 'ProviderController@destroy');
});

Route::post('/user', 'UserController@create');

Route::get('/refresh/token', 'UserController@refreshToken');