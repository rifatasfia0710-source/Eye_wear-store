@extends('layouts.admin')

@section('title', 'Orders Management')

@section('content')

<!-- Main Content Area -->
<main class="dashboard-content">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1><i class="fas fa-shopping-cart"></i> Orders Management</h1>
            <p>View and manage all customer orders</p>
        </div>
        <!-- <div class="header-actions">
            <button class="btn-export" id="exportBtn">
                <i class="fas fa-download"></i> Export
            </button>
        </div> -->
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert-box alert-success">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Success!</strong>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert-box alert-danger">
            <i class="fas fa-times-circle"></i>
            <div>
                <strong>Error!</strong>
                <p>{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Stats Overview -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['pending'] ?? 0 }}</h3>
                <p>Pending Orders</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-sync"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['processing'] ?? 0 }}</h3>
                <p>Processing</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-truck"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['shippedOrders'] ?? 0 }}</h3>
                
                <p>Shipped</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-check-double"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $stats['delivered'] ?? 0 }}</h3>
                <p>Delivered</p>
            </div>
        </div>
    </div>

    <!-- Filters and Search Section -->
    <div class="dashboard-section">
        <div class="filters-container">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Search by Order ID, Customer Name, or Email...">
            </div>
            
            <div class="filter-group">
                <select id="statusFilter" class="filter-select">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>

                <select id="dateFilter" class="filter-select">
                    <option value="">All Time</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                    <option value="custom">Custom Range</option>
                </select>

                <button class="btn-filter" id="applyFilters">
                    <i class="fas fa-filter"></i> Apply Filters
                </button>

                <button class="btn-reset" id="resetFilters">
                    <i class="fas fa-redo"></i> Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="dashboard-section">
        <div class="section-header">
            <h2>All Orders </h2>
            <div class="table-controls">
                <select id="bulkAction" class="bulk-action-select">
                    <option value="">Bulk Actions</option>
                    <option value="processing">Mark as Processing</option>
                    <option value="shipped">Mark as Shipped</option>
                    <option value="delivered">Mark as Delivered</option>
                    <option value="export">Export Selected</option>
                </select>
                <button class="btn-apply" id="applyBulkAction">Apply</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th width="50">
                            <input type="checkbox" id="selectAll">
                        </th>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date & Time</th>
                        <th>Items</th>
                        <th>Payment Method</th>
                        <th>Total Amount</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders ?? [] as $order)
                    <tr>
                        <td>
                            <input type="checkbox" class="order-checkbox" value="{{ $order->id }}">
                        </td>
                        <td>
                            <strong>#{{ $order->id }}</strong>
                        </td>
                        <td>
                            <div class="customer-info">
                                <div class="customer-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <strong>{{ $order->user->name ?? 'Guest' }}</strong>
                                    <small>{{ $order->user->email ?? $order->email }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>{{ $order->created_at->format('M d, Y') }}</div>
                            <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                        </td>
                        <td>
                            <span class="items-badge">{{ $order->items_count }} item(s)</span>
                        </td>
                        <td>
    @php $method = strtolower($order->payment_method ?? 'cod'); @endphp
    @if($method == 'sslcommerz')
        <span class="method-badge method-ssl">
            <i class="fas fa-credit-card"></i> SSLCommerz
        </span>
    @elseif($method == 'bkash')
        <span class="method-badge method-bkash">
            <i class="fas fa-mobile-alt"></i> bKash
        </span>
    @else
        <span class="method-badge method-cod">
            <i class="fas fa-money-bill"></i> COD
        </span>
    @endif
</td>
                        <td>
                            <strong class="price-text">${{ number_format($order->total_amount, 2) }}</strong>
                        </td>
                        <td>
                            <span class="payment-badge payment-{{ strtolower($order->payment_status ?? 'pending') }}">
                                {{ ucfirst($order->payment_status ?? 'Pending') }}
                            </span>
                        </td>
                        <td>
                            <select class="status-select" data-order-id="{{ $order->id }}">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-action btn-view" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <!-- <button class="btn-action btn-print" onclick="printOrder({{ $order->id }})" title="Print Invoice">
                                    <i class="fas fa-print"></i>
                                </button> -->
                               <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete Order #{{ $order->id }}? This cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Delete Order">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="no-data">
                            <i class="fas fa-inbox"></i>
                            <p>No orders found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($orders) && $orders->hasPages())
        <div class="pagination-container">
            <div class="pagination-info">
                Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} orders
            </div>
            <div class="pagination">
                {{ $orders->links() }}
            </div>
        </div>
        @endif
    </div>
