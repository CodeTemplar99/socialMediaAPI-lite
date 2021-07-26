<?php

namespace App\Http\Controllers\API\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class QuestionController extends Controller{

  public $successStatus = 200;


  public function CreateQuestion(Request $request){  
    $this->validate($request, array(
      'title'=>'required|max:255',
      'tag'=>'required|min:3|max:255', 
      'body'=>'required',
    ));
    $question=new Question();
    $question->user_id = auth()->id();
    $question->title=$request['title'];
    $question->tag=$request['tag'];
    $question->body=$request['body'];
    
    $question->save();

    return response()->json(['Question'=> $question, 'status'=>$this->successStatus]);

  }
}