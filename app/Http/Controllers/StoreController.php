<?php

namespace App\Http\Controllers;

use App\Models\MarketPlace;
use App\Models\UserMarketCategoryMargin;
use Illuminate\Http\Request;
use Auth;

class StoreController extends BaseController
{
    public function index()
    {
        return view('store.index');
    }

    public function getMarketPlaces()
    {
        return response(MarketPlace::all());
    }

    public function saveMarketPlaceCategoryMargins(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $user_market_category_margin = UserMarketCategoryMargin::where([
            'user_id' => $data['user_id'], 'category_id' => $data['category_id'], 'marketplace_id' => $data['marketplace_id']
        ])->first();
        if($user_market_category_margin) {
            $user_market_category_margin->update($data);
        } else {
            UserMarketCategoryMargin::create($data);
        }

        return response('Данные успешно зафиксирован!');
    }
}
