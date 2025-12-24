@extends('layouts.admin')

@section('title', 'Add New Product')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12 d-flex justify-content-between align-items-center">
            <h2>Add New Product</h2>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Products
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Left Column -->
            <div class="col-md-8">
                <!-- Basic Info -->
                <div class="card mb-3">
                    <div class="card-header"><h5>Basic Information</h5></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" 
                                   class="form-control @error('name') is-invalid @enderror" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Slug</label>
                            <input type="text" name="slug" value="{{ old('slug') }}" 
                                   class="form-control @error('slug') is-invalid @enderror">
                            <small class="text-muted">Leave empty to auto-generate</small>
                            @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Short Description</label>
                            <textarea name="short_description" class="form-control @error('short_description') is-invalid @enderror" rows="2">{{ old('short_description') }}</textarea>
                            @error('short_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Full Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="6">{{ old('description') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="card mb-3">
                    <div class="card-header"><h5>Pricing</h5></div>
                    <div class="card-body row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Regular Price <span class="text-danger">*</span></label>
                            <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0"
                                   class="form-control @error('price') is-invalid @enderror" required>
                            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Discount Price</label>
                            <input type="number" name="discount_price" value="{{ old('discount_price') }}" step="0.01" min="0"
                                   class="form-control @error('discount_price') is-invalid @enderror">
                            @error('discount_price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <!-- Inventory -->
                <div class="card mb-3">
                    <div class="card-header"><h5>Inventory</h5></div>
                    <div class="card-body row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">SKU <span class="text-danger">*</span></label>
                            <input type="text" name="sku" value="{{ old('sku') }}" 
                                   class="form-control @error('sku') is-invalid @enderror" required>
                            @error('sku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stock Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" min="0" 
                                   class="form-control @error('stock_quantity') is-invalid @enderror" required>
                            @error('stock_quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-4">
                <!-- Publish -->
                <div class="card mb-3">
                    <div class="card-header"><h5>Publish</h5></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="active" {{ old('status')=='active'?'selected':'' }}>Active</option>
                                <option value="inactive" {{ old('status')=='inactive'?'selected':'' }}>Inactive</option>
                                <option value="out_of_stock" {{ old('status')=='out_of_stock'?'selected':'' }}>Out of Stock</option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="featured" value="1" class="form-check-input" {{ old('featured') ? 'checked' : '' }}>
                            <label class="form-check-label">Featured Product</label>
                        </div>

                        <!-- Category -->
                        <div class="mb-3">
                            <label class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">Choose...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id')==$category->id?'selected':'' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Images -->
                        <div class="mb-3">
                            <label class="form-label">Product Images <span class="text-danger">*</span></label>
                            <input type="file" name="images[]" accept="image/*" multiple required 
                                   class="form-control @error('images') is-invalid @enderror" onchange="previewImages(event)">
                            <div id="image-preview" class="row g-2 mt-2"></div>
                            @error('images') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-save"></i> Create Product
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Auto-generate slug
document.querySelector('input[name="name"]').addEventListener('input', function() {
    document.querySelector('input[name="slug"]').value = this.value.toLowerCase()
        .replace(/[^\w\s-]/g,'').replace(/\s+/g,'-').replace(/--+/g,'-');
});

// Auto-generate SKU
document.querySelector('input[name="name"]').addEventListener('input', function() {
    const skuField = document.querySelector('input[name="sku"]');
    if(!skuField.value){
        skuField.value = this.value.toUpperCase().replace(/[^\w\s]/g,'').replace(/\s+/g,'-').substring(0,10) + '-' + Math.floor(Math.random()*10000);
    }
});

// Image preview
function previewImages(event){
    const files = event.target.files;
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    Array.from(files).forEach((file,index)=>{
        const reader = new FileReader();
        reader.onload = function(e){
            const div = document.createElement('div');
            div.className = 'col-6';
            div.innerHTML = `
                <div class="position-relative">
                    <img src="${e.target.result}" class="img-thumbnail" style="width:100%;height:100px;object-fit:cover;">
                    <div class="position-absolute top-0 start-0 m-1">
                        <input type="radio" name="primary_image" value="${index}" ${index===0?'checked':''} class="form-check-input">
                    </div>
                </div>
            `;
            preview.appendChild(div);
        }
        reader.readAsDataURL(file);
    });
}
</script>
@endsection
