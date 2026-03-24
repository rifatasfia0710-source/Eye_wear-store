<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{
    $user = Auth::user();

    // Total Orders
    $totalOrders = Order::where('user_id', $user->id)->count();

    // Recent Orders (last 5)
    $recentOrders = Order::withCount('items')
        ->where('user_id', $user->id)
        ->latest()
        ->take(5)
        ->get();

    return view('customer.dashboard', compact(
        'totalOrders',
        'recentOrders'
    ));
}
}