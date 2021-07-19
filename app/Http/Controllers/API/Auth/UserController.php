<?php

namespace App\Http\Controllers\API\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SignupActivate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;
use Validator;
use Carbon\Carbon;

class UserController extends Controller{

  public $successStatus = 200;

  /**
   * login API
   */

   public function LoginUser(){
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

    public function RegisterUser(Request $request){
     
      $validator = Validator::make($request->all(),[
        'name' => 'required|string',
        'email'=> 'required|email|unique:users',
        'password'=>'required',
        'c_password'=>'required|same:password',
        'username' => 'required|string|unique:users',
        'phone'=>'required|string|unique:users',
        'DOB'=>'required|date',
        'institution'=>'required|string',
      ]);
      if($validator->fails()){
        return response()->json(['error'=>$validator->errors()], 401);
      }
        
      $input = $request->all();
      $input['password'] = bcrypt($input['password']);
      $input['activation_token'] = str_random(30);
      $user = User::create($input);
      $success['token'] = $user->createToken('eurekaAPI')->accessToken;
      $success['name'] = $user->name;
      
      $user->notify(new SignupActivate($user));


      return response()->json(['success'=>$success],$this->successStatus);
      

    }


    /**
     * Signup activation
     */
    public function ActivateUser($token){

      $user = User::where('activation_token', $token)->first();

      if($user){
        $user->active = true;
        $user->email_verified_at = Carbon::now();
        $user->activation_token = 'used';
        $user->save();

        return [response()->json([
          'message' => 'Account activated'
        ], 200), $user];
      }

      elseif(!$user){
        return response()->json([
          'message' => 'This activation code is invalid.'
        ], 404);
      }

    }

    
    /**
     * user details API
     */
    public function Userdetails(){
      $user =Auth::user();
      return response()->json(['success'=>$user],$this->successStatus);
    }
}

