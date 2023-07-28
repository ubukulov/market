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
            ->whereRaw('LENGTH(quantity) > 1')
            ->paginate(12);
        return view('category.products', compact('category', 'products'));
    }

    public function getCategoryList()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function getProductsByFilter(Request $request, $slug)
    {
        $data = $request->all();

        $category = Category::whereSlug($slug)->first();
        if($category) {
            $products = Product::where(['category_id' => $category->id]);

            if(isset($data['isnew'])) {
                $products = $products->where('isnew', 1);
            }

            if(isset($data['ishit'])) {
                $products = $products->where('ishit', 1);
            }

            if(isset($data['ispromo'])) {
                $products = $products->where('ispromo', 1);
            }

            return response()->json($products->with('thumb')->paginate(12));
        }

        return response('not found', 403);
    }
}
