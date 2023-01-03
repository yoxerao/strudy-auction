<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class StaticPagesController extends Controller
{
    /**
     * Displays about us page
     * 
     * @return View
     */
    public function getAboutUs()
    {
        return view('pages.about');
    }

    public function getFaq()
    {
        return view('pages.faq');
    }

}