<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return view('category.products', compact('category'));
    }
}
