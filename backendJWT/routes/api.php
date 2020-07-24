<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::post('register', 'RegisterController@register');

Route::group([
    'prefix' => 'admin'
], function($router){
    Route::post('users', 'AdminController@index');
    Route::post('show/{user}', 'AdminController@show');
    Route::post('delete/{user}', 'AdminController@delete');
    Route::post('create', 'AdminController@create');
    Route::post('update/{user}', 'AdminController@update');
});