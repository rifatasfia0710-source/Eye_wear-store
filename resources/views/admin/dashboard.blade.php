@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

    <!-- Main Content Area -->
    <main class="dashboard-content">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <div>
                <h1>Welcome back, {{ Auth::user()->name }}!</h1>
                <p>Monitor your store performance, manage orders, and oversee operations.</p>
            </div>
            <button class="btn-primary" id="openAddProductModal">
                <i class="fas fa-plus-circle"></i> Add Product
            </button>
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
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="stat-info">
                    <h3>${{ number_format($totalRevenue ?? 0, 2) }}</h3>
                    <p>Total Revenue</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalOrders ?? 0 }}</h3>
                    <p>Total Orders</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-glasses"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalProducts ?? 0 }}</h3>
                    <p>Products</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3>{{ $totalCustomers ?? 0 }}</h3>
                    <p>Customers</p>
                </div>
            </div>
        </div>

        <!-- Alert for Pending Orders -->
        @if(isset($pendingOrdersCount) && $pendingOrdersCount > 0)
        <div class="alert-box alert-warning">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <strong>Pending Orders Alert!</strong>
                <p>You have {{ $pendingOrdersCount }} pending order(s) that require your attention.</p>
            </div>
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="btn-update">View Orders</a>
        </div>
        @endif

        <!-- Low Stock Alert -->
        @if(isset($lowStockProducts) && count($lowStockProducts) > 0)
        <div class="alert-box alert-info">
            <i class="fas fa-info-circle"></i>
            <div>
                <strong>Low Stock Warning!</strong>
                <p>{{ count($lowStockProducts) }} product(s) are running low on stock.</p>
            </div>
            <a href="{{ route('admin.products.index', ['filter' => 'low-stock']) }}" class="btn-update">Check Products</a>
        </div>
        @endif

        <!-- Recent Orders Section -->
        <section class="dashboard-section">
            <div class="section-header">
                <h2>Recent Orders</h2>
                <a href="#" class="view-all-link">View All</a>
            </div>
            
            <div class="orders-table">
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders ?? [] as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? 'Guest' }}</td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>{{ $order->items_count }} item(s)</td>
                            <td>${{ number_format($order->total, 2) }}</td>
                            <td><span class="status-badge status-{{ strtolower($order->status) }}">{{ $order->status }}</span></td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-view">View</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="no-data">No recent orders found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Recent Customers Section -->
        <section class="dashboard-section">
            <div class="section-header">
                <h2>New Customers</h2>
                <a href="#" class="view-all-link">View All</a>
            </div>
            
            <div class="orders-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Joined</th>
                            <th>Orders</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentCustomers ?? [] as $customer)
                        <tr>
                            <td>#{{ $customer->id }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->created_at->format('M d, Y') }}</td>
                            <td>{{ $customer->orders_count ?? 0 }}</td>
                            <td>
                                <a href="#" class="btn-view">View</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="no-data">No new customers found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Top Selling Products -->
        <section class="dashboard-section">
            <div class="section-header">
                <h2>Top Selling Products</h2>
                <a href="#" class="view-all-link">View All</a>
            </div>
            
            <div class="orders-table">
                <table>
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Sales</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts ?? [] as $product)
                        <tr>
                            <td>#{{ $product->id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->sales_count ?? 0 }}</td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-edit">Edit</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="no-data">No products found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- Add Product Modal -->
    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2><i class="fas fa-glasses"></i> Add New Product</h2>
                <span class="close-modal">&times;</span>
            </div>
            
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="addProductForm">
                @csrf
                
                <!-- Display Validation Errors -->
                @if ($errors->any())
                    <div class="alert-box alert-danger" style="margin: 1.5rem;">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            <strong>Whoops! Please fix the following errors:</strong>
                            <ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="category_id">Category *</label>
                            <!-- <select id="category_id" name="category_id" class="form-control" required>
                                <option value="">-- Select Category --</option>
                                <option value="1">Eyeglasses</option>
                                <option value="2">Sunglasses</option>
                                <option value="3">Reading Glasses</option>
                                <option value="4">Blue Light Glasses</option>
                                <option value="5">Sports Glasses</option>
                                <option value="6">Kids Glasses</option>
                            </select> -->
                            <select id="category_id" name="category_id" class="form-control" required>
                                <option value="">-- Select Category --</option>
                                @foreach($categories ?? [] as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">Product Name *</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="frame_type">Frame Type *</label>
                            <input type="text" id="frame_type" name="frame_type" class="form-control" value="{{ old('frame_type') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="slug">Slug *</label>
                            <input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug') }}" required>
                            <small class="form-text">Auto-generated from product name</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="short_description">Short Description</label>
                        <textarea id="short_description" name="short_description" class="form-control" rows="2">{{ old('short_description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="images">Product Images (Optional)</label>
                        <input type="file" id="images" name="images[]" class="form-control" multiple accept="image/*">
                        <small class="form-text">You can upload multiple images. Max size: 2MB per image.</small>
                        <div id="imagePreview" class="image-preview-container"></div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="price">Price ($) *</label>
                            <input type="number" id="price" name="price" class="form-control" step="0.01" min="0" value="{{ old('price') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="discount_price">Discount Price ($)</label>
                            <input type="number" id="discount_price" name="discount_price" class="form-control" step="0.01" min="0" value="{{ old('discount_price') }}">
                            <small class="form-text">Must be less than regular price</small>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="sku">SKU *</label>
                            <input type="text" id="sku" name="sku" class="form-control" value="{{ old('sku') }}" required>
                            <small class="form-text">Auto-generated from product name</small>
                        </div>

                        <div class="form-group">
                            <label for="stock_quantity">Stock Quantity *</label>
                            <input type="number" id="stock_quantity" name="stock_quantity" class="form-control" min="0" value="{{ old('stock_quantity', 0) }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="featured">
                            <input type="checkbox" id="featured" name="featured" value="1" {{ old('featured') ? 'checked' : '' }}>
                            Featured Product
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="status">Status *</label>
                        <select id="status" name="status" class="form-control" required>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="out_of_stock" {{ old('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-secondary" id="cancelBtn">Cancel</button>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
/* Welcome Section Styling */
.welcome-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
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

.alert-success {
    background-color: #d4edda;
    border-color: #28a745;
    color: #155724;
}

.alert-danger {
    background-color: #f8d7da;
    border-color: #dc3545;
    color: #721c24;
}

.alert-warning {
    background-color: #fff3cd;
    border-color: #ffc107;
    color: #856404;
}

.alert-info {
    background-color: #d1ecf1;
    border-color: #17a2b8;
    color: #0c5460;
}

.alert-box i {
    font-size: 1.5rem;
}

.alert-box ul {
    margin: 0.5rem 0 0 0;
    padding-left: 1.5rem;
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    animation: fadeIn 0.3s;
}

.modal-content {
    background-color: #fff;
    margin: 2% auto;
    width: 90%;
    max-width: 700px;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    animation: slideDown 0.3s;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid #e0e0e0;
    background-color: #f8f9fa;
}

.modal-header h2 {
    margin: 0;
    font-size: 1.5rem;
    color: #333;
}

.modal-header i {
    margin-right: 0.5rem;
    color: #007bff;
}

.close-modal {
    font-size: 2rem;
    color: #999;
    cursor: pointer;
    transition: color 0.3s;
    line-height: 1;
}

.close-modal:hover {
    color: #333;
}

.modal-body {
    padding: 2rem;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    padding: 1.5rem;
    border-top: 1px solid #e0e0e0;
    background-color: #f8f9fa;
}

/* Form Styles */
.form-group {
    margin-bottom: 1.5rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #333;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
    transition: border-color 0.3s;
}

.form-control:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
}

.form-control.is-invalid {
    border-color: #dc3545;
}

.form-text {
    display: block;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: #6c757d;
}

/* Image Preview */
.image-preview-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 1rem;
    margin-top: 1rem;
}

.preview-image {
    position: relative;
    width: 100%;
    padding-bottom: 100%;
    border: 2px solid #ddd;
    border-radius: 4px;
    overflow: hidden;
}

.preview-image img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.preview-image .remove-image {
    position: absolute;
    top: 5px;
    right: 5px;
    background: red;
    color: white;
    border: none;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
}

/* Button Styles */
.btn-primary, .btn-secondary {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideDown {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

/* Responsive */
@media (max-width: 768px) {
    .welcome-section {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .form-row {
        grid-template-columns: 1fr;
    }

    .modal-content {
        width: 95%;
        margin: 5% auto;
    }
}
</style>

<script>
// Get modal elements
const modal = document.getElementById('addProductModal');
const openBtn = document.getElementById('openAddProductModal');
const closeBtn = document.querySelector('.close-modal');
const cancelBtn = document.getElementById('cancelBtn');
const imageInput = document.getElementById('images');
const imagePreview = document.getElementById('imagePreview');
const addProductForm = document.getElementById('addProductForm');

// Open modal
openBtn.addEventListener('click', () => {
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
});

// Close modal function
function closeModal() {
    modal.style.display = 'none';
    document.body.style.overflow = 'auto';
    // Clear form and preview
    addProductForm.reset();
    imagePreview.innerHTML = '';
    // Remove error styling
    document.querySelectorAll('.form-control').forEach(input => {
        input.classList.remove('is-invalid');
    });
}

// Close modal on X click
closeBtn.addEventListener('click', closeModal);

// Close modal on Cancel click
cancelBtn.addEventListener('click', closeModal);

// Close modal when clicking outside
window.addEventListener('click', (e) => {
    if (e.target === modal) {
        closeModal();
    }
});

// Close modal on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modal.style.display === 'block') {
        closeModal();
    }
});

// Image preview functionality
imageInput.addEventListener('change', function(e) {
    imagePreview.innerHTML = '';
    const files = Array.from(e.target.files);
    
    if (files.length > 5) {
        alert('You can upload maximum 5 images at a time');
        this.value = '';
        return;
    }
    
    files.forEach((file, index) => {
        if (file.type.startsWith('image/')) {
            // Check file size (2MB max)
            if (file.size > 2 * 1024 * 1024) {
                alert(`Image ${file.name} is too large. Max size is 2MB`);
                return;
            }
            
            const reader = new FileReader();
            
            reader.onload = function(event) {
                const previewDiv = document.createElement('div');
                previewDiv.className = 'preview-image';
                previewDiv.innerHTML = `
                    <img src="${event.target.result}" alt="Preview ${index + 1}">
                `;
                imagePreview.appendChild(previewDiv);
            };
            
            reader.readAsDataURL(file);
        }
    });
});

// Auto-generate slug from product name
document.getElementById('name').addEventListener('input', function(e) {
    const slugField = document.getElementById('slug');
    const slug = e.target.value
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
    slugField.value = slug;
});

// Auto-generate SKU from product name
document.getElementById('name').addEventListener('input', function(e) {
    const skuField = document.getElementById('sku');
    if (!skuField.value || skuField.value.startsWith('SKU-')) {
        const sku = 'SKU-' + e.target.value
            .toUpperCase()
            .replace(/[^A-Z0-9]/g, '-')
            .substring(0, 15);
        skuField.value = sku;
    }
});

// Validate discount price
document.getElementById('discount_price').addEventListener('input', function() {
    const price = parseFloat(document.getElementById('price').value) || 0;
    const discountPrice = parseFloat(this.value) || 0;
    
    if (discountPrice > 0 && discountPrice >= price) {
        alert('Discount price must be less than the regular price');
        this.value = '';
        this.classList.add('is-invalid');
    } else {
        this.classList.remove('is-invalid');
    }
});

// Form validation before submit
addProductForm.addEventListener('submit', function(e) {
    let isValid = true;
    
    // Validate required fields
    const requiredFields = this.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            isValid = false;
            field.classList.add('is-invalid');
        } else {
            field.classList.remove('is-invalid');
        }
    });
    
    // Validate price and discount price
    const price = parseFloat(document.getElementById('price').value) || 0;
    const discountPrice = parseFloat(document.getElementById('discount_price').value) || 0;
    
    if (discountPrice > 0 && discountPrice >= price) {
        isValid = false;
        alert('Discount price must be less than the regular price');
        document.getElementById('discount_price').classList.add('is-invalid');
        e.preventDefault();
        return;
    }
    
    if (!isValid) {
        e.preventDefault();
        alert('Please fill in all required fields marked with *');
        return;
    }
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
});

// If there are validation errors, open the modal
@if ($errors->any())
    window.addEventListener('load', () => {
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    });
@endif
</script>

@endsection