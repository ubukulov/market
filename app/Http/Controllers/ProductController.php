<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Style;

class ProductController extends BaseController
{
    public function show($slug)
    {
        $product = Product::whereSlug($slug)->first();
        $images = $product->images;
        //dd(Style::getProperties($product->article)->elements[0]->properties);
        $properties = Style::getProperties($product->article);
        return view('product.show', compact('product', 'images', 'properties'));
    }
}
