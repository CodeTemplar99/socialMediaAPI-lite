<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;
use Validator;

class UserController extends Controller{

  public $successStatus = 200;

  /**
   * login API
   */

   public function login(){
     if(Auth::attempt(['email' => request('email'),'password'=>request('password')])){
       $user =Auth::user();
       $success['token']= $user->createToken('eurekaAPI')->accessToken;
       return response()->json(['success' => $success], $this->successStatus);
     }
     else{
       return response()->json(['error'=>'unauthorised'], 401);
    }
   }

   /**
    * register API
    */

   public function register(Request $request){
       $validator = Validator::make($request->all(),[
           'name' => 'required',
           'email'=> 'required|email',
           'password'=>'required',
           'c_password'=>'required|same:password',
           'username' => 'required',
           'phone'=>'required',
           'institution'=>'required',
        ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('eurekaAPI')->accessToken;
        $success['name'] = $user->name;
        return response()->json(['success'=>$success],$this->successStatus);

    }
}

