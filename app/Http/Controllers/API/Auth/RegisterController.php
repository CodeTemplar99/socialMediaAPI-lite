<?php

namespace App\Http\Controllers\API\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SignupActivate;
use Symfony\Component\Console\Input\Input;
use Validator;


class RegisterController extends Controller{
  public $successStatus = 200;

  /**
  * register API
  */

  public function RegisterUser(Request $request){
     
    $validator = Validator::make($request->all(),[
      'name' => 'required|string|min:5',
      'email'=> 'required|email|unique:users',
      'password'=>'required|min:6|max:100',
      'c_password'=>'required|same:password',
      'username' => 'required|string|min:4|max:20|unique:users',
      'phone'=>'required|string|unique:users|starts_with:+234,+',
      'DOB'=>'required|date|before:12 years ago',
      'institution'=>'required|string|min:3|max:100',
    ]);
    if($validator->fails()){
      return response()->json(['error'=>$validator->errors()], 401);
    }
      
    $input = $request->all();
    $input['password'] = bcrypt($input['password']);
    $input['activation_token'] = str_random(60);
    $user = User::create($input);
    $success['token'] = $user->createToken('eurekaAPI')->accessToken;
    $success['name'] = $user->name;
    
    $user->notify(new SignupActivate($user));


    return response()->json(['success'=>$success],$this->successStatus);
    

  }
}

