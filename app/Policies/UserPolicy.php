<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $user, User $model){
        if($user->id === $model->id)
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