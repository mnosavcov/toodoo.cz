<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Auth;

class UserController extends Controller
{
	public function ajax_getByEmail(Request $request)
	{
		$term = $request->get('term');

		$user = User::where('email', 'like', $term . '%')->where('id', '<>', Auth::id())->get(['hash', 'email as label', 'email as value']);
		return $user;
	}
}
