<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StoreController extends BaseController
{
    public function index()
    {
        return view('store.index');
    }
}
