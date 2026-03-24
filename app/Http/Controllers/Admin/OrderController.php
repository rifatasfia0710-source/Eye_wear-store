<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // All orders list
    public function index(Request $request)
    {
        $query = Order::with('user', 'items')
                      ->withCount('items') 
                      ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Search by order id or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%$search%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%$search%")
                                                    ->orWhere('email', 'like', "%$search%"));
            });
        }

        $orders = $query->paginate(15)->withQueryString();

        $stats = [
            'total'      => Order::count(),
            'pending'    => Order::where('status', 'pending')->count(),
            'processing' => Order::whereIn('status', ['confirmed','processing','shipped'])->count(),
            'delivered'  => Order::where('status', 'delivered')->count(),
            'cancelled'  => Order::where('status', 'cancelled')->count(),
            'unpaid'     => Order::where('payment_status', 'unpaid')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    // Single order details
    public function show($id)
    {
        $order = Order::with('user', 'items.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    // Update order status
    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
    ]);

    $order = Order::findOrFail($id);

    // 🚫 Delivered order cannot be cancelled
    if ($order->status === 'delivered' && $request->status === 'cancelled') {
        return back()->with('error', 'Delivered order cannot be cancelled.');
    }

    // If cancelling, require a reason
    if ($request->status === 'cancelled') {
        $request->validate([
            'cancel_reason' => 'required|string|max:255',
        ]);
        $order->cancel_reason = $request->cancel_reason;
    }

    $order->status = $request->status;
    $order->save();

    return back()->with('success', 'Order status updated to ' . ucfirst($request->status) . '.');
}

    // Update payment status
    public function updatePayment(Request $request, $id)
    {
        $request->validate([
            'payment_status' => 'required|in:paid,unpaid',
        ]);

        Order::findOrFail($id)->update([
            'payment_status' => $request->payment_status,
        ]);

        return back()->with('success', 'Payment status updated.');
    }

    // Cancel order with reason
    public function cancel(Request $request, $id)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:255',
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'status'        => 'cancelled',
            'cancel_reason' => $request->cancel_reason,
        ]);

        return back()->with('success', 'Order has been cancelled.');
    }
    // Delete order
public function destroy($id)
{
    $order = Order::findOrFail($id);
    $order->items()->delete(); // আগে items delete
    $order->delete();

    return redirect()->route('admin.orders.index')
                     ->with('success', 'Order #' . $id . ' deleted successfully.');
}
}