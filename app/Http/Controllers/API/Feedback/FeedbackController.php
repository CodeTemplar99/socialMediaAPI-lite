<?php

namespace App\Http\Controllers\API\Feedback;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;

class FeedbackController extends Controller{

  public function ContactUs(){

    $data = Request::all();

    $rules = array (
      'first_name' => 'required',
      'email' => 'required|email',
      'message' => 'required|string|min:5'
    );

    $validator = Validator::make ($data, $rules);

    if ($validator -> passes()){
      Mail::send([], $data, function($message) use ($data){
        $html = '
         <style>
          body{
            font-family:sans-serif;
            }
          </style>
        <p>'.$data['message'].'</P>
        ';
        $message->from($data['email'] , $data['first_name']);
        $message->setBody($html, 'text/html'); 

        $message->to('feedback@edvolute.com', 'Feeback Team')->cc('feedback@edvolute.com')->subject('feedback form submit');

      });
      return response()->json(['message'=> 'Your message has been sent. Thank You!']);

    }
    else{
       return response()->json(['error' => 'Feedback must contain more than 5 characters. Try Again.']);
    }
  }
}