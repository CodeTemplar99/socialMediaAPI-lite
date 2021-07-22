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

/**
 * User auth routes
*/
Route::group(['middleware' => 'auth:user'], function(){
  Route::post('login/user', 'API\Auth\LoginController@UserLogin');
  Route::post('register/user', 'API\Auth\RegisterController@RegisterUser');
  Route::get('activation/user/{token}', 'API\Auth\ActivationController@ActivateUser');
  Route::post('forgot-password/user', 'API\Auth\ForgotPasswordController@ForgotUserPassword');
  Route::post('reset-password/user/{token}','API\Auth\ResetPasswordController@ResetUserPassword');
  Route::post('createquestion','API\Question\QuestionController@CreateQuestion');
});

/**
 * Admin auth routes
 */
Route::group(['middleware' => 'auth:admin'], function(){
  Route::post('login/admin', 'API\Auth\LoginController@AdminLogin');
  Route::post('register/admin', 'API\Auth\RegisterController@RegisterAdmin');
  Route::get('activation/admin/{token}', 'API\Auth\ActivationController@ActivateAdmin');
  Route::post('forgot-password/admin', 'API\Auth\ForgotPasswordController@ForgotAdminPassword');
  Route::post('reset-password/admin/{token}', 'API\Auth\ResetPasswordController@ResetAdminPassword');
});


Route::group(['middleware' => 'auth:api'], function(){
  Route::post('details', 'API\Auth\DetailsController@Userdetails');
});

