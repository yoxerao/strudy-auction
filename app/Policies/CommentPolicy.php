<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class CommentPolicy
{
    public function create(User $user)
    {
        return Auth::check();
    }

    public function delete(User $user, Comment $comment)
    {
        if($user->id === $comment->author)
            return true;
        else
            return view('pages.erroNotAuthorize');
    }

}