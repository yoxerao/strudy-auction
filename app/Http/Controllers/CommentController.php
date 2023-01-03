<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Comment;
use App\Models\User;

use DateTime;

class CommentController extends Controller
{

  public function create(Request $request) {

    $this->authorize('create', Comment::class);

    $dt = new DateTime();

    $comment = new Comment();
    
    $comment->author = Auth::user()->id;
    $comment->id_auction = $request->id_auction;
    $comment->creation_date = $dt->format('Y-m-d H:i:s');
    $comment->content = $request->content;

    $comment->save();

    return redirect("/auction/{$request->id_auction}");
  }

  public function delete(Request $request, $id)
  {
    $comment =  Comment::find($id);
    
    $this->authorize('delete', $comment);

    $comment->delete();

    return redirect("/auction/{$request->id_auction}");
  }

}
