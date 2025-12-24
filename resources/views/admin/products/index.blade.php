{{-- resources/views/admin/products/index.blade.php --}}

@extends('layouts.admin')

@section('title', 'Products')

@section('content')
<div class="container-fluid" style="padding: 2rem 2rem 2rem 230px; background: #f5f7fa; min-height: 100vh;">
    <!-- Header Section -->
    <div class="d-flex justify-content-end mb-4">
        <a href="{{ route('admin.products.create') }}" class="btn px-4 py-2" style="background: #6c7ae0; border: none; color: white; border-radius: 8px; font-weight: 500; box-shadow: 0 2px 8px rgba(108, 122, 224, 0.3); transition: all 0.3s ease;">
            <i class="fas fa-plus me-2"></i> Add New Product
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-dismissible fade show mb-3" role="alert" style="background: #4caf50; border: none; border-radius: 8px; color: white; padding: 1rem;">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-dismissible fade show mb-3" role="alert" style="background: #f44336; border: none; border-radius: 8px; color: white; padding: 1rem;">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filters Card -->
    <div class="card mb-3" style="border: none; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); background: white;">
        <div class="card-body p-3">
            <form action="{{ route('admin.products.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label class="form-label fw-medium text-uppercase mb-2" style="font-size: 0.7rem; color: #94a3b8; letter-spacing: 0.5px;">Search</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0" style="border-radius: 8px 0 0 8px; border: 1px solid #e2e8f0;">
                                <i class="fas fa-search" style="color: #94a3b8; font-size: 0.9rem;"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0 ps-0" 
                                   placeholder="Product name or SKU..." 
                                   value="{{ request('search') }}"
                                   style="border-radius: 0 8px 8px 0; border: 1px solid #e2e8f0; padding: 0.6rem 0.75rem;">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-medium text-uppercase mb-2" style="font-size: 0.7rem; color: #94a3b8; letter-spacing: 0.5px;">Status</label>
                        <select name="status" class="form-select" style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.6rem 0.75rem;">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-medium text-uppercase mb-2" style="font-size: 0.7rem; color: #94a3b8; letter-spacing: 0.5px;">Stock</label>
                        <select name="stock_status" class="form-select" style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 0.6rem 0.75rem;">
                            <option value="">All Stock</option>
                            <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>In Stock</option>
                            <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                            <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn w-100" style="background: #6c7ae0; border: none; color: white; border-radius: 8px; padding: 0.6rem; font-weight: 500;">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.products.index') }}" class="btn w-100" style="background: white; border: 1px solid #e2e8f0; color: #64748b; border-radius: 8px; padding: 0.6rem; font-weight: 500;">
                            <i class="fas fa-redo me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Card -->
    <div class="card" style="border: none; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); background: white;">
        <div class="card-body p-0">
            <form id="bulk-delete-form" action="{{ route('admin.products.bulk-delete') }}" method="POST">
                @csrf
                
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                            <tr>
                                <th class="py-3 px-4" style="border: none; font-weight: 600; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px; width: 50px;">
                                    <input type="checkbox" id="select-all" class="form-check-input" style="width: 16px; height: 16px; cursor: pointer;">
                                </th>
                                <th class="py-3 px-4" style="border: none; font-weight: 600; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px; width: 100px;">Image</th>
                                <th class="py-3 px-4" style="border: none; font-weight: 600; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px;">Product</th>
                                <th class="py-3 px-4" style="border: none; font-weight: 600; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px; width: 150px;">Price</th>
                                <th class="py-3 px-4" style="border: none; font-weight: 600; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px; width: 130px;">Stock</th>
                                <th class="py-3 px-4" style="border: none; font-weight: 600; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px; width: 120px;">Status</th>
                                <th class="py-3 px-4" style="border: none; font-weight: 600; color: #64748b; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px; width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr style="border-bottom: 1px solid #f1f5f9;">
                                    <td class="py-3 px-4 align-middle">
                                        <input type="checkbox" name="ids[]" value="{{ $product->id }}" class="product-checkbox form-check-input" style="width: 16px; height: 16px; cursor: pointer;">
                                    </td>
                                    <td class="py-3 px-4 align-middle">
                                        @if($product->productImages && $product->productImages->isNotEmpty())
                                            <img src="{{ asset('storage/' . $product->productImages->first()->image_path) }}" 
                                                 alt="{{ $product->name }}" 
                                                 style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;">
                                        @else
                                            <div class="d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px; background: #6c7ae0; border-radius: 8px;">
                                                <i class="fas fa-image text-white" style="font-size: 1.2rem;"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 align-middle">
                                        <div>
                                            <strong style="color: #1e293b; font-size: 0.95rem; display: block;">{{ $product->name }}</strong>
                                            <small style="color: #94a3b8; font-size: 0.8rem;">SKU: {{ $product->sku }}</small>
                                            @if($product->featured)
                                                <span class="badge mt-1" style="background: linear-gradient(135deg, #ec4899, #f97316); border: none; padding: 0.25rem 0.6rem; font-weight: 600; font-size: 0.7rem; border-radius: 4px;">
                                                    <i class="fas fa-star me-1"></i> Featured
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 align-middle">
                                        @if($product->discount_price)
                                            <div>
                                                <span class="text-decoration-line-through" style="color: #94a3b8; font-size: 0.85rem; display: block;">${{ number_format($product->price, 2) }}</span>
                                                <div class="d-flex align-items-center gap-1 mt-1">
                                                    <strong style="color: #ef4444; font-size: 1rem;">${{ number_format($product->discount_price, 2) }}</strong>
                                                    <span class="badge" style="background: #ef4444; padding: 0.2rem 0.4rem; font-size: 0.65rem; border-radius: 4px;">
                                                        -{{ $product->discount_percentage }}%
                                                    </span>
                                                </div>
                                            </div>
                                        @else
                                            <strong style="color: #1e293b; font-size: 1rem;">${{ number_format($product->price, 2) }}</strong>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 align-middle">
                                        @if($product->stock_quantity == 0)
                                            <span class="badge" style="background: #ef4444; padding: 0.4rem 0.8rem; font-weight: 600; font-size: 0.75rem; border-radius: 6px;">
                                                <i class="fas fa-times-circle me-1"></i> Out of Stock
                                            </span>
                                        @elseif($product->stock_quantity <= 10)
                                            <span class="badge" style="background: #f59e0b; color: white; padding: 0.4rem 0.8rem; font-weight: 600; font-size: 0.75rem; border-radius: 6px;">
                                                <i class="fas fa-exclamation-triangle me-1"></i> Low: {{ $product->stock_quantity }}
                                            </span>
                                        @else
                                            <span class="badge" style="background: #10b981; padding: 0.4rem 0.8rem; font-weight: 600; font-size: 0.75rem; border-radius: 6px;">
                                                <i class="fas fa-check-circle me-1"></i> {{ $product->stock_quantity }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 align-middle">
                                        @if($product->status == 'active')
                                            <span class="badge" style="background: #10b981; padding: 0.4rem 0.8rem; font-weight: 600; font-size: 0.75rem; border-radius: 6px;">
                                                <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> Active
                                            </span>
                                        @elseif($product->status == 'inactive')
                                            <span class="badge" style="background: #6b7280; padding: 0.4rem 0.8rem; font-weight: 600; font-size: 0.75rem; border-radius: 6px;">
                                                <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> Inactive
                                            </span>
                                        @else
                                            <span class="badge" style="background: #ef4444; padding: 0.4rem 0.8rem; font-weight: 600; font-size: 0.75rem; border-radius: 6px;">
                                                <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> Out of Stock
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 align-middle">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.products.edit', $product->id) }}" 
                                               class="btn btn-sm" 
                                               title="Edit"
                                               style="background: #f59e0b; border: none; color: white; padding: 0.4rem 0.7rem; border-radius: 6px 0 0 6px;">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.products.show', $product->id) }}" 
                                               class="btn btn-sm" 
                                               title="View"
                                               style="background: #6c7ae0; border: none; color: white; padding: 0.4rem 0.7rem; margin-left: 1px;">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                                  method="POST" 
                                                  style="display: inline; margin: 0;"
                                                  onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm" 
                                                        title="Delete"
                                                        style="background: #ef4444; border: none; color: white; padding: 0.4rem 0.7rem; border-radius: 0 6px 6px 0; margin-left: 1px;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 250px;">
                                            <div class="mb-3" style="width: 80px; height: 80px; background: #e2e8f0; border-radius: 50%; display: flex; align-items-center; justify-content: center;">
                                                <i class="fas fa-box-open" style="font-size: 2rem; color: #94a3b8;"></i>
                                            </div>
                                            <h5 class="mb-2" style="color: #64748b;">No products found</h5>
                                            <p class="text-muted mb-3" style="font-size: 0.9rem;">Try adjusting your filters or add your first product</p>
                                            <a href="{{ route('admin.products.create') }}" class="btn" style="background: #6c7ae0; border: none; color: white; border-radius: 8px; padding: 0.6rem 1.5rem; font-weight: 500;">
                                                <i class="fas fa-plus me-2"></i> Add Product
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>

            <!-- Pagination -->
            <div class="p-3 border-top" style="background: #fafbfc;">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<style>
/* Hover effects for buttons */
.btn:hover {
    transform: translateY(-1px);
    opacity: 0.9;
}

/* Custom checkbox styling */
.form-check-input:checked {
    background-color: #6c7ae0;
    border-color: #6c7ae0;
}

/* Smooth transitions */
.btn, .badge, input, select {
    transition: all 0.2s ease;
}

/* Table row hover */
.table tbody tr:hover {
    background-color: #f8fafc !important;
}

/* Action button hover effects */
.btn-group .btn:hover {
    opacity: 0.85;
    transform: translateY(-1px);
}

/* Pagination styling */
.pagination {
    margin-bottom: 0;
}

.pagination .page-link {
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    margin: 0 3px;
    color: #6c7ae0;
    font-weight: 500;
    padding: 0.5rem 0.75rem;
}

.pagination .page-link:hover {
    background-color: #f8fafc;
    border-color: #6c7ae0;
}

.pagination .page-item.active .page-link {
    background: #6c7ae0;
    border-color: #6c7ae0;
}

.pagination .page-item.disabled .page-link {
    color: #94a3b8;
    background-color: #f8fafc;
}

/* Focus states */
input:focus, select:focus {
    border-color: #6c7ae0 !important;
    box-shadow: 0 0 0 0.2rem rgba(108, 122, 224, 0.25) !important;
    outline: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    const productCheckboxes = document.querySelectorAll('.product-checkbox');
    const bulkDeleteForm = document.getElementById('bulk-delete-form');

    selectAllCheckbox.addEventListener('change', function() {
        productCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBulkActions();
    });

    productCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });

    function updateBulkActions() {
        const checkedCount = document.querySelectorAll('.product-checkbox:checked').length;
        
        // Update select-all checkbox state
        selectAllCheckbox.checked = checkedCount === productCheckboxes.length && checkedCount > 0;
        selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < productCheckboxes.length;
        
        // Show delete confirmation if any items selected
        if (checkedCount > 0) {
            // You can add a floating action bar here if needed
        }
    }
    
    // Handle bulk delete via form submission
    bulkDeleteForm.addEventListener('submit', function(e) {
        const checkedCount = document.querySelectorAll('.product-checkbox:checked').length;
        if (checkedCount === 0) {
            e.preventDefault();
            alert('Please select at least one product to delete.');
            return false;
        }
        
        if (!confirm(`Are you sure you want to delete ${checkedCount} selected product(s)?`)) {
            e.preventDefault();
            return false;
        }
    });
});
</script>
@endsection