<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

class UserController extends Controller
{
	public function ajax_getByEmail(Request $request)
	{
		$term = $request->get('term');

		$user = User::where('email', 'like', $term . '%')->get();
		return $user;
	}
}
