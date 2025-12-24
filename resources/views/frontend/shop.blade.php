@extends('layouts.home')

@section('title', 'About Us - Premium Eyewear')

@section('content')

<style>
    /* Shop Layout Container */
    .shop-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px 20px;
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 30px;
    }

    /* Mobile Responsive */
    @media (max-width: 1024px) {
        .shop-container {
            grid-template-columns: 1fr;
        }
        
        .sidebar {
            position: static !important;
        }
    }

    /* Sidebar Styles */
    .sidebar {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        height: fit-content;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        position: sticky;
        top: 20px;
    }
    
    .filter-group {
        margin-bottom: 20px;
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 15px;
    }
    
    .filter-group:last-child {
        border-bottom: none;
    }
    
    .filter-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        padding: 10px 0;
        font-weight: 600;
        font-size: 15px;
        color: #333;
    }
    
    .filter-header:hover {
        color: #4F46E5;
    }
    
    .filter-icon {
        transition: transform 0.3s ease;
        font-size: 12px;
        color: #666;
    }
    
    .filter-icon.open {
        transform: rotate(180deg);
    }
    
    .filter-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
    }
    
    .filter-content.open {
        max-height: 500px;
        padding-top: 10px;
    }
    
    .filter-option {
        padding: 8px 0;
        font-size: 14px;
        color: #555;
        cursor: pointer;
        display: flex;
        align-items: center;
        transition: color 0.2s;
    }
    
    .filter-option:hover {
        color: #4F46E5;
        padding-left: 5px;
    }
    
    .filter-option input[type="checkbox"] {
        margin-right: 10px;
        cursor: pointer;
        width: 16px;
        height: 16px;
        accent-color: #4F46E5;
    }
    
    .color-option {
        display: inline-block;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        margin: 5px 8px 5px 0;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.2s;
    }
    
    .color-option:hover {
        border-color: #4F46E5;
        transform: scale(1.1);
    }
    
    .color-option.selected {
        border-color: #4F46E5;
        box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
    }
    
    .clear-filters {
        margin-top: 15px;
        padding: 10px;
        background: #f8f8f8;
        text-align: center;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
        color: #666;
        transition: all 0.2s;
    }
    
    .clear-filters:hover {
        background: #4F46E5;
        color: white;
    }

    /* Products Section */
    .products-section {
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 20px;
    }

    .product-card {
        background: #fff;
        padding: 15px;
        border-radius: 12px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .product-card img {
        width: 100%;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .product-card h3 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .product-card p {
        color: #666;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .product-card .price {
        font-size: 20px;
        font-weight: 700;
        color: #4F46E5;
    }
     .header {
            background: linear-gradient(135deg, #dce3ff 0%, #764ba2 100%);
            color: white;
            padding: 60px 20px;
            text-align: center;
            margin-top: 30px;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .header p {
            font-size: 1.1em;
            opacity: 0.95;
        }

</style>

<!-- Main Shop Layout -->
 <div class="header">
        <h1>Welcome to Our Shop</h1>
    </div>
<div class="shop-container">
    
    <!-- Sidebar (Left Side) -->
    <div class="sidebar">
        <!-- Brand Filter -->
        <div class="filter-group">
            <div class="filter-header" onclick="toggleFilter(this)">
                <span>Brand</span>
                <span class="filter-icon">▼</span>
            </div>
            <div class="filter-content open">
                <label class="filter-option">
                    <input type="checkbox" name="brand" value="swarovski">
                    SWAROVSKI
                </label>
                <label class="filter-option">
                    <input type="checkbox" name="brand" value="charmont">
                    Z Charmont
                </label>
                <label class="filter-option">
                    <input type="checkbox" name="brand" value="gucci">
                    GUCCI
                </label>
                <label class="filter-option">
                    <input type="checkbox" name="brand" value="dior">
                    Dior
                </label>
                <label class="filter-option">
                    <input type="checkbox" name="brand" value="chanel">
                    CHANEL
                </label>
            </div>
        </div>
        
        <!-- Categories Filter -->
        <div class="filter-group">
            <div class="filter-header" onclick="toggleFilter(this)">
                <span>Categories</span>
                <span class="filter-icon">▼</span>
            </div>
            <div class="filter-content open">
                <label class="filter-option">
                    <input type="checkbox" name="category" value="eyeglasses">
                    Eyeglasses
                </label>
                <label class="filter-option">
                    <input type="checkbox" name="category" value="women">
                    Women's Eyewear
                </label>
                <label class="filter-option">
                    <input type="checkbox" name="category" value="men">
                    Men's Eyewear
                </label>
                <label class="filter-option">
                    <input type="checkbox" name="category" value="sunglasses">
                    Sunglasses
                </label>
                <label class="filter-option">
                    <input type="checkbox" name="category" value="contacts">
                    Contact Lenses
                </label>
            </div>
        </div>
        
        <!-- Size Filter -->
        <!-- <div class="filter-group">
            <div class="filter-header" onclick="toggleFilter(this)">
                <span>Size</span>
                <span class="filter-icon">▼</span>
            </div>
            <div class="filter-content">
                <label class="filter-option">
                    <input type="checkbox" name="size" value="38">
                    38
                </label>
                <label class="filter-option">
                    <input type="checkbox" name="size" value="m">
                    M
                </label>
            </div>
        </div> -->
        
        <!-- Color Filter -->
        <div class="filter-group">
            <div class="filter-header" onclick="toggleFilter(this)">
                <span>Color</span>
                <span class="filter-icon">▼</span>
            </div>
            <div class="filter-content">
                <div style="padding: 5px 0;">
                    <span class="color-option" style="background: #FFD700;" onclick="selectColor(this)" title="Yellow"></span>
                    <span class="color-option" style="background: #22C55E;" onclick="selectColor(this)" title="Green"></span>
                    <span class="color-option" style="background: #EF4444;" onclick="selectColor(this)" title="Red"></span>
                    <span class="color-option" style="background: #000;" onclick="selectColor(this)" title="Black"></span>
                    <span class="color-option" style="background: #6B7280;" onclick="selectColor(this)" title="Gray"></span>
                    <span class="color-option" style="background: #fff; border: 2px solid #ddd;" onclick="selectColor(this)" title="White"></span>
                </div>
            </div>
        </div>
        
        <!-- Clear Filters Button -->
        <div class="clear-filters" onclick="clearAllFilters()">
            Clear All Filters
        </div>
    </div>

    <!-- Products Section (Right Side) -->
    <div class="products-section">
        <div class="products-grid">
            <!-- Product Card 1 -->
            <div class="product-card">
                <img src="{{ asset('storage/product_images/classic-oversized_1724439844.webp') }}" alt="Classic Frame" />
                <h3>Classic Frame</h3>
                <p>Ray-Ban</p>
                <div class="flex items-center justify-between">
                <p class="price">৳99</p>
                <button class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 transition">Add to Cart</button>
                </div>
            </div>

            <!-- Product Card 2 -->
            <div class="product-card">
                <img src="{{ asset('storage/product_images/dior-majesty_1724234557.webp') }}" alt="Modern Metal Frame" />
                <h3>Modern Metal Frame</h3>
                <p>Gucci</p>
                <!-- <p class="price">$120</p> -->
                 <div class="flex items-center justify-between">
                   <span class="text-purple-600 font-bold text-xl">৳150</span>
                 <button class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 transition">Add to Cart</button>
                </div>
            </div>

            <!-- Product Card 3 -->
            <div class="product-card">
                <img src="{{ asset('storage/product_images/prada-oversized-sunglasses_1717183016.webp') }}" alt="Golden Round Glasses" />
                <h3>Golden Round Glasses</h3>
                <p>Armani</p>
                <div class="flex items-center justify-between">
                <p class="price">৳140</p>
                <button class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 transition">Add to Cart</button>
                </div>
            </div>

            <!-- Product Card 4 -->
            <div class="product-card">
                <img src="{{ asset('storage/product_images/roundify-glasses_1724931415.webp') }}" alt="Brown Vintage Frame" />
                <h3>Brown Vintage Frame</h3>
                <p>Oakley</p>
                <div class="flex items-center justify-between">
                <p class="price">৳85</p>
                <button class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 transition">Add to Cart</button>
                </div>
            </div>

            <!-- Product Card 5 -->
            <div class="product-card">
                <img src="{{ asset('storage/product_images/titan-thin-horn_1724836003.webp') }}" alt="Transparent Frame" />
                <h3>Transparent Frame</h3>
                <p>Ray-Ban</p>
                <div class="flex items-center justify-between">
                <p class="price">৳110</p>
                <button class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 transition">Add to Cart</button>
                </div>
            </div>

            <!-- Product Card 6 -->
            <div class="product-card">
                <img src="{{ asset('storage/product_images/silver-full-rim-square-eyeglasses-otis-201440_2_1714208202.webp') }}" alt="Premium Silver Frame" />
                <h3>Premium Silver Frame</h3>
                <p>Gucci</p>
                <div class="flex items-center justify-between">
                <p class="price">৳160</p>
                <button class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 transition">Add to Cart</button>
                </div>
            </div>
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
    
    function selectColor(colorElement) {
        colorElement.classList.toggle('selected');
    }
    
    function clearAllFilters() {
        // Clear all checkboxes
        document.querySelectorAll('.sidebar input[type="checkbox"]').forEach(cb => {
            cb.checked = false;
        });
        
        // Clear all color selections
        document.querySelectorAll('.color-option').forEach(color => {
            color.classList.remove('selected');
        });
    }
</script>

@endsection