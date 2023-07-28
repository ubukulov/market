<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jackiedo\Cart\Facades\Cart;
use Auth;
use Session;

class CartController extends BaseController
{
    public function index()
    {
        if(Session::has('successCart')) {
            return view('cart.success');
        }

        if(Cart::name('cart')->isEmpty()) {
            return view('cart.empty');
        }

        $items = Cart::name('cart')->getItems();
        $cart_items = [];
        foreach ($items as $hash => $item) {
            $item_details = $item->getDetails();
            $product = Product::findOrFail($item_details['id']);
            $cart_items[] = [
                'cart' => $item_details,
                'product' => $product,
            ];
        }
//        dd($cart_items);
        //dd(Cart::name('cart')->isEmpty());
        //dd(Cart::name('cart')->countItems()); количество элементов
        //dd(Cart::name('cart')->sumItemsQuantity()); // количество товаров

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
            'price'    => $product->price,
        ]);

        return response('Товар успешно добавлен в корзину!', 200);
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

    public function order()
    {
        DB::beginTransaction();

        try {
            $items = Cart::name('cart')->getItems();

            $order = Order::create([
                'user_id' => Auth::user()->id, 'status' => 'new', 'sum' => (int) Cart::name('cart')->getTotal(), 'updated' => Carbon::now()
            ]);

            foreach($items as $item) {
                $item_details = $item->getDetails();
                OrderItem::create([
                    'order_id' => $order->id, 'product_id' => $item_details['id'], 'price' => $item_details['price'], 'quantity' => $item_details['quantity']
                ]);
            }

            DB::commit();

            Cart::name('cart')->clearItems();

            return redirect()->route('cart.index')->with('successCart', 'Successfully ordered.');

        } catch (\Exception $exception) {
            DB::rollBack();
            dd("Error: ". $exception->getMessage());
        }
    }
}
