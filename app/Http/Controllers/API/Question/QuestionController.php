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

  public function Upvote(Question $request, $id){
    $like = Like::where('question_id', $id)->first();
    if($like == null){
      // dd($id);
      $like = new Like();
      $like->question_id = $id;
      $like->upvotes = 1;
      $like->downvotes = 0;
      $like->save();
      return response()->json(['Like'=>$like]);
    }
    else{
      $like->upvotes++;
      $like->save();
      return response()->json(['Like'=>$like]);
    }
  }

  public function Downvote(Question $request, $id){
    $unlike = Like::where('question_id', $id)->first();
    if($unlike == null){
      $unlike = new Like();
      $unlike->question_id = $id;
      $unlike->downvotes = 1;
      $unlike->save();
      return response()->json(['Like'=>$unlike]);
    }
    else{
      $unlike->downvotes++;
      $unlike->save();
      return response()->json(['Like'=>$unlike]);
    }
  }
}