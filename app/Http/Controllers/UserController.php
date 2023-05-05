<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class UserController extends BaseController
{
    public function profile()
    {
        $user = Auth::user();
        return view('cabinet.profile', compact('user'));
    }
}
