<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class CustomerController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function dashboard()
    {
        $order = Order::where('user_id', auth()->id())->latest()->get();
        return view('customer.dashboard', compact('order'));
    }

    public function order()
    {
        $order = Order::where('user_id', auth()->id())
                       ->with('items.product')
                       ->latest()
                       ->get();
        return view('customer.order', compact('order'));
    }

    public function orderDetails($id)
    {
        $order = Order::where('user_id', auth()->id())
                      ->with('items.product')
                      ->findOrFail($id);
        return view('customer.order-details', compact('order'));
    }

    public function profile()
    {
        return view('customer.profile');
    }
}