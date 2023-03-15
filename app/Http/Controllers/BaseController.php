<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use View;

class BaseController extends Controller
{
    public function __construct()
    {
        $categories = Category::where('level', 1)->get();
        View::share('categories', $categories);
    }
}
