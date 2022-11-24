<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    public function username()
    {
        return 'username';
    }

    public function getLogin(){
        return view('auth.loginAdmin');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|max:255',
            'password' => 'required',
        ]);

        if(auth()->guard('admin')->attempt(['username' => $request->input('username'),  'password' => $request->input('password')])){
           // $user = auth()->guard('admin')->user();
            return redirect()->route('adminDashboard')->with('success','You were Logged in sucessfully.');
            
        }else {
            return back()->with('error','Whoops! invalid username and password.');
        }
    }

    public function adminLogout(Request $request)
    {
        auth()->guard('admin')->logout();
        Session::flush();
        Session::put('success', 'You were logged out sucessfully');
        return redirect(route('adminLogin'));
    }
}