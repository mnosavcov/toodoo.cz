<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Notifications\ActivationToken;

use App\Http\Requests;

class ActivationController extends Controller
{
    public function activate($email, $token)
    {
        $user_activation = User::where('active', 0)->where('activation_token', $token)->where('email', $email)->update(['active' => 1, 'activation_token' => '']);
        if ($user_activation) {
            session()->flash('success', 'Aktivace účtu byla úspěšná');
            return redirect('login');
        } else {
            session()->flash('danger', 'Aktivace účtu se nepodařila');
            return redirect('login');
            return redirect()->route('home.index');
        }
    }

    public function reactivate()
    {
        if (Auth::user()->activation_token || Auth::user()->active == 0) {
            Auth::user()->update(['activation_token' => md5(uniqid(time(), true)), 'active' => 0]);
            Auth::user()->notify(new ActivationToken(Auth::user()));
            session()->flash('success', 'Aktivační email byl úspěšně odeslaný');
        }
        return redirect()->route('home.index');
    }
}
