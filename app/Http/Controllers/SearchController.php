<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Searches for users.
     *
     * @param  Request request containing the search query
     * @return Response
     */
    public function search(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('name', 'like', '%' . $query . '%')->get();
        return view('pages.search', compact('users'));
    }
}