@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex gap-6">
        <!-- Filters Sidebar -->
        <aside class="w-64 flex-shrink-0">
            <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                <h3 class="text-lg font-semibold mb-4">Filters</h3>
                
                <form method="GET" action="{{ route('products.index') }}" id="filterForm">
                    <!-- Search -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="w-full border rounded px-3 py-2" placeholder="Search products...">
                    </div>

                    <!-- Category Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Category</label>
                        <select name="category" class="w-full border rounded px-3 py-2">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }} ({{ $category->products_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Brand Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Brand</label>
                        <select name="brand" class="w-full border rounded px-3 py-2">
                            <option value="">All Brands</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" 
                                    {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }} ({{ $brand->products_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Frame Type Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Frame Type</label>
                        <select name="frame_type" class="w-full border rounded px-3 py-2">
                            <option value="">All Types</option>
                            <option value="full-rim" {{ request('frame_type') == 'full-rim' ? 'selected' : '' }}>Full Rim</option>
                            <option value="semi-rimless" {{ request('frame_type') == 'semi-rimless' ? 'selected' : '' }}>Semi Rimless</option>
                            <option value="rimless" {{ request('frame_type') == 'rimless' ? 'selected' : '' }}>Rimless</option>
                        </select>
                    </div>

                    <!-- Gender Filter -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Gender</label>
                        <select name="gender" class="w-full border rounded px-3 py-2">
                            <option value="">All</option>
                            <option value="men" {{ request('gender') == 'men' ? 'selected' : '' }}>Men</option>
                            <option value="women" {{ request('gender') == 'women' ? 'selected' : '' }}>Women</option>
                            <option value="unisex" {{ request('gender') == 'unisex' ? 'selected' : '' }}>Unisex</option>
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-2">Price Range</label>
                        <div class="flex gap-2">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" 
                                   class="w-full border rounded px-3 py-2" placeholder="Min">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" 
                                   class="w-full border rounded px-3 py-2" placeholder="Max">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                        Apply Filters
                    </button>
                    
                    @if(request()->hasAny(['search', 'category', 'brand', 'frame_type', 'gender', 'min_price', 'max_price']))
                        <a href="{{ route('products.index') }}" class="block text-center mt-3 text-sm text-gray-600 hover:text-gray-800">
                            Clear All Filters
                        </a>
                    @endif
                </form>
            </div>
        </aside>

        <!-- Product Grid -->
        <main class="flex-1">
            <!-- Toolbar -->
            <div class="bg-white rounded-lg shadow p-4 mb-6 flex justify-between items-center">
                <div class="text-sm text-gray-600">
                    Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                </div>

                <div class="flex gap-4 items-center">
                    <!-- View Toggle -->
                    <div class="flex gap-2">
                        <button onclick="setView('grid')" class="p-2 border rounded hover:bg-gray-100" id="gridViewBtn">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        </button>
                        <button onclick="setView('list')" class="p-2 border rounded hover:bg-gray-100" id="listViewBtn">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>

                    <!-- Sort -->
                    <form method="GET" class="inline-block">
                        @foreach(request()->except('sort', 'per_page') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <select name="sort" onchange="this.form.submit()" class="border rounded px-3 py-2">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="popularity" {{ request('sort') == 'popularity' ? 'selected' : '' }}>Most Popular</option>
                        </select>
                    </form>
                </div>
            </div>

            <!-- Products Grid -->
            <div id="productsContainer" class="grid grid-cols-3 gap-6">
                @forelse($products as $product)
                    <div class="product-card bg-white rounded-lg shadow hover:shadow-lg transition">
                        <a href="{{ route('products.show', $product->slug) }}">
                            <div class="aspect-square overflow-hidden rounded-t-lg">
                                <img src="{{ $product->primaryImage?->image_path ?? '/images/placeholder.jpg' }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover hover:scale-105 transition">
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-lg mb-1">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-600 mb-2">{{ $product->brand->name }}</p>
                                <div class="flex items-center gap-2">
                                    @if($product->sale_price)
                                        <span class="text-lg font-bold text-red-600">${{ $product->sale_price }}</span>
                                        <span class="text-sm text-gray-500 line-through">${{ $product->price }}</span>
                                    @else
                                        <span class="text-lg font-bold">${{ $product->price }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-12">
                        <p class="text-gray-500">No products found matching your criteria.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </main>
    </div>
</div>

<script>
function setView(view) {
    const container = document.getElementById('productsContainer');
    if (view === 'grid') {
        container.className = 'grid grid-cols-3 gap-6';
    } else {
        container.className = 'flex flex-col gap-4';
        document.querySelectorAll('.product-card').forEach(card => {
            card.classList.add('flex', 'flex-row');
        });
    }
}
</script>
@endsection