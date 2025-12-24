{{-- resources/views/admin/products/show.blade.php --}}

@extends('layouts.admin')

@section('title', 'Product Details')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Product Details</h2>
                <div>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Product
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Product Images -->
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Product Images</h5>
                </div>
                <div class="card-body">
                    @if($product->primaryImage)
                        <div class="mb-3">
                            <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" 
                                 alt="{{ $product->name }}" 
                                 class="img-fluid rounded"
                                 style="width: 100%; max-height: 400px; object-fit: contain;">
                            <p class="text-center mt-2 text-muted">Primary Image</p>
                        </div>
                    @endif

                    @if($product->images->count() > 1)
                        <div class="row g-2">
                            @foreach($product->images as $image)
                                @if(!$image->is_primary)
                                    <div class="col-3">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                                             alt="{{ $product->name }}" 
                                             class="img-thumbnail"
                                             style="width: 100%; height: 80px; object-fit: cover; cursor: pointer;"
                                             onclick="changeMainImage('{{ asset('storage/' . $image->image_path) }}')">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    @if($product->images->count() == 0)
                        <div class="text-center py-5">
                            <i class="fas fa-image fa-4x text-muted mb-3"></i>
                            <p class="text-muted">No images available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column - Product Information -->
        <div class="col-md-7">
            <!-- Basic Information -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Product Name:</strong></div>
                        <div class="col-md-9">{{ $product->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Slug:</strong></div>
                        <div class="col-md-9"><code>{{ $product->slug }}</code></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Category:</strong></div>
                        <div class="col-md-9">
                            <span class="badge bg-info"></span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3"><strong>SKU:</strong></div>
                        <div class="col-md-9"><code>{{ $product->sku }}</code></div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Status:</strong></div>
                        <div class="col-md-9">
                            @if($product->status == 'active')
                                <span class="badge bg-success">Active</span>
                            @elseif($product->status == 'inactive')
                                <span class="badge bg-secondary">Inactive</span>
                            @else
                                <span class="badge bg-danger">Out of Stock</span>
                            @endif

                            @if($product->featured)
                                <span class="badge bg-warning text-dark ms-2">
                                    <i class="fas fa-star"></i> Featured
                                </span>
                            @endif
                        </div>
                    </div>

                    @if($product->short_description)
                        <div class="row mb-3">
                            <div class="col-md-3"><strong>Short Description:</strong></div>
                            <div class="col-md-9">{{ $product->short_description }}</div>
                        </div>
                    @endif

                    @if($product->description)
                        <div class="row">
                            <div class="col-md-3"><strong>Description:</strong></div>
                            <div class="col-md-9">{{ $product->description }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pricing Information -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Pricing</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Regular Price:</strong></div>
                        <div class="col-md-9">
                            <span class="fs-5">${{ number_format($product->price, 2) }}</span>
                        </div>
                    </div>

                    @if($product->discount_price)
                        <div class="row mb-3">
                            <div class="col-md-3"><strong>Discount Price:</strong></div>
                            <div class="col-md-9">
                                <span class="fs-5 text-danger">${{ number_format($product->discount_price, 2) }}</span>
                                <span class="badge bg-danger ms-2">-{{ $product->discount_percentage }}% OFF</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3"><strong>You Save:</strong></div>
                            <div class="col-md-9">
                                <span class="text-success">${{ number_format($product->price - $product->discount_price, 2) }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Inventory Information -->
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Inventory</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Stock Quantity:</strong></div>
                        <div class="col-md-9">
                            @if($product->stock_quantity == 0)
                                <span class="badge bg-danger fs-6">Out of Stock</span>
                            @elseif($product->stock_quantity <= 10)
                                <span class="badge bg-warning text-dark fs-6">
                                    Low Stock: {{ $product->stock_quantity }} units
                                </span>
                            @else
                                <span class="badge bg-success fs-6">
                                    {{ $product->stock_quantity }} units
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3"><strong>Stock Status:</strong></div>
                        <div class="col-md-9">
                            @if($product->isInStock())
                                <span class="text-success">
                                    <i class="fas fa-check-circle"></i> In Stock
                                </span>
                            @else
                                <span class="text-danger">
                                    <i class="fas fa-times-circle"></i> Out of Stock
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Information -->
            @if($product->meta_title || $product->meta_description)
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">SEO Information</h5>
                    </div>
                    <div class="card-body">
                        @if($product->meta_title)
                            <div class="row mb-3">
                                <div class="col-md-3"><strong>Meta Title:</strong></div>
                                <div class="col-md-9">{{ $product->meta_title }}</div>
                            </div>
                        @endif

                        @if($product->meta_description)
                            <div class="row">
                                <div class="col-md-3"><strong>Meta Description:</strong></div>
                                <div class="col-md-9">{{ $product->meta_description }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Timestamps -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Timestamps</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Created At:</strong></div>
                        <div class="col-md-9">{{ $product->created_at->format('M d, Y h:i A') }}</div>
                    </div>

                    <div class="row">
                        <div class="col-md-3"><strong>Last Updated:</strong></div>
                        <div class="col-md-9">{{ $product->updated_at->format('M d, Y h:i A') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function changeMainImage(imageSrc) {
    const mainImage = document.querySelector('.card-body img.img-fluid');
    if (mainImage) {
        mainImage.src = imageSrc;
    }
}
</script>
@endsection