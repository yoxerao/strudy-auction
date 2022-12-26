<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use DateTime;

class CommentController extends Controller
{
    public function show($id) {
        return redirect("/auctions/{$id}");
    }
    public function create(Request $request, $id) {

        $dt = new DateTime();

        $comment = new Comment([
            'author' => Auth::id(),
            'id_auction' => $id,
            'creation_date' => $dt->format('Y-m-d H:i:s'),
            'content' => $request->get('comment')
            
        ]);

        $comment->save();

        return redirect("/auctions/{$id}");
    }

    public function delete(Request $request, $id)
    {
        $user = User::find($id);
        if (is_null($user))
            return abort(404, 'User not found, id: ' . $id);

        $this->authorize('delete', $user);

        $comment =  Comment::find($id);
        $comment->delete();
  
        return redirect("/auctions")->with('success', 'Comment is successfully deleted');
    }

}

