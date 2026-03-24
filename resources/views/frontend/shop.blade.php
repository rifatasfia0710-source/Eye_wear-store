@extends('layouts.home')

@section('title', 'Shop - Premium Eyewear')

@section('content')

<style>
    .shop-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px 20px;
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 30px;
    }

    @media (max-width: 1024px) {
        .shop-container { grid-template-columns: 1fr; }
        .sidebar { position: static !important; }
    }

    .sidebar {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        height: fit-content;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        position: sticky;
        top: 80px;
    }

    .filter-group {
        margin-bottom: 20px;
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 15px;
    }

    .filter-group:last-child { border-bottom: none; }

    .filter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        padding: 10px 0;
        font-weight: 600;
        font-size: 15px;
        color: #333;
        user-select: none;
    }

    .filter-header:hover { color: #7C3AED; }

    .filter-icon {
        transition: transform 0.3s ease;
        font-size: 12px;
        color: #666;
    }

    .filter-icon.open { transform: rotate(180deg); }

    .filter-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .filter-content.open {
        max-height: 500px;
        overflow-y: auto;
        padding-top: 8px;
    }

    .filter-option {
        padding: 7px 0;
        font-size: 14px;
        color: #555;
        cursor: pointer;
        display: flex;
        align-items: center;
        transition: color 0.2s, padding-left 0.2s;
    }

    .filter-option:hover { color: #7C3AED; padding-left: 4px; }

    .filter-option input[type="checkbox"] {
        margin-right: 10px;
        cursor: pointer;
        width: 16px;
        height: 16px;
        accent-color: #7C3AED;
        flex-shrink: 0;
    }

    .price-inputs {
        display: flex;
        align-items: center;
        gap: 8px;
        padding-top: 8px;
    }

    .price-inputs input {
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 6px;
        padding: 8px 10px;
        font-size: 13px;
        outline: none;
        transition: border-color 0.2s;
    }

    .price-inputs input:focus { border-color: #7C3AED; }

    .apply-btn {
        width: 100%;
        margin-top: 20px;
        padding: 10px;
        background: #7C3AED;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }

    .apply-btn:hover { background: #6D28D9; }

    .active-chips { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 16px; }

    .chip {
        padding: 4px 12px;
        background: #EDE9FE;
        color: #7C3AED;
        border-radius: 20px;
        font-size: 13px;
    }

    .products-section {
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 20px;
    }

    .product-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.13);
    }

    .product-card .img-wrap {
        background: #f3f4f6;
        padding: 20px;
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-card .img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .product-card .info { padding: 16px; }

    .product-card .brand-name {
        font-size: 11px;
        font-weight: 700;
        color: #7C3AED;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 4px;
    }

    .product-card h3 {
        font-size: 15px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .product-card .category-name {
        font-size: 12px;
        color: #9ca3af;
        margin-bottom: 10px;
    }

    .product-card .price {
        font-size: 20px;
        font-weight: 700;
        color: #7C3AED;
        margin-bottom: 12px;
    }

    .add-cart-btn {
        width: 100%;
        padding: 9px;
        background: #7C3AED;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
    }

    .add-cart-btn:hover { background: #6D28D9; }

    .header {
        background: linear-gradient(135deg, #dce3ff 0%, #764ba2 100%);
        color: white;
        padding: 60px 20px;
        text-align: center;
    }

    .header h1 { font-size: 2.5em; font-weight: 600; }
</style>

<!-- Banner -->
<div class="header">
    <h1>Welcome to Our Shop</h1>
</div>

<div class="shop-container">

    <!-- ===== SIDEBAR ===== -->
    <div class="sidebar">
        <form method="GET" action="{{ route('frontend.shop') }}">

            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                <span style="font-size:17px; font-weight:700; color:#1f2937;">Filters</span>
                <a href="{{ route('frontend.shop') }}" style="font-size:12px; color:#7C3AED; text-decoration:none;">Clear All</a>
            </div>

            <!-- BRANDS from DB -->
            <div class="filter-group">
                <div class="filter-header" onclick="toggleFilter(this)">
                    <span>Brand</span>
                    <span class="filter-icon open">▼</span>
                </div>
                <div class="filter-content open">
                    @forelse($brands as $brand)
                        <label class="filter-option">
                            <input type="checkbox"
                                   name="brands[]"
                                   value="{{ $brand->id }}"
                                   {{ in_array($brand->id, request('brands', [])) ? 'checked' : '' }}>
                            {{ $brand->name }}
                        </label>
                    @empty
                        <p style="font-size:13px; color:#9ca3af; padding: 8px 0;">No brands found.</p>
                    @endforelse
                </div>
            </div>

            <!-- CATEGORIES from DB -->
            <div class="filter-group">
                <div class="filter-header" onclick="toggleFilter(this)">
                    <span>Categories</span>
                    <span class="filter-icon open">▼</span>
                </div>
                <div class="filter-content open">
                    @forelse($categories as $category)
                        <label class="filter-option">
                            <input type="checkbox"
                                   name="categories[]"
                                   value="{{ $category->id }}"
                                   {{ in_array($category->id, request('categories', [])) ? 'checked' : '' }}>
                            {{ $category->name }}
                        </label>
                    @empty
                        <p style="font-size:13px; color:#9ca3af; padding: 8px 0;">No categories found.</p>
                    @endforelse
                </div>
            </div>

            <!-- PRICE RANGE -->
            <div class="filter-group">
                <div class="filter-header" onclick="toggleFilter(this)">
                    <span>Price Range</span>
                    <span class="filter-icon open">▼</span>
                </div>
                <div class="filter-content open">
                    <div class="price-inputs">
                        <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}">
                        <span style="color:#9ca3af; flex-shrink:0;">—</span>
                        <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}">
                    </div>
                </div>
            </div>

            <button type="submit" class="apply-btn">Apply Filters</button>

        </form>
    </div>

    <!-- ===== PRODUCTS ===== -->
    <div class="products-section">

        <!-- Active filter chips -->
        @if(request()->hasAny(['brands', 'categories', 'min_price', 'max_price']))
        <div class="active-chips">
            @foreach($brands->whereIn('id', request('brands', [])) as $b)
                <span class="chip">{{ $b->name }}</span>
            @endforeach
            @foreach($categories->whereIn('id', request('categories', [])) as $c)
                <span class="chip">{{ $c->name }}</span>
            @endforeach
            @if(request('min_price') || request('max_price'))
                <span class="chip">৳{{ request('min_price', 0) }} — ৳{{ request('max_price', '') ?: 'any' }}</span>
            @endif
            <a href="{{ route('frontend.shop') }}" class="chip" style="background:#fee2e2; color:#dc2626; text-decoration:none;">
                Clear All x
            </a>
        </div>
        @endif

        <!-- Product count -->
        <h2 style="font-size:20px; font-weight:700; color:#1f2937; margin-bottom:20px;">
            We found <span style="color:#7C3AED;">{{ $products->total() }}</span> products
        </h2>

        <!-- Product Grid -->
        <div class="products-grid">
            @forelse($products as $product)
            <!-- <div class="product-card">
                <div class="img-wrap">
                    <img src="{{ asset('storage/' . $product->primary_image) }}"
                         alt="{{ $product->name }}"
                        onerror="this.src='https://placehold.co/300x300?text=No+Image'">
                </div>
                <div class="info">
                    @if($product->brand)
                        <p class="brand-name">{{ $product->brand->name }}</p>
                    @endif

                    <h3>{{ $product->name }}</h3>

                    @if($product->category)
                        <p class="category-name">{{ $product->category->name }}</p>
                    @endif

                    <p class="price">{{ number_format($product->price, 2) }}</p>

                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="add-cart-btn">Add to Cart</button>
                    </form>
                </div>
            </div> -->
            <div class="product-card" style="cursor:pointer;" onclick="window.location='{{ route('shop.show', $product->slug) }}'">
    <div class="img-wrap">
        <img src="{{ asset('storage/' . $product->primary_image) }}"
             alt="{{ $product->name }}"
             onerror="this.src='https://placehold.co/300x300?text=No+Image'">
    </div>
    <div class="info">
        @if($product->brand)
            <p class="brand-name">{{ $product->brand->name }}</p>
        @endif
        <h3>{{ $product->name }}</h3>
        @if($product->category)
            <p class="category-name">{{ $product->category->name }}</p>
        @endif
        <p class="price">৳{{ number_format($product->price, 2) }}</p>

        {{-- form এ stopPropagation দাও --}}
        <form action="{{ route('cart.store') }}" method="POST" onclick="event.stopPropagation()">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="add-cart-btn">Add to Cart</button>
        </form>
    </div>
</div>
            @empty
                <div style="grid-column: 1/-1; text-align:center; padding: 60px 20px; color:#9ca3af;">
                    <p style="font-size:18px; margin-bottom:12px;">No products found.</p>
                    <a href="{{ route('frontend.shop') }}" style="color:#7C3AED;">Clear filters</a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div style="margin-top: 32px;">
            {{ $products->links() }}
        </div>

    </div>
</div>

<script>
    function toggleFilter(header) {
        const content = header.nextElementSibling;
        const icon = header.querySelector('.filter-icon');
        content.classList.toggle('open');
        icon.classList.toggle('open');
    }
</script>

@endsection