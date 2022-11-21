<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function show(int $id)
    {
        $user = User::find($id);

        if (is_null($user)){
            return abort(404, 'User not found id:'. $id);
        }
        
        $userInfo =[
            'id'=> $id,
            'name'=> $user->name,
            'email' => $user->email,
            'username'=> $user->username,
            'banned'=> $user->banned, 
            'blocked'=> $user->blocked, 
            'terminated'=> $user->terminated,
            'rating' => $user->rating,
            'balance' => $user->balance,
        ];

        return view('pages.profile', ['user' => $userInfo]);
    }
}