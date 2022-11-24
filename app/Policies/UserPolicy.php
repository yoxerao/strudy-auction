<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $user, User $model){
        if (Auth::guard('admin')->check()) {
            return true;
        }
        elseif($user->id === $model->id)
            return true;
        else
            return view('pages.erroNotAuthorize');
    }

    public function delete(User $user, User $model){
        if($user->id === $model->id)
            return true;
        else
            return view('pages.erroNotAuthorize');
    }

}