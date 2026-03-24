<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();

        $total = $cartItems->sum(fn($item) =>
            $item->quantity * $item->product->price
        );
        $cartItems = Cart::with('product.images')  // ← .images
            ->where('user_id', Auth::id())
            ->get();
        return view('checkout.index', compact('cartItems', 'total'));
    }

    // public function placeOrder(Request $request)
    // {


    // $order = Order::create([
    //     'user_id'        => auth()->id(),
    //     'total_amount'   => $total,
    //     'payment_method' => $request->payment_method,

    //     // ✅ এখানেই add করবে
    //     'payment_status' => $request->payment_method === 'COD' ? 'paid' : 'unpaid',

    //     'status'         => 'pending',
    //     'address'        => $request->address,
    // ]);
    //     $request->validate([
    //         'address' => 'required|string'
    //     ]);

    //     $cartItems = Cart::with('product')
    //         ->where('user_id', Auth::id())
    //         ->get();

    //     if ($cartItems->isEmpty()) {
    //         return redirect()->route('cart.index')->with('error', 'Cart is empty');
    //     }

    //     $total = $cartItems->sum(fn($item) =>
    //         $item->quantity * $item->product->price
    //     );

    //     $order = Order::create([
    //         'user_id' => Auth::id(),
    //         'total_amount' => $total,
    //         'payment_method' => 'COD',
    //         'status' => 'pending',
    //         'address' => $request->address,
    //     ]);

    //     foreach ($cartItems as $item) {
    //         OrderItem::create([
    //             'order_id' => $order->id,
    //             'product_id' => $item->product_id,
    //             'quantity' => $item->quantity,
    //             'price' => $item->product->price,
    //         ]);
    //     }

    //     // cart clear
    //     Cart::where('user_id', Auth::id())->delete();

    //     return redirect()->route('checkout.success')
    //         ->with('success', 'Order placed successfully (Cash on Delivery)');
    // }
    public function placeOrder(Request $request)
{
    // 1️⃣ Validate first
    $request->validate([
        'address' => 'required|string',
        'payment_method' => 'required'
    ]);

     // SSLCommerz হলে সেই controller এ পাঠান
    if ($request->payment_method === 'sslcommerz') {
        return app(\App\Http\Controllers\SslCommerzPaymentController::class)->index($request);
    }
    // 2️⃣ Get cart items
    $cartItems = Cart::with('product')
        ->where('user_id', Auth::id())
        ->get();

    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.index')->with('error', 'Cart is empty');
    }

    // 3️⃣ Calculate total
    $total = $cartItems->sum(function ($item) {
        return $item->quantity * $item->product->price;
    });

    // 4️⃣ Create order (ONLY ONCE)
    $order = Order::create([
        'user_id'        => Auth::id(),
        'total_amount'   => $total,
        'payment_method' => $request->payment_method,
        'payment_status' => $request->payment_method === 'COD' ? 'paid' : 'unpaid',
        'status'         => 'pending',
        'address'        => $request->address,
    ]);

    // 5️⃣ Create order items
    foreach ($cartItems as $item) {
        OrderItem::create([
            'order_id'  => $order->id,
            'product_id'=> $item->product_id,
            'quantity'  => $item->quantity,
            'price'     => $item->product->price,
        ]);
    }

    // 6️⃣ Clear cart
    Cart::where('user_id', Auth::id())->delete();

    return redirect()->route('checkout.success')
        ->with('success', 'Order placed successfully');
}

    public function success()
    {
        return view('checkout.success');
    }
}
