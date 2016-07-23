<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests;
use App\User;

class AccountController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function detail(Request $request)
    {
        $user = $request->user();
        return view('account.detail', ['user'=>$user]);
    }

    public function edit(Request $request)
    {
        $user = $request->user();
        return view('account.edit', ['user'=>$user]);
    }

    public function save(StoreAccountRequest $request)
    {
        $user = $request->user();

        $user->name = $request->name;

        if($request->password) {
            $user->password = bcrypt($request->password);
            $request->session()->flash('success', 'Heslo bylo změněno!');
        }

        $user->save();

        return redirect()->route('account.detail');
    }
}
