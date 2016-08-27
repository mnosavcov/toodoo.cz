<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;

use App\Http\Requests;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function form()
    {
        return view('order.form');
    }

    public function store(StoreOrderRequest $request)
    {
        return $request;
    }

    public function orderList()
    {
        return 'order.list';
    }
}
