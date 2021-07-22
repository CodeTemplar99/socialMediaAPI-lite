<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller{
  
  public $successStatus = 200;
  /**
  * Admin login API
  */
  public function AdminLogin(Request $request){
    $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required|min:6'
      ]
    );

    if (Auth::guard('admin')->attempt($request->only('email','password'))){
      $user = Auth::guard('admin')->user();
      $success['token'] =  $user->createToken('EurekaAPI')->accessToken;
      $success['admin']= $user;
      return response()->json(['user' => $success], 200);
    }
    else{
      return response()->json(['error'=>'unauthorised'], 401);
    }
  }

  /**
   * User Login API
   */

  public function UserLogin(Request $request){
    $this->validate(
      $request, [
        'email'   => 'required|email',
        'password' => 'required|min:6'
      ]
    );
    if (Auth::guard('user')->attempt($request->only('email','password'))){
      $user = Auth::guard('user')->user();
      $success['token'] =  $user->createToken('EurekaAPI')->accessToken;
      $success['user']= $user;
       return response()->json(['user' => $success], 200);
     }
     else{
       return response()->json(['error'=>'unauthorised'], 401);
    }
  }
  
}
