<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Validation;

class ValidationController extends Controller
{
    public function validateBan(Request $request)
    {
        $validation = new Validation;
        $validation->id_administrator = $request->input('administrator');
        $validation->id_report = $request->input('report');
        $validation->banned = $request->input('banned');
        $validation->save();

        return redirect()->route('adminDashboard');
    }

}
