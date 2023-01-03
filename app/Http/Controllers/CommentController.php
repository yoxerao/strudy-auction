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
    $user = User::find($id);
    if (is_null($user))
      return abort(404, 'User not found, id: ' . $id);

    $this->authorize('delete', $user);

    $comment =  Comment::find($id);
    $comment->delete();

    return redirect("/auction/{$id}");
  }

}
