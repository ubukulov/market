<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Auth;

class UserController extends BaseController
{
    public function profile()
    {
        $user = Auth::user();
        return view('cabinet.profile', compact('user'));
    }

    public function getOrderItems($orderId)
    {
        $order_items = OrderItem::where('order_id', $orderId)
                    ->selectRaw('order_items.*, products.name,product_images.path')
                    ->join('products', 'products.id', 'order_items.product_id')
                    ->join('product_images', 'product_images.product_id', 'products.id')
                    ->where('product_images.thumbs', 1)
                    ->get();

        return response()->json($order_items);
    }
}
