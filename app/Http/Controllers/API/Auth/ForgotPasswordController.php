<?php 
  
namespace App\Http\Controllers\API\auth; 
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use DB; 
use Carbon\Carbon; 
use Mail;

/**
 * forgot password link
 */
class ForgotPasswordController extends Controller{

  public function ForgotPassword(Request $request){
    $request->validate(['email'=>'required|email|exists:Users',]);

    $token = str_random(60);

    DB::table('password_resets')->insert([
      'email'=>$request->email,
      'token' => $token, 
      'created_at' => Carbon::now(),
    ]);

    $url = url('passreset/now/'.$token);
    
    /**
     * reset link mail styling
     */
    $html = '
    <style>
      body{
        font-family:sans-serif;
        // font-weight:normal !important;
      }
      a button{
        background-color:royalblue;
        color:white;
        padding:10px;
        border:none;
        border-radius:5px;
        cursor:pointer;
      }
    </style>
    <h1>Reset Password</h1>
    <p>Hello, you have requested for a password reset.<br>
    Click the reset button to continue.
    </p>
    <a href="'.$url.'"><button>Reset Password</button></a>
    <p>Ignore this message if you did not initate this action.</p>';


    Mail::send([], ['token' => $token], function($message) use($request, $html){
      $message->to($request->email);
      $message->subject('Reset Password');
      $message->setBody($html, 'text/html');
    });


    return response()->json([
      'message'=>'We have sent your password rest link, please check your mail.'
    ], 200);
  }
}