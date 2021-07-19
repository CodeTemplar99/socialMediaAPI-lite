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

Route::post('login', 'API\UserController@LoginUser');
Route::post('register', 'API\UserController@RegisterUser');
Route::get('activation/{token}', 'API\UserController@ActivateUser');

Route::group(['middleware' => 'auth:api'], function(){
Route::post('details', 'API\UserController@Userdetails');
});
