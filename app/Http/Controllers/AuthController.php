<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Str;

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
        $data['name'] = $data['full_name'];
        $data['password'] = Str::random(5);
        $user = User::where(['email' => $data['email']])->first();
        if($user) {
            return response('user already registered.', 406);
        } else {
            User::create($data);
            return response('success', 200);
        }
    }
}
