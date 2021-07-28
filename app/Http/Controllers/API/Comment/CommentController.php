<?php

namespace App\Http\Controllers\API\Comment;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CommentController extends Controller{

  public $successStatus = 200;


  public function MakeComment(Request $request){

    $comment = new Comment();

    $this->validate($request, array(
      'comment'=>'required|min:3|max:255',
    ));

    // $comment->user_id = auth()->id();
    $comment->comment=$request['comment'];
    $comment->user()->associate($request->user());
    $question = Question::find($request->parent_id);
    $question->comments()->save($comment);
    
    $comment->save();

    return response()->json(['Comment'=> $comment, 'status'=>$this->successStatus]);

  }
}