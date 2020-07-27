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
    Route::group([
        'prefix' => 'todo',
        'middleware' => 'role:viewer|admin|super-admin'
    ], function () {
        Route::post('get', 'AuthController@getTodo');
        Route::post('create', 'AuthController@createTodo');
        Route::post('delete/{todo}', 'AuthController@deleteTodo');
        Route::post('update/{todo}', 'AuthController@editTodo');
    });
});
Route::post('register', 'RegisterController@register');

Route::group([
    'middleware' => ['role:admin|super-admin'],
    'prefix' => 'admin'
], function($router){
    Route::post('users', 'AdminController@index');
    Route::post('show/{user}', 'AdminController@show');
    Route::post('delete/{user}', 'AdminController@delete');
    Route::post('create', 'AdminController@create');
    Route::post('update/{user}', 'AdminController@update');
    Route::group(['prefix' => 'todo'], function($router){
        Route::post('get', 'TodoController@index');
        Route::post('{user}/get', 'TodoController@get');
        Route::post('delete/{todo}', 'TodoController@destroy');
    });
});

