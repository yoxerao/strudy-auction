<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\User;
use App\Models\Report;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
            'password'=> $user->password,
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

    public function info_edit(int $id)
    {
        $user = User::find($id);
        if (is_null($user))
            return abort(404, 'User not found, id: ' . $id);

        $this->authorize('update', $user);

        $userInfo = [
            'id'=> $id,
            'name'=> $user->name,
            'password'=> $user->password,
            'email' => $user->email,
            'username'=> $user->username,
            'banned'=> $user->banned, 
            'blocked'=> $user->blocked, 
            'terminated'=> $user->terminated,
            'rating' => $user->rating,
            'balance' => $user->balance,
        ];

        return view('pages.editProfile', ['user' => $userInfo]);
    }

    public function edit(Request $request, int $id)
    {
        
        $user = User::find($id);
        if (is_null($user)){
            return redirect()->back()->withErrors(['user' => 'User not found, id: ' . $id]);
        }
        
        if($request->user()->can('update', $user)){
            $this->authorize('update', $user);

            Validator::make($request->all(), [
                'name'=> 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users',
            ]);

            if (isset($request->name)) $user->name = $request->name;
            if (isset($request->username)) $user->username = $request->username;

            $user->save();

            return redirect("/user/{$id}");
        }
        else{
            return redirect()->back()->withErrors(['user' => 'You are not authorized to edit this user']);
        }
    }

    public function info_edit_pass(int $id)
    {
        $user = User::find($id);
        if (is_null($user))
            return abort(404, 'User not found, id: ' . $id);

        $this->authorize('update', $user);

        $userInfo = [
            'id'=> $id,
            'password'=> $user->password,
        ];

        return view('pages.editPass', ['user' => $userInfo]);
    }
    public function edit_pass(Request $request, int $id)
    {
        $user = User::find($id);
        if (is_null($user)){
            return redirect()->back()->withErrors(['user' => 'User not found, id: ' . $id]);
        }

        $this->authorize('update', $user);

        Validator::make($request->all(), [
            'New Password'=>'required|string|max:255',
        ]);

        if (isset($request->password)) $user-> password = bcrypt($request->password);

        $user->save();

        return redirect("/user/{$id}");
    }

    public function biddingHistory(int $id)
    {
        $user = User::find($id);
        if (is_null($user)){
            return abort(404, 'User not found id:'. $id);
        }

        $bids = $user->bids;

        return view('pages.biddingHistory', compact('bids'));
    }

    public function ownedAuctions(int $id)
    {
        $user = User::find($id);
        if (is_null($user)){
            return abort(404, 'User not found id:'. $id);
        }

        $auctions = $user->auctions;

        return view('pages.ownedAuctions', compact('auctions'));
    }

    public function reportForm(Request $request, $id)
    {
        $user = User::find($id);
        if (is_null($user)){
            return abort(404, 'User not found id:'. $id);
        }

        return view('pages.report', ['user' => $user]);
    }

    public function reportPost(Request $request, $id)
    {
        $validatedData = $request->validate([
            'reason' => 'required|string',
        ]);

        $report = new Report;
        $report->reported = $id;
        $report->reason = $validatedData['reason'];
        $report->author = Auth::id();
        $report->save();

        return redirect('/user/' . $id)->with('success', 'Your report has been submitted.');
    }


}