<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic stats
        $totalCustomers = User::where('role', 'customer')->count();
        $totalProducts = Product::count();
        $totalRevenue = 0;
        $totalOrders = 0;
        

        // ✅ Fix করা হয়েছে
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'delivered')
                             ->sum('total_amount');

        // Get all categories for the product form
        $categories = Category::all();
        
        // ✅ Recent orders with user and items count
        $recentOrders = Order::with('user')
            ->withCount('items')
            ->latest()
            ->take(10)
            ->get();

        $pendingOrdersCount = Order::where('status', 'pending')->count();
        // Get recent customers
        $recentCustomers = User::where('role', 'customer')
            ->latest()
            ->take(5)
            ->get()
            ->map(function($customer) {
                $customer->orders_count = 0;
                return $customer;
            });
        
        // Get recent products instead of top selling (since sales_count doesn't exist)
        $topProducts = Product::with('category')
            ->latest()
            ->take(5)
            ->get();
        
        // Low stock products
        $lowStockProducts = Product::where('stock_quantity', '>', 0)
            ->where('stock_quantity', '<=', 10)
            ->get();
        
        // Empty collections for order data
        // $recentOrders = collect([]);
        // $pendingOrdersCount = 0;
        
        return view('admin.dashboard', compact(
            'totalCustomers',
            'totalProducts',
            'totalRevenue',
            'totalOrders',
            'categories',
            'recentOrders',
            'recentCustomers',
            'topProducts',
            'pendingOrdersCount',
            'lowStockProducts'
        ));
    }
}