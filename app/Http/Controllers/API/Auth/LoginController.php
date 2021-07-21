<?php

namespace App\Http\Controllers\API\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller{
  
  public $successStatus = 200;

  public function __construct(){
    $this->middleware('guest')->except('logout');
    $this->middleware('guest:admin')->except('logout');
    $this->middleware('guest:user')->except('logout');
  }

  /**
  * Admin login API
  */
  public function AdminLogin(Request $request){
    $this->validate($request, [
        'email'   => 'required|email',
        'password' => 'required|min:6'
      ]
    );
    if(Auth::guard('admin')->attempt(['email' => request('email'),'password'=>request('password')])){
       $admin =Auth::admin();
       $success['admin']= $admin;
       return response()->json(['success' => $success], 200);
     }
    else{
      return response()->json(['error'=>'unauthorised'], 401);
    }
  }

  /**
   * User Login API
   */

  public function UserLogin(Request $request, $guard=null){
    $this->validate(
      $request, [
        'email'   => 'required|email',
        'password' => 'required|min:6'
      ]
    );
    if(Auth::guard($guard)->attempt(['email' => request('email'),'password'=>request('password')])){
       $user =Auth::user();
       $success['user']= $user;
       return response()->json(['success' => $success], 200);
     }
     else{
       return response()->json(['error'=>'unauthorised'], 401);
    }
  }
  
}
