<?php

namespace App\Http\Controllers\API\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class LoginController extends Controller{
  
  public $successStatus = 200;

  public function __construct(){
    $this->middleware('guest')->except('logout');
    $this->middleware('guest:admin')->except('logout');
    $this->middleware('guest:user')->except('logout');
  }

  /**
  * login API
  */
  public function AdminLogin(Request $request){
    $this->validate(
      $request, [
        'email'   => 'required|email',
        'password' => 'required|min:6'
      ]
    );
    if(Auth::guard('admin')->attempt(
      [
        'email' => request('email'),
        'password'=>request('password')
      ],$request->get('remember'))){
        $admin =Auth::admin();
        $success['token']= $admin->createToken('eurekaAPI')->accessToken;
        return response()->json(['success' => $success], $this->successStatus);
      }
    else{
      return response()->json(['error'=>'unauthorised'], 401);
    }
  }


  public function UserLogin(Request $request){
    $this->validate(
      $request, [
        'email'   => 'required|email',
        'password' => 'required|min:6'
      ]
    );
    if(Auth::guard('user')->attempt(
      [
        'email' => request('email'),
        'password'=>request('password')
      ],$request->get('remember'))){
        $user =Auth::user();
        $success['token']= $user->createToken('eurekaAPI')->accessToken;
        return response()->json(['success' => $success], $this->successStatus);
      }
    else{
      return response()->json(['error'=>'unauthorised'], 401);
    }
  }
}
