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

Route::post('login', 'API\Auth\LoginController@LoginUser');
Route::post('register', 'API\Auth\RegisterController@RegisterUser');
Route::get('activation/{token}', 'API\Auth\ActivationController@ActivateUser');

Route::post('forgot-password', 'API\Auth\ForgotPasswordController@ForgotPassword');
Route::post('reset-password', 'API\Auth\ResetPasswordController@ResetPassword');

Route::group(['middleware' => 'auth:api'], function(){
  Route::post('details', 'API\Auth\UserController@Userdetails');
});
