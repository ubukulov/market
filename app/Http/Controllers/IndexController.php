<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class IndexController extends BaseController
{
    public function welcome()
    {
        //$categories = Category::getTree();
        //dd($categories);
        $categories = Category::where('level', 1)->get();
        //dd($categories[0]->getItems());
        return view('welcome', compact('categories'));
    }
}
