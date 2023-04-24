<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends BaseController
{
    public function show($slug)
    {
        $product = Product::whereSlug($slug)->first();
        $images = $product->images;
        return view('product.show', compact('product', 'images'));
    }
}
