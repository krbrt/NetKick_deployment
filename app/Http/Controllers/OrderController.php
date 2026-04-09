<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
public function index()
{
    // Kunin lahat ng orders ng naka-login na user
    $orders = Auth::user()->orders()->latest()->paginate(10);
    return view('orders.index', compact('orders'));
}

public function show($order_number)
{
    $order = Order::where('order_number', $order_number)
                  ->where('user_id', Auth::id())
                  ->with('items')
                  ->firstOrFail();

    return view('orders.show', compact('order'));
}//
}
