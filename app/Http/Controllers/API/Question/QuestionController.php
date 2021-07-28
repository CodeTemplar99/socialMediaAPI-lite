<?php

namespace App\Http\Controllers\API\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Like;
use Illuminate\Http\Request;
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
    $question->title = $request['title'];
    $question->tag = $request['tag'];
    $question->body = $request['body'];
    
    $question->save();

    return response()->json(['Question'=> $question, 'status'=>$this->successStatus]);

  }

  public function like(Request $request){
    $data = new Like;
    $data->question_id = Question::find($request->question_id);
      $data->upvotes++;
    $data->save();
    return response()->json([
      'liked'=> $data
    ]);
  }
}