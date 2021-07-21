<?php

namespace App\Http\Controllers\API\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admin;
use App\Notifications\SignupActivate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;
use Carbon\Carbon;


class ActivationController extends Controller{
  public $successStatus = 200;

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

  public function ActivateAdmin($token){

    $admin = Admin::where('activation_token', $token)->first();

    if($admin){
      $admin->active = true;
      $admin->email_verified_at = Carbon::now();
      $admin->activation_token = 'used';
      $admin->save();

      return [response()->json([
        'message' => 'Account activated'
      ], 200), $admin];
    }

    elseif(!$admin){
      return response()->json([
        'message' => 'This activation code is invalid.'
      ], 404);
    }

  }
}