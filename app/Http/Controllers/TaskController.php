<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class TaskController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth', ['except' => [
			'index'
		]]);
	}

	public function index(Request $request)
	{
		if (!$request->user()) return view('task.index-guest');

		return view('task.index');
	}
}
