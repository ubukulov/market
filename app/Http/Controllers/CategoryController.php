<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function show($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where(['category_id' => $id])
            ->paginate(12);
        return view('category.products', compact('category', 'products'));
    }
}
