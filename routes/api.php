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

Route::post('login/user', 'API\Auth\LoginController@UserLogin');
Route::post('login/admin', 'API\Auth\LoginController@AdminLogin');

Route::post('register/user', 'API\Auth\RegisterController@RegisterUser');
Route::post('register/admin', 'API\Auth\RegisterController@RegisterAdmin');

Route::get('activation/{token}', 'API\Auth\ActivationController@ActivateUser');

Route::post('forgot-password', 'API\Auth\ForgotPasswordController@ForgotPassword');
Route::post('reset-password', 'API\Auth\ResetPasswordController@ResetPassword');

Route::group(['middleware' => 'auth:api'], function(){
  Route::post('details', 'API\Auth\DetailsController@Userdetails');
});
