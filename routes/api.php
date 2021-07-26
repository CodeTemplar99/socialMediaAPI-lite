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
Route::post('user/register', 'API\Auth\RegisterController@RegisterUser');
Route::post('user/login', 'API\Auth\LoginController@UserLogin');


Route::group(['middleware' => 'auth:api'], function(){
  Route::post('createquestion','API\Question\QuestionController@CreateQuestion');
  Route::get('user/activation/{token}', 'API\Auth\ActivationController@ActivateUser');
  Route::post('forgot-password', 'API\Auth\ForgotPasswordController@ForgotUserPassword');
  Route::post('reset-password/{token}','API\Auth\ResetPasswordController@ResetUserPassword');
});

/**
 * Admin auth routes
*/
Route::post('register/admin', 'API\Auth\RegisterController@RegisterAdmin');
Route::post('login/admin', 'API\Auth\LoginController@AdminLogin');
Route::group(['middleware' => 'auth:admin'], function(){
  Route::get('activation/admin/{token}', 'API\Auth\ActivationController@ActivateAdmin');
  Route::post('forgot-password/admin', 'API\Auth\ForgotPasswordController@ForgotAdminPassword');
  Route::post('reset-password/admin/{token}', 'API\Auth\ResetPasswordController@ResetAdminPassword');
});


Route::group(['middleware' => 'auth:api'], function(){
  Route::post('details', 'API\Auth\DetailsController@Userdetails');
});

