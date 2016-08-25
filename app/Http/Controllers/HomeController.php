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

    public function invitation(Request $request, $aff)
    {
        if ($request->user()) return redirect()->route('home.index');

        return redirect('/login')->withCookie('aff', $aff, 259200); // 180 dní
    }
}
