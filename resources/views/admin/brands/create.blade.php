@extends('admin.layouts.app')

@section('title', 'Add New Brand')
@section('page-title', 'Add New Brand')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.brands.index') }}" class="text-gray-600 hover:text-gray-900">
            <i class="fas fa-arrow-left mr-2"></i> Back to Brands
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Brand Information</h2>
        </div>

        <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="p-6 space-y-6">
                <!-- Brand Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Brand Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           id="name" 
                           value="{{ old('name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                           placeholder="Enter brand name"
                           required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug (auto-generated) -->
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">
                        URL Slug
                    </label>
                    <input type="text" 
                           name="slug" 
                           id="slug" 
                           value="{{ old('slug') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 bg-gray-50"
                           placeholder="Auto-generated from name"
                           readonly>
                    <p class="mt-1 text-xs text-gray-500">Automatically generated from brand name</p>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                              placeholder="Brief description about the brand">{{ old('description') }}</textarea>
                </div>

                <!-- Website -->
                <div>
                    <label for="website" class="block text-sm font-medium text-gray-700 mb-2">
                        Website
                    </label>
                    <input type="url" 
                           name="website" 
                           id="website" 
                           value="{{ old('website') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                           placeholder="https://example.com">
                </div>

                <!-- Logo Upload -->
                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">
                        Brand Logo
                    </label>
                    <input type="file" 
                           name="logo" 
                           id="logo" 
                           accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <p class="mt-1 text-xs text-gray-500">Upload brand logo (PNG, JPG, max 2MB)</p>
                    
                    <div id="logoPreview" class="mt-4"></div>
                </div>

                <!-- Status -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1" 
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Active (visible to customers)</span>
                    </label>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex justify-end gap-4">
                <a href="{{ route('admin.brands.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-save mr-2"></i> Create Brand
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
// Auto-generate slug from brand name
document.getElementById('name').addEventListener('input', function(e) {
    const slug = e.target.value
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
    document.getElementById('slug').value = slug;
});

// Logo preview
document.getElementById('logo').addEventListener('change', function(e) {
    const preview = document.getElementById('logoPreview');
    preview.innerHTML = '';
    
    const file = e.target.files[0];
    if (file && file.type.startsWith('image/')) {
        if (file.size > 2 * 1024 * 1024) {
            alert('Image is too large. Max size is 2MB');
            this.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(event) {
            preview.innerHTML = `
                <img src="${event.target.result}" class="w-32 h-32 object-contain border-2 border-gray-200 rounded-lg p-2">
            `;
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endpush
@endsection