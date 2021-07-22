<?php 
  
namespace App\Http\Controllers\API\Auth; 
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use DB; 
use Carbon\Carbon; 
use App\Models\User;
use App\Models\Admin;
use Mail;
use Hash;

/**
 * forgot password link
 */
class ResetPasswordController extends Controller{

  public function ResetUserPassword(Request $request){
    $request->validate([
        'email'=> 'required|email',
        'password'=>'required|min:6|max:100',
        'c_password' => 'required|string|min:6|same:password'
    ]);
  
    $updatePassword = DB::table('password_resets')->where([
      'email' => $request->email, 
      'token' => $request->token
    ])->first();
    $user = User::where('email', $request->email)->update([
      'password' => Hash::make($request->password)]
    );

    DB::table('password_resets')->where(['email'=> $request->email])->delete();
    return response()->json([
      'message'=>'Your password has been changed!'
    ],200);


    if(!$updatePassword){
      return back()->withInput()->with('error', 'Invalid token!');
    }
  
  }

  public function ResetAdminPassword(Request $request){
    $request->validate([
        'email'=> 'required|email',
        'password'=>'required|min:6|max:100',
        'c_password' => 'required|string|min:6|same:password'
    ]);
  
    $updatePassword = DB::table('password_resets')->where([
      'email' => $request->email, 
      'token' => $request->token
    ])->first();
    $admin = Admin::where('email', $request->email)->update([
      'password' => Hash::make($request->password)]
    );

    DB::table('password_resets')->where(['email'=> $request->email])->delete();
    return response()->json([
      'message'=>'Your password has been changed!'
    ],200);


    if(!$updatePassword){
      return back()->withInput()->with('error', 'Invalid token!');
    }
  
  }

}
