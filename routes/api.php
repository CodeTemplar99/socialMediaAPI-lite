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
Route::get('user/activation/{token}', 'API\Auth\ActivationController@ActivateUser');
Route::post('user/login', 'API\Auth\LoginController@UserLogin');
Route::post('forgot-password', 'API\Auth\ForgotPasswordController@ForgotUserPassword');
Route::post('reset-password/{token}','API\Auth\ResetPasswordController@ResetUserPassword');

Route::group(['middleware' => 'auth:api'], function(){
  Route::post('details', 'API\Auth\DetailsController@Userdetails');
  Route::post('createquestion','API\Question\QuestionController@CreateQuestion');
  Route::get('post/{id}/islikedbyme', 'API\Question\QuestionController@isLikedByMe');
  Route::post('post/like', 'API\Question\QuestionController@like');
});



/**
 * Admin auth routes
*/
Route::post('register/admin', 'API\Auth\RegisterController@RegisterAdmin');
Route::get('activation/admin/{token}', 'API\Auth\ActivationController@ActivateAdmin');
Route::post('login/admin', 'API\Auth\LoginController@AdminLogin');
Route::post('forgot-password/admin', 'API\Auth\ForgotPasswordController@ForgotAdminPassword');
Route::post('reset-password/admin/{token}', 'API\Auth\ResetPasswordController@ResetAdminPassword');

Route::group(['middleware' => 'auth:admin'], function(){
});
