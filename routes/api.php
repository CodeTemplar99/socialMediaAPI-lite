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

Route::post('login', 'API\Auth\UserController@LoginUser');
Route::post('register', 'API\Auth\UserController@RegisterUser');
Route::get('activation/{token}', 'API\Auth\UserController@ActivateUser');

Route::post('forgot-password', 'API\Auth\ForgotPasswordController@Forgotpassword');
Route::post('reset-password', 'API\Auth\ResetPasswordController@Resetpassword');


Route::group(['middleware' => 'auth:api'], function(){
Route::post('details', 'API\Auth\UserController@Userdetails');
});