</main>

<!-- Order Detail Modal -->
<div id="orderDetailModal" class="modal">
    <div class="modal-content modal-large">
        <div class="modal-header">
            <h2><i class="fas fa-file-invoice"></i> Order Details</h2>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body" id="orderDetailContent">
            <!-- Order details will be loaded here via AJAX -->
            <div class="loading-spinner">
                <i class="fas fa-spinner fa-spin"></i> Loading...
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
/* Page Header */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 20px;
}

.page-header h1 {
    font-size: 32px;
    color: #2d3748;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.page-header h1 i {
    color: #667eea;
}

.page-header p {
    color: #718096;
    font-size: 16px;
    margin: 0;
}

.header-actions {
    display: flex;
    gap: 12px;
}

.btn-export {
    padding: 12px 24px;
    background: #48bb78;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-export:hover {
    background: #38a169;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(72, 187, 120, 0.4);
}

/* Filters Container */
.filters-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.search-box {
    position: relative;
    flex: 1;
    max-width: 500px;
}

.search-box i {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #718096;
}

.search-box input {
    width: 100%;
    padding: 12px 15px 12px 45px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.3s;
}

.search-box input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.filter-group {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.filter-select {
    padding: 12px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s;
    background: white;
}

.filter-select:focus {
    outline: none;
    border-color: #667eea;
}

.btn-filter, .btn-reset {
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-filter {
    background: #667eea;
    color: white;
}

.btn-filter:hover {
    background: #764ba2;
    transform: translateY(-2px);
}

.btn-reset {
    background: #e2e8f0;
    color: #4a5568;
}

.btn-reset:hover {
    background: #cbd5e0;
}

/* Table Controls */
.table-controls {
    display: flex;
    gap: 12px;
    align-items: center;
}

.bulk-action-select {
    padding: 10px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 6px;
    font-size: 14px;
    cursor: pointer;
}

.btn-apply {
    padding: 10px 20px;
    background: #667eea;
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-apply:hover {
    background: #764ba2;
}

/* Table Styles */
.table-responsive {
    overflow-x: auto;
}

.orders-table {
    width: 100%;
    border-collapse: collapse;
}

.orders-table thead {
    background: #f7fafc;
}

.orders-table th {
    padding: 16px 12px;
    text-align: left;
    font-weight: 600;
    color: #4a5568;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
    border-bottom: 2px solid #e2e8f0;
}

.orders-table td {
    padding: 16px 12px;
    border-bottom: 1px solid #e2e8f0;
    vertical-align: middle;
}

.orders-table tbody tr {
    transition: background 0.3s;
}

.orders-table tbody tr:hover {
    background: #f7fafc;
}

/* Customer Info */
.customer-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.customer-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}

.customer-info strong {
    display: block;
    color: #2d3748;
    font-size: 14px;
}

.customer-info small {
    display: block;
    color: #718096;
    font-size: 12px;
}

/* Badges */
.items-badge {
    display: inline-block;
    padding: 6px 12px;
    background: #edf2f7;
    color: #4a5568;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.payment-badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: capitalize;
}

.payment-paid {
    background: #c6f6d5;
    color: #22543d;
}

.payment-pending {
    background: #feebc8;
    color: #7c2d12;
}

.payment-failed {
    background: #fed7d7;
    color: #742a2a;
}

.price-text {
    color: #2d3748;
    font-size: 15px;
}

/* Status Select */
.status-select {
    padding: 8px 12px;
    border: 2px solid #e2e8f0;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.status-select:focus {
    outline: none;
    border-color: #667eea;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 8px;
}

.btn-action {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}

.btn-action.btn-view {
    background: #e6f7ff;
    color: #1890ff;
}

.btn-action.btn-view:hover {
    background: #1890ff;
    color: white;
}

.btn-action.btn-print {
    background: #f6ffed;
    color: #52c41a;
}

.btn-action.btn-print:hover {
    background: #52c41a;
    color: white;
}

.btn-action.btn-delete {
    background: #fff0f6;
    color: #eb2f96;
}

.btn-action.btn-delete:hover {
    background: #eb2f96;
    color: white;
}

/* Pagination */
.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #e2e8f0;
    flex-wrap: wrap;
    gap: 20px;
}

.pagination-info {
    color: #718096;
    font-size: 14px;
}

/* Alert Boxes */
.alert-success {
    background: #d4edda;
    border-left: 4px solid #28a745;
    color: #155724;
}

.alert-danger {
    background: #f8d7da;
    border-left: 4px solid #dc3545;
    color: #721c24;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 2000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    animation: fadeIn 0.3s;
}

.modal-large {
    max-width: 900px;
}

.loading-spinner {
    text-align: center;
    padding: 60px;
    color: #667eea;
    font-size: 18px;
}

.loading-spinner i {
    font-size: 36px;
    margin-bottom: 15px;
}

/* Responsive */
@media (max-width: 1200px) {
    .filters-container {
        flex-direction: column;
    }
    
    .search-box {
        max-width: 100%;
    }
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .filter-group {
        width: 100%;
    }
    
    .filter-select,
    .btn-filter,
    .btn-reset {
        flex: 1;
    }
    
    .orders-table {
        font-size: 12px;
    }
    
    .orders-table th,
    .orders-table td {
        padding: 10px 6px;
    }
    
    .customer-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
</style>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All Checkbox
    const selectAll = document.getElementById('selectAll');
    const orderCheckboxes = document.querySelectorAll('.order-checkbox');
    
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            orderCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }
    
    // Search Functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                performSearch(this.value);
            }, 500);
        });
    }
    
    // Apply Filters
    const applyFiltersBtn = document.getElementById('applyFilters');
    if (applyFiltersBtn) {
        applyFiltersBtn.addEventListener('click', applyFilters);
    }
    
    // Reset Filters
    const resetFiltersBtn = document.getElementById('resetFilters');
    if (resetFiltersBtn) {
        resetFiltersBtn.addEventListener('click', function() {
            window.location.href = '{{ route("admin.orders.index") }}';
        });
    }
    
    // Status Change
    const statusSelects = document.querySelectorAll('.status-select');
    statusSelects.forEach(select => {
        select.addEventListener('change', function() {
            const orderId = this.dataset.orderId;
            const newStatus = this.value;
            updateOrderStatus(orderId, newStatus);
        });
    });
    
    // Bulk Actions
    const applyBulkActionBtn = document.getElementById('applyBulkAction');
    if (applyBulkActionBtn) {
        applyBulkActionBtn.addEventListener('click', applyBulkAction);
    }
});

// Search Function
function performSearch(query) {
    const url = new URL(window.location.href);
    url.searchParams.set('search', query);
    window.location.href = url.toString();
}

// Apply Filters
function applyFilters() {
    const status = document.getElementById('statusFilter').value;
    const date = document.getElementById('dateFilter').value;
    
    const url = new URL(window.location.href);
    if (status) url.searchParams.set('status', status);
    if (date) url.searchParams.set('date', date);
    
    window.location.href = url.toString();
}

// Update Order Status
function updateOrderStatus(orderId, status) {
    if (!confirm('Are you sure you want to update this order status?')) {
        return;
    }
    
    // Show loading
    const select = document.querySelector(`[data-order-id="${orderId}"]`);
    const originalValue = select.value;
    select.disabled = true;
    
    fetch(`/admin/orders/${orderId}/status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Order status updated successfully!');
            location.reload();
        } else {
            alert('Failed to update order status');
            select.value = originalValue;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
        select.value = originalValue;
    })
    .finally(() => {
        select.disabled = false;
    });
}

// Bulk Actions
function applyBulkAction() {
    const action = document.getElementById('bulkAction').value;
    if (!action) {
        alert('Please select an action');
        return;
    }
    
    const selectedOrders = Array.from(document.querySelectorAll('.order-checkbox:checked'))
        .map(cb => cb.value);
    
    if (selectedOrders.length === 0) {
        alert('Please select at least one order');
        return;
    }
    
    if (!confirm(`Apply action "${action}" to ${selectedOrders.length} order(s)?`)) {
        return;
    }
    
    // Implement bulk action logic here
    console.log('Bulk action:', action, 'Orders:', selectedOrders);
}

// Print Order
function printOrder(orderId) {
    window.open(`/admin/orders/${orderId}/print`, '_blank');
}

// Delete Order
function deleteOrder(orderId) {
    if (!confirm('Are you sure you want to delete this order? This action cannot be undone.')) {
        return;
    }
    
    fetch(`/admin/orders/${orderId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Order deleted successfully!');
            location.reload();
        } else {
            alert('Failed to delete order');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred');
    });
}
</script>

@endsection