<?php

namespace App\Http\Controllers;

use App\Models\Admin;

class AdminController extends Controller
{
    public function show(int $id)
    {
        $admin = Admin::find($id);
        if (is_null($admin))
            return abort(404, 'User not found');
        
        $adminInfo =[
            'id'=> $id,
            'name'=> $admin->name,
            'email' => $admin->email,
            'username'=> $admin->username
        ];
    
    return view('pages.adminProfile',['admin' => $adminInfo]);
    }
    
}