<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function show(int $id)
    {
        $admin = Admin::find($id);
        if (is_null($admin))
            return abort(404, 'Admin not found');
        
        $adminInfo =[
            'id'=> $id,
            'name'=> $admin->name,
            'email' => $admin->email,
            'username'=> $admin->username
        ];
    
    return view('pages.adminProfile',['admin' => $adminInfo]);
    }
    
}