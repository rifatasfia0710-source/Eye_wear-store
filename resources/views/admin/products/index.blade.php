@extends('layouts.admin')

@section('title', 'Products')

@section('content')

<main class="dashboard-content">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <div>
            <h1>Products</h1>
            <p>Manage your product catalog, inventory, and pricing.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn-primary">
            <i class="fas fa-plus-circle"></i> Add New Product
        </a>
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

    <!-- Quick Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-glasses"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $products->total() }}</h3>
                <p>Total Products</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #d4edda; color: #28a745;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3>{{ \App\Models\Product::where('is_active', true)->count() }}</h3>
                <p>Active Products</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #fff3cd; color: #856404;">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="stat-info">
                <h3>{{ \App\Models\Product::whereColumn('stock_quantity', '<=', 'low_stock_threshold')->count() }}</h3>
                <p>Low Stock</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background: #f8d7da; color: #721c24;">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-info">
                <h3>{{ \App\Models\Product::where('stock_quantity', 0)->count() }}</h3>
                <p>Out of Stock</p>
            </div>
        </div>
    </div>

    <!-- Search & Filter Section -->
    <section class="dashboard-section">
        <div class="section-header">
            <h2>Filter Products</h2>
        </div>
        <form action="{{ route('admin.products.index') }}" method="GET" class="filter-form">
            <div class="filter-row">
                <div class="filter-group">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search by name or SKU..."
                           class="form-control">
                </div>

                <div class="filter-group">
                    <select name="category" class="form-control">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <select name="brand" class="form-control">
                        <option value="">All Brands</option>
                        @foreach($brands ?? [] as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-search"></i> Search
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </div>
        </form>
    </section>

    <!-- Products Table -->
    <section class="dashboard-section">
        <div class="section-header">
            <h2>All Products</h2>
            <span class="view-all-link">{{ $products->total() }} total</span>
        </div>

        <div class="orders-table">
            <table>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <!-- <th>Status</th> -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>
                            <input type="checkbox" class="product-checkbox" value="{{ $product->id }}">
                        </td>
                        <td>
                            <img src="{{ asset('storage/'.$product->primary_image) }}"
                                    alt="{{ $product->name }}"
                                    class="product-thumb">
                        </td>
                        <td>
                            <div class="product-name">{{ $product->name }}</div>
                            <div class="product-sku">SKU: {{ $product->sku }}</div>
                            <div class="product-badges">
                                @if($product->is_featured)
                                    <span class="badge badge-blue">Featured</span>
                                @endif
                                @if($product->is_new)
                                    <span class="badge badge-green">New</span>
                                @endif
                                @if($product->is_bestseller)
                                    <span class="badge badge-yellow">Bestseller</span>
                                @endif
                            </div>
                        </td>
                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                        <td>{{ $product->brand->name ?? 'N/A' }}</td>
                        <td>
                            @if($product->sale_price)
                                <div class="price-sale">৳{{ number_format($product->sale_price, 2) }}</div>
                                <div class="price-original">৳{{ number_format($product->price, 2) }}</div>
                            @else
                                <div class="price-regular">৳{{ number_format($product->price, 2) }}</div>
                            @endif
                        </td>
                        <td>
                            @if($product->stock_quantity == 0)
                                <span class="status-badge status-cancelled">Out of Stock</span>
                            @elseif($product->is_low_stock)
                                <span class="status-badge status-pending">Low ({{ $product->stock_quantity }})</span>
                            @else
                                <span class="status-badge status-delivered">{{ $product->stock_quantity }}</span>
                            @endif
                        </td>
                        <!-- <td>
                            <button onclick="toggleStatus({{ $product->id }})"
                                    class="toggle-btn {{ $product->is_active ? 'toggle-active' : 'toggle-inactive' }}"
                                    title="{{ $product->is_active ? 'Active - click to deactivate' : 'Inactive - click to activate' }}">
                                <span class="toggle-knob"></span>
                            </button>
                        </td> -->
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.products.show', $product) }}" class="btn-view">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn-edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button onclick="deleteProduct({{ $product->id }})" class="btn-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="no-data">
                            <i class="fas fa-inbox"></i>
                            <p>No products found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-wrapper">
            {{ $products->appends(request()->query())->links() }}
        </div>
    </section>
</main>

<!-- Bulk Actions Bar -->
<div id="bulkActions" class="bulk-actions-bar hidden">
    <div class="bulk-actions-inner">
        <div class="bulk-info">
            <i class="fas fa-check-circle"></i>
            <span id="selectedCount">0</span> item(s) selected
        </div>
        <div class="bulk-buttons">
            <button onclick="bulkDelete()" class="btn-danger">
                <i class="fas fa-trash"></i> Delete Selected
            </button>
            <button onclick="clearSelection()" class="btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </button>
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
/* ── Reuse Code 1 base styles ─────────────────────────────────────── */
.welcome-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.welcome-section h1 {
    font-size: 1.8rem;
    color: #333;
    margin-bottom: 0.3rem;
}

.welcome-section p {
    color: #6c757d;
    margin: 0;
}

/* Alert Styles */
.alert-box {
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    border-radius: 6px;
    display: flex;
    align-items: center;
    gap: 1rem;
    border-left: 4px solid;
}
.alert-success  { background: #d4edda; border-color: #28a745; color: #155724; }
.alert-danger   { background: #f8d7da; border-color: #dc3545; color: #721c24; }
.alert-warning  { background: #fff3cd; border-color: #ffc107; color: #856404; }
.alert-box i    { font-size: 1.5rem; }

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: #fff;
    border-radius: 8px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
    border: 1px solid #f0f0f0;
}

.stat-icon {
    background: #e8f0fe;
    color: #007bff;
    width: 52px;
    height: 52px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}

.stat-info h3 {
    font-size: 1.6rem;
    font-weight: 700;
    color: #333;
    margin: 0;
}

.stat-info p {
    color: #6c757d;
    margin: 0;
    font-size: 0.9rem;
}

/* Dashboard Section */
.dashboard-section {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,.06);
    border: 1px solid #f0f0f0;
    margin-bottom: 2rem;
    overflow: hidden;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #f0f0f0;
}

.section-header h2 {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    margin: 0;
}

.view-all-link {
    font-size: 0.9rem;
    color: #007bff;
    text-decoration: none;
}

/* Filter Form */
.filter-form {
    padding: 1.5rem;
}

.filter-row {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    align-items: flex-end;
}

.filter-group {
    flex: 1;
    min-width: 160px;
}

.filter-actions {
    display: flex;
    gap: 0.5rem;
    flex-shrink: 0;
}

/* Form Controls */
.form-control {
    width: 100%;
    padding: 0.65rem 0.9rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 0.95rem;
    transition: border-color 0.2s;
    background: #fff;
}

.form-control:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 3px rgba(0,123,255,.1);
}

/* Buttons */
.btn-primary, .btn-secondary, .btn-danger {
    padding: 0.65rem 1.25rem;
    border: none;
    border-radius: 4px;
    font-size: 0.95rem;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    text-decoration: none;
    transition: all 0.2s;
    white-space: nowrap;
}

.btn-primary  { background: #007bff; color: #fff; }
.btn-primary:hover  { background: #0056b3; }
.btn-secondary { background: #6c757d; color: #fff; }
.btn-secondary:hover { background: #5a6268; }
.btn-danger   { background: #dc3545; color: #fff; }
.btn-danger:hover   { background: #c82333; }

/* Table */
.orders-table {
    overflow-x: auto;
}

.orders-table table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.95rem;
}

.orders-table thead th {
    background: #f8f9fa;
    padding: 0.9rem 1rem;
    text-align: left;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #6c757d;
    border-bottom: 2px solid #e9ecef;
}

.orders-table tbody td {
    padding: 0.9rem 1rem;
    border-bottom: 1px solid #f0f0f0;
    vertical-align: middle;
    color: #444;
}

.orders-table tbody tr:last-child td {
    border-bottom: none;
}

.orders-table tbody tr:hover {
    background: #fafbfc;
}

/* Product Info */
.product-thumb {
    width: 56px;
    height: 56px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid #e9ecef;
}

.product-name {
    font-weight: 600;
    color: #333;
    margin-bottom: 2px;
}

.product-sku {
    font-size: 0.8rem;
    color: #6c757d;
}

.product-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
    margin-top: 4px;
}

/* Badges */
.badge {
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}
.badge-blue   { background: #cce5ff; color: #004085; }
.badge-green  { background: #d4edda; color: #155724; }
.badge-yellow { background: #fff3cd; color: #856404; }

/* Status Badges */
.status-badge {
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 500;
    white-space: nowrap;
}
.status-delivered  { background: #d4edda; color: #155724; }
.status-pending    { background: #fff3cd; color: #856404; }
.status-cancelled  { background: #f8d7da; color: #721c24; }
.status-processing { background: #cce5ff; color: #004085; }

/* Price */
.price-sale     { font-weight: 600; color: #dc3545; }
.price-original { font-size: 0.82rem; color: #999; text-decoration: line-through; }
.price-regular  { font-weight: 600; color: #333; }

/* Toggle Switch */
.toggle-btn {
    position: relative;
    width: 44px;
    height: 24px;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    transition: background 0.3s;
    flex-shrink: 0;
}

.toggle-active   { background: #28a745; }
.toggle-inactive { background: #ccc; }

.toggle-knob {
    position: absolute;
    top: 3px;
    width: 18px;
    height: 18px;
    background: #fff;
    border-radius: 50%;
    transition: left 0.3s;
    box-shadow: 0 1px 3px rgba(0,0,0,.2);
}

.toggle-active   .toggle-knob { left: 23px; }
.toggle-inactive .toggle-knob { left: 3px;  }

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.4rem;
    align-items: center;
}

.btn-view, .btn-edit, .btn-delete {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-view   { background: #e8f4fd; color: #007bff; }
.btn-view:hover   { background: #007bff; color: #fff; }
.btn-edit   { background: #e8edff; color: #4263eb; }
.btn-edit:hover   { background: #4263eb; color: #fff; }
.btn-delete { background: #fde8e8; color: #dc3545; }
.btn-delete:hover { background: #dc3545; color: #fff; }

/* No Data */
.no-data {
    text-align: center;
    padding: 3rem 1rem !important;
    color: #aaa;
}
.no-data i {
    font-size: 2.5rem;
    display: block;
    margin-bottom: 0.5rem;
}

/* Pagination */
.pagination-wrapper {
    padding: 1rem 1.5rem;
    border-top: 1px solid #f0f0f0;
    background: #fafbfc;
}

/* Bulk Actions Bar */
.bulk-actions-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #fff;
    border-top: 2px solid #007bff;
    box-shadow: 0 -4px 16px rgba(0,0,0,.1);
    z-index: 999;
    padding: 1rem 2rem;
}

.bulk-actions-bar.hidden {
    display: none;
}

.bulk-actions-inner {
    display: flex;
    align-items: center;
    justify-content: space-between;
    max-width: 1200px;
    margin: 0 auto;
}

.bulk-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: #007bff;
}

.bulk-buttons {
    display: flex;
    gap: 0.75rem;
}

/* Responsive */
@media (max-width: 768px) {
    .welcome-section {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    .filter-row {
        flex-direction: column;
    }
    .filter-group {
        min-width: 100%;
    }
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<script>
// Select All
document.getElementById('selectAll')?.addEventListener('change', function() {
    document.querySelectorAll('.product-checkbox').forEach(cb => cb.checked = this.checked);
    updateBulkActions();
});

document.querySelectorAll('.product-checkbox').forEach(cb => {
    cb.addEventListener('change', updateBulkActions);
});

function updateBulkActions() {
    const checked = document.querySelectorAll('.product-checkbox:checked');
    const bar = document.getElementById('bulkActions');
    document.getElementById('selectedCount').textContent = checked.length;
    bar.classList.toggle('hidden', checked.length === 0);
}

function clearSelection() {
    document.querySelectorAll('.product-checkbox').forEach(cb => cb.checked = false);
    document.getElementById('selectAll').checked = false;
    updateBulkActions();
}

// Toggle Status
function toggleStatus(productId) {
    fetch(`/admin/products/${productId}/toggle-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(r => r.json())
    .then(data => { if (data.success) location.reload(); })
    .catch(err => console.error(err));
}

// Delete Product
function deleteProduct(productId) {
    if (!confirm('Are you sure you want to delete this product? This action cannot be undone.')) return;
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/admin/products/${productId}`;

    const csrf = document.createElement('input');
    csrf.type = 'hidden'; csrf.name = '_token';
    csrf.value = document.querySelector('meta[name="csrf-token"]').content;

    const method = document.createElement('input');
    method.type = 'hidden'; method.name = '_method'; method.value = 'DELETE';

    form.append(csrf, method);
    document.body.appendChild(form);
    form.submit();
}

// Bulk Delete
function bulkDelete() {
    const ids = Array.from(document.querySelectorAll('.product-checkbox:checked')).map(cb => cb.value);
    if (!confirm(`Delete ${ids.length} product(s)? This cannot be undone.`)) return;

    fetch('/admin/products/bulk-delete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ ids })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) location.reload();
        else alert(data.message);
    })
    .catch(() => alert('An error occurred'));
}
</script>

@endsection