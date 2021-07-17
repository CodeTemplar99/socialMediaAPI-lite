<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SignupActivate;
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
           'name' => 'required|string',
           'email'=> 'required|email|unique:users',
           'password'=>'required',
           'c_password'=>'required|same:password',
           'username' => 'required|string|unique:users',
           'phone'=>'required|string|unique',
           'DOB'=>'required|date',
           'institution'=>'required|string',
        ]);
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        // $user['activation_token']->str_random(60);
        $success['token'] = $user->createToken('eurekaAPI')->accessToken;
        $success['name'] = $user->name;
        return response()->json(['success'=>$success],$this->successStatus);

        
        $user->notify(new SignupActivate($user));

    }

    

    /**
     * user details API
     */
    public function details(){
        $user =Auth::user();
        return response()->json(['success'=>$user],$this->successStatus);
    }
}

