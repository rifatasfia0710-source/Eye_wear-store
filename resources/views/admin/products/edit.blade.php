{{-- resources/views/admin/products/index.blade.php or wherever you have your products list --}}

@extends('layouts.admin')

@section('title', 'Products')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Products</h2>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Product
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Products Table -->
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            @if($product->images->first())
                                <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                     width="50" height="50" style="object-fit: cover;">
                            @else
                                <div style="width: 50px; height: 50px; background: #ddd;"></div>
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>
                            <span class="badge bg-{{ $product->status == 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>
                        <td>
                            <!-- Edit Button - Opens Modal -->
                            <button type="button" class="btn btn-sm btn-primary" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editProductModal{{ $product->id }}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            
                            <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Delete this product?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Product Modal for Each Product -->
                    <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1" aria-labelledby="editProductModalLabel{{ $product->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editProductModalLabel{{ $product->id }}">Edit Product: {{ $product->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="editForm{{ $product->id }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-body">
                                        <div class="row">
                                            <!-- Left Column -->
                                            <div class="col-md-8">
                                                <!-- Basic Information -->
                                                <div class="card mb-3">
                                                    <div class="card-header">
                                                        <h6 class="mb-0">Basic Information</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <label for="name{{ $product->id }}" class="form-label">Product Name <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" 
                                                                   id="name{{ $product->id }}" 
                                                                   name="name" 
                                                                   value="{{ $product->name }}" 
                                                                   required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="slug{{ $product->id }}" class="form-label">Slug</label>
                                                            <input type="text" class="form-control" 
                                                                   id="slug{{ $product->id }}" 
                                                                   name="slug" 
                                                                   value="{{ $product->slug }}">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="short_description{{ $product->id }}" class="form-label">Short Description</label>
                                                            <textarea class="form-control" 
                                                                      id="short_description{{ $product->id }}" 
                                                                      name="short_description" 
                                                                      rows="2">{{ $product->short_description }}</textarea>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="description{{ $product->id }}" class="form-label">Full Description</label>
                                                            <textarea class="form-control" 
                                                                      id="description{{ $product->id }}" 
                                                                      name="description" 
                                                                      rows="4">{{ $product->description }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Pricing -->
                                                <div class="card mb-3">
                                                    <div class="card-header">
                                                        <h6 class="mb-0">Pricing</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="price{{ $product->id }}" class="form-label">Regular Price <span class="text-danger">*</span></label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">$</span>
                                                                        <input type="number" class="form-control" 
                                                                               id="price{{ $product->id }}" 
                                                                               name="price" 
                                                                               value="{{ $product->price }}" 
                                                                               step="0.01" 
                                                                               min="0" 
                                                                               required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="discount_price{{ $product->id }}" class="form-label">Discount Price</label>
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">$</span>
                                                                        <input type="number" class="form-control" 
                                                                               id="discount_price{{ $product->id }}" 
                                                                               name="discount_price" 
                                                                               value="{{ $product->discount_price }}" 
                                                                               step="0.01" 
                                                                               min="0">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Existing Images -->
                                                <div class="card mb-3">
                                                    <div class="card-header">
                                                        <h6 class="mb-0">Existing Images</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row g-3">
                                                            @forelse($product->images as $image)
                                                                <div class="col-md-3 col-6">
                                                                    <div class="position-relative">
                                                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                                             class="img-thumbnail" 
                                                                             style="width: 100%; height: 120px; object-fit: cover;">
                                                                        @if($image->is_primary)
                                                                            <span class="position-absolute top-0 start-0 m-1 badge bg-primary">Primary</span>
                                                                        @endif
                                                                        <button type="button" 
                                                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                                                                onclick="deleteImage({{ $product->id }}, {{ $image->id }})">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            @empty
                                                                <div class="col-12">
                                                                    <p class="text-muted mb-0">No images uploaded yet.</p>
                                                                </div>
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Right Column -->
                                            <div class="col-md-4">
                                                <!-- Publish -->
                                                <div class="card mb-3">
                                                    <div class="card-header">
                                                        <h6 class="mb-0">Publish</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <label for="status{{ $product->id }}" class="form-label">Status <span class="text-danger">*</span></label>
                                                            <select class="form-select" 
                                                                    id="status{{ $product->id }}" 
                                                                    name="status" 
                                                                    required>
                                                                <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                                                                <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                                <option value="out_of_stock" {{ $product->status == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                                            </select>
                                                        </div>

                                                        <div class="mb-0">
                                                            <div class="form-check">
                                                                <input class="form-check-input" 
                                                                       type="checkbox" 
                                                                       id="featured{{ $product->id }}" 
                                                                       name="featured" 
                                                                       value="1" 
                                                                       {{ $product->featured ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="featured{{ $product->id }}">
                                                                    Featured Product
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Add More Images -->
                                                <div class="card mb-3">
                                                    <div class="card-header">
                                                        <h6 class="mb-0">Add More Images</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <label for="images{{ $product->id }}" class="form-label">Upload Images</label>
                                                            <input type="file" 
                                                                   class="form-control" 
                                                                   id="images{{ $product->id }}" 
                                                                   name="images[]" 
                                                                   accept="image/*" 
                                                                   multiple 
                                                                   onchange="previewImages(event, {{ $product->id }})">
                                                            <small class="text-muted">Select multiple images (Max 5MB each)</small>
                                                        </div>

                                                        <div id="image-preview{{ $product->id }}" class="row g-2"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times"></i> Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Update Product
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal -->

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Hidden form for deleting images -->
<form id="deleteImageForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
// Image preview function
function previewImages(event, productId) {
    const files = event.target.files;
    const preview = document.getElementById('image-preview' + productId);
    preview.innerHTML = '';
    
    if (files.length > 0) {
        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'col-6';
                div.innerHTML = `
                    <div class="position-relative">
                        <img src="${e.target.result}" class="img-thumbnail" style="width: 100%; height: 80px; object-fit: cover;">
                        <small class="text-muted d-block mt-1">New Image ${index + 1}</small>
                    </div>
                `;
                preview.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    }
}

// Delete image function
function deleteImage(productId, imageId) {
    if (confirm('Are you sure you want to delete this image?')) {
        const form = document.getElementById('deleteImageForm');
        form.action = `/admin/products/${productId}/images/${imageId}`;
        form.submit();
    }
}

// Auto-open modal if there are validation errors
@if($errors->any() && session('product_id'))
    document.addEventListener('DOMContentLoaded', function() {
        var productId = {{ session('product_id') }};
        var editModal = new bootstrap.Modal(document.getElementById('editProductModal' + productId));
        editModal.show();
    });
@endif
</script>

@endsection