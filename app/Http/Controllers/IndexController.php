<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Auth;

class IndexController extends BaseController
{
    public function welcome()
    {
        return view('welcome');
    }
}
