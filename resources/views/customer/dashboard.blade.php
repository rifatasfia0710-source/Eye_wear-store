@extends('layouts.customer')

@section('title', 'Customer Dashboard')

@section('content')


    <!-- Main Content Area -->
    <main class="dashboard-content">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <h1>Welcome back, {{ Auth::user()->name }}!</h1>
            <p>Manage your orders, prescriptions, and preferences all in one place.</p>
        </div>

        <!-- Quick Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalOrders ?? 0 }}</h3>
                    <p>Total Orders</p>
                </div>
            </div>
            
            <!-- <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $wishlistCount ?? 0 }}</h3>
                    <p>Wishlist Items</p>
                </div>
            </div> -->
            
            <!-- <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-gift"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $rewardPoints ?? 0 }}</h3>
                    <p>Reward Points</p>
                </div>
            </div> -->
            
            <!-- <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-file-prescription"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $prescriptionsCount ?? 0 }}</h3>
                    <p>Prescriptions</p>
                </div>
            </div> -->
        </div>

        <!-- Recent Orders Section -->
        <section class="dashboard-section">
            <div class="section-header">
                <h2>Recent Orders</h2>
                <a href="#orders" class="view-all-link">View All</a>
            </div>
            
            <div class="orders-table">
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders ?? [] as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>{{ $order->items_count }} item(s)</td>
                            <td>৳{{ number_format($order->total_amount, 2) }}</td>
                            <td><span class="status-badge status-{{ strtolower($order->status) }}">{{ $order->status }}</span></td>
                            <!-- <td><a href="#" class="btn-view">View</a></td> -->
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="no-data">No orders found. Start shopping now!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Prescription Alert -->
        <!-- @if(isset($prescriptionExpiring) && $prescriptionExpiring)
        <div class="alert-box alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>Prescription Expiring Soon!</strong>
                <p>Your prescription will expire on {{ $prescriptionExpiryDate }}. Please update it to continue ordering.</p>
            </div>
            <a href="#prescription" class="btn-update">Update Now</a>
        </div>
        @endif -->

        <!-- Wishlist Preview -->
        <!-- <section class="dashboard-section">
            <div class="section-header">
                <h2>Your Wishlist</h2>
                <a href="#wishlist" class="view-all-link">View All</a>
            </div>
            
            <div class="product-grid">
                @forelse($wishlistItems ?? [] as $item)
                <div class="product-card">
                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}">
                    <h4>{{ $item->product->name }}</h4>
                    <p class="price">${{ number_format($item->product->price, 2) }}</p>
                    <button class="btn-primary">Add to Cart</button>
                </div>
                @empty
                <p class="no-data">Your wishlist is empty. Browse our collection to add items!</p>
                @endforelse
            </div>
        </section> -->

        <!-- Quick Actions -->
        
    </main>
</div>



<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection