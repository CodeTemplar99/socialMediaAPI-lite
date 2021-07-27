<?php

namespace App\Http\Controllers\API\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Like;
use App\Models\User;
use SoftDeletes; 
use Illuminate\Support\Facades\Auth;
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
    $question->title=$request['title'];
    $question->tag=$request['tag'];
    $question->body=$request['body'];
    
    $question->save();

    return response()->json(['Question'=> $question, 'status'=>$this->successStatus]);

  }

  public function like(Request $question){
    $data = new Like;
    $data->question_id=$question->Question;
    if($question->type=='like'){
      $data->upvotes= 1;
    }else{
      $data->downvotes=1;
    }
    $data->save();
    return response()->json([
      'bool'=>true
    ]);
  }
}