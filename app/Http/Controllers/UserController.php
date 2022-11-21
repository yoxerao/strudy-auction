<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

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

    public function edit(Request $request, int $id)
    {
        $user = User::find($id);
        if (is_null($user)){
            return redirect()->back()->withErrors(['user' => 'User not found, id: ' . $id]);
        }

        $this->authorize('update', $user);

        $validator = Validator::make($request->all(), [
            'name'=> 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username'=> 'required|string|max:255|unique:users',
            'password' => 'required_with:new_password,email|string|password',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        if (isset($request->name)) $user->name = $request->name;
        if (isset($request->email)) $user->email = $request->email;
        if (isset($request->new_password)) $user->password = bcrypt($request->new_password);

        $user->save();

        return redirect("/user/{id}");
    }

}