<?php

namespace App\Http\Controllers;
use Illuminate\View\View;


use Illuminate\Http\Request;

class FrontendController extends Controller
{
     function index(): View
    {
        return view('frontend.home.index');
    }
}
