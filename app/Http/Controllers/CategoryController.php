<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function show($slug)
    {
        $category = Category::whereSlug($slug)->first();
        $products = Product::where(['category_id' => $category->id])
            ->paginate(12);
        return view('category.products', compact('category', 'products'));
    }
}
