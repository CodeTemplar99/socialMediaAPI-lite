<?php

namespace App\Http\Controllers\API\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class LoginController extends Controller{
  public $successStatus = 200;

  /**
  * login API
  */
  public function LoginUser(){
    if(Auth::attempt([
      'email' => request('email'),
      'password'=>request('password')])){
      $user =Auth::user();
      $success['token']= $user->createToken('eurekaAPI')->accessToken;
      return response()->json(['success' => $success], $this->successStatus);
    }
    else{
      return response()->json(['error'=>'unauthorised'], 401);
    }
  }
}
