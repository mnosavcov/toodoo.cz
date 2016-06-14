<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()) return view('home.welcome');

        return view('home.dashboard');
    }
}
