<?php

namespace App\Http\Controllers\API\Question;

use App\Http\Controllers\Controller;
use App\Models\Questions;
use Illuminate\Http\Request;

class QuestionController extends Controller{
  public function CreateQuestions(Request $request){
    $question = new Questions();
    $question->$request['title']; 
    $question->$request['tag']; 
    $question->$request['body']; 
    $request->user()->Questions()->save($question);

    return response()->json(['Question'=>'$question']);
  }
}