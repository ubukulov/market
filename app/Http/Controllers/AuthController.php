<?php

namespace App\Http\Controllers;

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
}
