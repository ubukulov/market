<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Jackiedo\Cart\Facades\Cart;

class CartController extends BaseController
{
    public function index()
    {
        $items = Cart::name('cart')->getItems();
        $cart_items = [];
        foreach ($items as $hash => $item) {
            $item_details = $item->getDetails();
            $product = Product::findOrFail($item_details['id']);
            $cart_items[] = [
                'cart' => $item_details,
                'product' => $product
            ];
        }
//        dd($cart_items);
        //dd(Cart::name('cart')->isEmpty());
        //dd(Cart::name('cart')->countItems()); количество элементов
        //dd(Cart::name('cart')->sumItemsQuantity()); // количество товаров
        if(empty($cart_items)) {
            return view('cart.empty');
        }
        return view('cart.index', compact('cart_items'));
    }

    public function add(Request $request)
    {
        $data = $request->all();
        $product = Product::findOrFail($data['product_id']);
        $shoppingCart   = Cart::name('cart');
        $shoppingCart->addItem([
            'id'       => $product->id,
            'title'    => $product->name,
            'quantity' => $data['product_count'],
            'price'    => $product->price2,
        ]);
    }

    public function delete($cart_product_hash)
    {
        Cart::name('cart')->removeItem($cart_product_hash);
        return redirect()->route('cart.index');
    }

    public function cartEmpty()
    {
        Cart::name('cart')->clearItems();
        return redirect()->route('cart.index');
    }
}
