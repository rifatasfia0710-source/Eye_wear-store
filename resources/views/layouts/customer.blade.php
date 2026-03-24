<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f5f7fa;
    color: #333;
}

.dashboard-container {
    display: flex;
    min-height: 100vh;
}

/* Sidebar Styles */
.dashboard-sidebar {
    width: 280px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px 0;
    position: fixed;
    height: 100vh;
    overflow-y: auto;
}

.user-profile {
    text-align: center;
    padding: 0 20px 30px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.user-avatar i {
    font-size: 80px;
    color: rgba(255, 255, 255, 0.9);
}

.user-profile h3 {
    margin: 15px 0 5px;
    font-size: 20px;
}

.user-profile p {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.8);
}

.sidebar-nav {
    padding: 20px 0;
}

.nav-item {
    display: flex;
    align-items: center;
    padding: 15px 30px;
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    transition: all 0.3s;
}

.nav-item:hover,
.nav-item.active {
    background: rgba(255, 255, 255, 0.1);
    border-left: 4px solid white;
}

.nav-item i {
    margin-right: 12px;
    width: 20px;
}

/* Main Content Styles */
.dashboard-content {
    flex: 1;
    margin-left: 280px;
    padding: 40px;
}

.welcome-section {
    margin-bottom: 30px;
}

.welcome-section h1 {
    font-size: 32px;
    color: #2d3748;
    margin-bottom: 8px;
}

.welcome-section p {
    color: #718096;
    font-size: 16px;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 25px;
    display: flex;
    align-items: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 20px;
    font-size: 28px;
}

.stat-card:nth-child(1) .stat-icon {
    background: #e6f7ff;
    color: #1890ff;
}

.stat-card:nth-child(2) .stat-icon {
    background: #fff0f6;
    color: #eb2f96;
}

.stat-card:nth-child(3) .stat-icon {
    background: #f6ffed;
    color: #52c41a;
}

.stat-card:nth-child(4) .stat-icon {
    background: #fff7e6;
    color: #fa8c16;
}

.stat-info h3 {
    font-size: 28px;
    color: #2d3748;
    margin-bottom: 5px;
}

.stat-info p {
    color: #718096;
    font-size: 14px;
}

/* Dashboard Sections */
.dashboard-section {
    background: white;
    border-radius: 12px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.section-header h2 {
    font-size: 22px;
    color: #2d3748;
}

.view-all-link {
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
}

.view-all-link:hover {
    text-decoration: underline;
}

/* Orders Table */
.orders-table {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

thead {
    background: #f7fafc;
}

th {
    padding: 12px;
    text-align: left;
    font-weight: 600;
    color: #4a5568;
    font-size: 14px;
}

td {
    padding: 15px 12px;
    border-bottom: 1px solid #e2e8f0;
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.status-delivered {
    background: #d4edda;
    color: #155724;
}

.status-processing {
    background: #fff3cd;
    color: #856404;
}

.status-shipped {
    background: #cce5ff;
    color: #004085;
}

.btn-view {
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
}

.btn-view:hover {
    text-decoration: underline;
}

.no-data {
    text-align: center;
    padding: 40px;
    color: #718096;
}

/* Alert Box */
.alert-box {
    display: flex;
    align-items: center;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 30px;
}

.alert-warning {
    background: #fff3cd;
    border-left: 4px solid #ffc107;
}

.alert-box i {
    font-size: 24px;
    margin-right: 15px;
    color: #856404;
}

.alert-box strong {
    display: block;
    margin-bottom: 5px;
    color: #856404;
}

.alert-box p {
    color: #856404;
    margin: 0;
}

.btn-update {
    margin-left: auto;
    padding: 10px 20px;
    background: #ffc107;
    color: #856404;
    text-decoration: none;
    border-radius: 6px;
    font-weight: 600;
    white-space: nowrap;
}

/* Product Grid */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
}

.product-card {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 15px;
    text-align: center;
    transition: transform 0.3s;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.product-card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 6px;
    margin-bottom: 12px;
}

.product-card h4 {
    font-size: 16px;
    margin-bottom: 8px;
    color: #2d3748;
}

.product-card .price {
    color: #667eea;
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 12px;
}

.btn-primary {
    width: 100%;
    padding: 10px;
    background: #667eea;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    transition: background 0.3s;
}

.btn-primary:hover {
    background: #5568d3;
}

/* Quick Actions */
.quick-actions {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 30px 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    text-decoration: none;
    border-radius: 12px;
    transition: transform 0.3s;
}

.action-btn:hover {
    transform: translateY(-5px);
}

.action-btn i {
    font-size: 36px;
    margin-bottom: 12px;
}

.action-btn span {
    font-weight: 600;
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-sidebar {
        width: 100%;
        position: relative;
        height: auto;
    }
    
    .dashboard-content {
        margin-left: 0;
        padding: 20px;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
}
</style>
    
    @stack('styles')
</head>
<body>

<div class="dashboard-container">
    <!-- Sidebar Navigation -->
    <aside class="dashboard-sidebar">
        <div class="user-profile">
            <div class="user-avatar">
    {{-- ✅ profile_image থাকলে দেখাও, না থাকলে icon দেখাও --}}
    @if(Auth::user()->profile_image)
        <img src="{{ asset('uploads/profile/' . Auth::user()->profile_image) }}"
             alt="Profile"
             style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid rgba(255,255,255,0.5);">
    @else
        <i class="fas fa-user-circle"></i>
    @endif
</div>
            <h3>{{ Auth::user()->name }}</h3>
            <p>{{ Auth::user()->email }}</p>
        </div>
        
        <nav class="sidebar-nav">
            <a href="{{ route('customer.dashboard') }}" class="nav-item active">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <a href="{{ route('customer.order') }}" class="nav-item">
                <i class="fas fa-shopping-bag"></i> My Orders
            </a>
             <a href="{{ route('frontend.shop') }}" class="nav-item">
                <i class="fas fa-file-medical"></i> Shop
            </a>
            <a href="{{ route('cart.index') }}" class="nav-item">
                <i class="fas fa-heart"></i> Cart
            </a> 
            <a href="{{ route('profile.edit') }}" class="nav-item">
                <i class="fas fa-user"></i> Profile Settings
            </a>
            <!-- <a href="#addresses" class="nav-item">
                <i class="fas fa-map-marker-alt"></i> Addresses
            </a> -->
            <a href="{{ route('logout') }}" class="nav-item" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>
        
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </aside>

     @yield('content')