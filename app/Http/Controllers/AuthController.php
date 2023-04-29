<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function restorePassword()
    {
        return view('auth.restore_password');
    }

    public function changePassword()
    {
        return view('auth.change_password');
    }

    public function registerForm()
    {
        return view('auth.register');
    }

    public function registration(Request $request)
    {
        $data = $request->all();
        $user = User::where(['email' => $data['email']])->first();
        if($user) {
            return response('user already registered.', 406);
        } else {
            //
        }
    }
}
