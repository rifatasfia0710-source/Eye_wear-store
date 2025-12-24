<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VisionStyle - Premium Eyewear</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- jQuery first -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<!-- Then Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .hover-scale { transition: transform 0.3s ease; }
        .hover-scale:hover { transform: scale(1.05); }
        .banner-item {
    height: 400px;
    border-radius: 10px;
}

</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-gray-100 shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="text-2xl font-bold text-purple-600">VisionStyle</div>
                
                <div class="hidden md:flex space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-purple-600 transition">Home</a>
                    <a href="{{ route('shop.index') }}" class="text-gray-700 hover:text-purple-600 transition">Shop</a>
                    <a href="#" class="text-gray-700 hover:text-purple-600 transition">FAQ's</a>
                    <a href="{{ route('admin.aboutus.index') }}" class="text-gray-700 hover:text-purple-600 transition">About Us</a>

                    <a href="{{ route('contact.show') }}" class="text-gray-700 hover:text-purple-600 transition">Contact</a>
                     <!-- <a href="#" class="text-gray-700 hover:text-purple-600 transition">FAQ's</a> -->
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-gray-700 hover:text-purple-600">
            
                    
                    
                <!-- Search -->
                <button class="text-gray-700 hover:text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                <!-- User Icon -->
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-purple-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </a>

                <!-- Cart -->
                <button class="text-gray-700 hover:text-purple-600 relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span class="absolute -top-2 -right-2 bg-purple-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                </button>

                <!-- Login Button -->
                <a href="{{ route('login') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    Login
                </a>

                <!-- Register Button -->
                <a href="{{ route('register') }}" class="px-4 py-2 border border-purple-600 text-purple-600 rounded-lg hover:bg-purple-600 hover:text-white transition">
                    Register
                </a>
</div>


         </div>
    </div>
    </div>
</nav>

<!-- Filter Sidebar -->
<aside class="bg-white rounded-lg shadow-md p-6 h-fit sticky top-24">
    <!-- Filter Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Filter</h2>
        <button class="text-sm text-purple-600 hover:text-purple-700">Clear All</button>
    </div>

    <!-- Brands Section -->
    <div class="mb-6">
        <h3 class="font-semibold text-gray-800 mb-3">Brands</h3>
        <div class="space-y-2">
            <label class="flex items-center cursor-pointer hover:bg-gray-50 p-2 rounded">
                <input type="checkbox" class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                <span class="ml-2 text-gray-700">SWAROVSKI</span>
            </label>
            <label class="flex items-center cursor-pointer hover:bg-gray-50 p-2 rounded">
                <input type="checkbox" class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                <span class="ml-2 text-gray-700">Z Charment</span>
            </label>
            <label class="flex items-center cursor-pointer hover:bg-gray-50 p-2 rounded">
                <input type="checkbox" class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                <span class="ml-2 text-gray-700">GUCCI</span>
            </label>
            <label class="flex items-center cursor-pointer hover:bg-gray-50 p-2 rounded">
                <input type="checkbox" class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                <span class="ml-2 text-gray-700">Dior</span>
            </label>
            <label class="flex items-center cursor-pointer hover:bg-gray-50 p-2 rounded">
                <input type="checkbox" class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                <span class="ml-2 text-gray-700">CHANEL</span>
            </label>
            <button class="text-sm text-purple-600 hover:text-purple-700 mt-2">Show More</button>
        </div>
    </div>

    <hr class="my-6">

    <!-- Categories Section -->
    <div class="mb-6">
        <h3 class="font-semibold text-gray-800 mb-3">Categories</h3>
        <div class="space-y-2">
            <label class="flex items-center justify-between cursor-pointer hover:bg-gray-50 p-2 rounded">
                <div class="flex items-center">
                    <input type="checkbox" class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                    <span class="ml-2 text-gray-700">Eyeglasses</span>
                </div>
                <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded">2</span>
            </label>
            <label class="flex items-center justify-between cursor-pointer hover:bg-gray-50 p-2 rounded">
                <div class="flex items-center">
                    <input type="checkbox" class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                    <span class="ml-2 text-gray-700">Women's Eyewear</span>
                </div>
                <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded">25</span>
            </label>
            <label class="flex items-center justify-between cursor-pointer hover:bg-gray-50 p-2 rounded">
                <div class="flex items-center">
                    <input type="checkbox" class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                    <span class="ml-2 text-gray-700">Men's Eyewear</span>
                </div>
                <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded">8</span>
            </label>
            <label class="flex items-center justify-between cursor-pointer hover:bg-gray-50 p-2 rounded">
                <div class="flex items-center">
                    <input type="checkbox" class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                    <span class="ml-2 text-gray-700">Sunglasses</span>
                </div>
                <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded">5</span>
            </label>
            <label class="flex items-center justify-between cursor-pointer hover:bg-gray-50 p-2 rounded">
                <div class="flex items-center">
                    <input type="checkbox" class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                    <span class="ml-2 text-gray-700">Contact Lenses</span>
                </div>
                <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded">5</span>
            </label>
        </div>
    </div>

    <hr class="my-6">

    <!-- Internal Storage Section -->
    <div class="mb-6">
        <h3 class="font-semibold text-gray-800 mb-3">Internal Storage</h3>
        <div class="space-y-2">
            <label class="flex items-center justify-between cursor-pointer hover:bg-gray-50 p-2 rounded">
                <div class="flex items-center">
                    <input type="checkbox" class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                    <span class="ml-2 text-gray-700">SS</span>
                </div>
                <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded">2</span>
            </label>
            <label class="flex items-center justify-between cursor-pointer hover:bg-gray-50 p-2 rounded">
                <div class="flex items-center">
                    <input type="checkbox" class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                    <span class="ml-2 text-gray-700">M</span>
                </div>
                <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded">1</span>
            </label>
        </div>
    </div>

    <hr class="my-6">

    <!-- Color Filter -->
    <div class="mb-6">
        <h3 class="font-semibold text-gray-800 mb-3">Color</h3>
        <div class="flex flex-wrap gap-3">
            <button class="w-10 h-10 rounded-full bg-yellow-400 border-2 border-gray-300 hover:border-purple-600 transition"></button>
            <button class="w-10 h-10 rounded-full bg-yellow-600 border-2 border-gray-300 hover:border-purple-600 transition"></button>
            <button class="w-10 h-10 rounded-full bg-green-500 border-2 border-gray-300 hover:border-purple-600 transition"></button>
            <button class="w-10 h-10 rounded-full bg-gray-400 border-2 border-gray-300 hover:border-purple-600 transition"></button>
            <button class="w-10 h-10 rounded-full bg-red-600 border-2 border-gray-300 hover:border-purple-600 transition"></button>
            <button class="w-10 h-10 rounded-full bg-black border-2 border-gray-300 hover:border-purple-600 transition"></button>
            <button class="w-10 h-10 rounded-full bg-blue-900 border-2 border-gray-300 hover:border-purple-600 transition"></button>
            <button class="w-10 h-10 rounded-full bg-white border-2 border-gray-300 hover:border-purple-600 transition"></button>
        </div>
    </div>

    <hr class="my-6">

    <!-- Price Range -->
    <div class="mb-6">
        <h3 class="font-semibold text-gray-800 mb-3">Price</h3>
        <div class="flex items-center gap-3">
            <input type="number" placeholder="50" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            <span class="text-gray-500">-</span>
            <input type="number" placeholder="52000" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
        </div>
    </div>

    <!-- Apply Filters Button -->
    <button class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
        Apply Filters
    </button>
</aside>
<!-- Products Section Header -->
<div class="mb-6">
    <!-- Results and Sort Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
        <h2 class="text-2xl font-bold text-gray-800">
            We Found <span class="text-purple-600">85</span> Items For You!
        </h2>
        
        <div class="flex items-center gap-4">
            <!-- Sort Dropdown -->
            <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white text-gray-700">
                <option>Sort by: Featured</option>
                <option>Price: Low to High</option>
                <option>Price: High to Low</option>
                <option>Newest First</option>
                <option>Best Selling</option>
            </select>

            <!-- View Toggle -->
            <div class="flex border border-gray-300 rounded-lg overflow-hidden">
                <button class="px-3 py-2 bg-purple-600 text-white hover:bg-purple-700 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                </button>
                <button class="px-3 py-2 bg-white text-gray-700 hover:bg-gray-100 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Active Filters -->
    <div class="flex flex-wrap items-center gap-2">
        <span class="text-sm text-gray-600">Active Filters:</span>
        <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm flex items-center gap-2">
            Women's Eyewear
            <button class="hover:text-purple-900">×</button>
        </span>
        <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm flex items-center gap-2">
            GUCCI
            <button class="hover:text-purple-900">×</button>
        </span>
        <button class="text-sm text-purple-600 hover:text-purple-700 underline">Clear All</button>
    </div>
</div>
<!-- Single Product Card -->
<div class="bg-white rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group">
    <!-- Product Image Container -->
    <div class="relative bg-gradient-to-br from-pink-50 to-purple-50 p-6 aspect-square">
        <img src="path-to-image.jpg" alt="Product Name" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300">
        
        <!-- Wishlist Button -->
        <button class="absolute top-3 right-3 w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center hover:bg-purple-600 hover:text-white transition-all duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
        </button>

        <!-- Out of Stock Badge (conditional) -->
        <!-- <div class="absolute top-3 left-3 bg-red-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
            Out of stock
        </div> -->

        <!-- New Badge (conditional) -->
        <div class="absolute top-3 left-3 bg-green-500 text-white text-xs font-semibold px-3 py-1 rounded-full">
            New
        </div>

        <!-- Quick View Button (shows on hover) -->
        <button class="absolute bottom-3 left-1/2 -translate-x-1/2 bg-purple-600 text-white px-6 py-2 rounded-lg opacity-0 group-hover:opacity-100 transition-all duration-200 hover:bg-purple-700">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
            Quick View
        </button>
    </div>

    <!-- Product Info -->
    <div class="p-4">
        <!-- Product Name -->
        <h3 class="text-lg font-semibold text-gray-800 mb-2 hover:text-purple-600 transition cursor-pointer">
            Z Charment Square
        </h3>

        <!-- Rating -->
        <div class="flex items-center gap-2 mb-3">
            <div class="flex text-yellow-400">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
            </div>
            <span class="text-sm text-gray-600">(128 reviews)</span>
        </div>

        <!-- Price -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <span class="text-2xl font-bold text-purple-600">৳270</span>
                <span class="text-sm text-gray-400 line-through">৳550</span>
            </div>
            <!-- <span class="text-xs text-red-500 font-semibold">Out of stock</span> -->
        </div>

        <!-- Add to Cart Button -->
        <button class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            Add to Cart
        </button>
    </div>
</div>
<!-- Main Shop Content (Place between navbar and footer) -->
<main class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Left Sidebar: Filters (Part 1) -->
        <aside class="lg:col-span-1">
            <!-- Insert Filter Sidebar code from Part 1 here -->
        </aside>

        <!-- Right Content: Products -->
        <div class="lg:col-span-3">
            
            <!-- Products Header (Part 2) -->
            <div class="mb-6">
                <!-- Insert Products Header code from Part 2 here -->
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
                
                <!-- Product Card 1 (Part 3) -->
                <!-- Insert Product Card code from Part 3 here -->
                
                <!-- Product Card 2 -->
                <!-- Repeat Product Card -->
                
                <!-- Product Card 3 -->
                <!-- Repeat Product Card -->
                
                <!-- Product Card 4 -->
                <!-- Repeat Product Card -->
                
                <!-- Product Card 5 -->
                <!-- Repeat Product Card -->
                
                <!-- Product Card 6 -->
                <!-- Repeat Product Card -->
                
                <!-- Add more product cards as needed -->
            </div>

            <!-- Pagination -->
            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8">
                <p class="text-gray-600">Showing <span class="font-semibold">1-9</span> of <span class="font-semibold">85</span> results</p>
                
                <div class="flex gap-2">
                    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-purple-600 hover:text-white hover:border-purple-600 transition disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                        Previous
                    </button>
                    <button class="px-4 py-2 bg-purple-600 text-white border border-purple-600 rounded-lg">1</button>
                    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-purple-600 hover:text-white hover:border-purple-600 transition">2</button>
                    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-purple-600 hover:text-white hover:border-purple-600 transition">3</button>
                    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-purple-600 hover:text-white hover:border-purple-600 transition">...</button>
                    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-purple-600 hover:text-white hover:border-purple-600 transition">10</button>
                    <button class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-purple-600 hover:text-white hover:border-purple-600 transition">
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>
 <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-white text-xl font-bold mb-4">VisionStyle</h3>
                    <p class="text-sm">Your trusted destination for premium eyewear. See the world clearly, stylishly.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Shop</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Prescription Glasses</a></li>
                        <li><a href="#" class="hover:text-white transition">Sunglasses</a></li>
                        <li><a href="#" class="hover:text-white transition">Blue Light Glasses</a></li>
                        <li><a href="#" class="hover:text-white transition">Kids Eyewear</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Support</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('contact.show') }}" class="hover:text-white transition">Contact Us</a></li>
                        <li><a href="#" class="hover:text-white transition">Delivery Policy</a></li>
                        <li><a href="#" class="hover:text-white transition">Returns</a></li>
                        <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="hover:text-white transition">Facebook</a>
                        <a href="#" class="hover:text-white transition">Instagram</a>
                        <a href="#" class="hover:text-white transition">Twitter</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>&copy; 2024 VisionStyle. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>

<script>
  $(document).ready(function() {
    $('.your-select').select2();
  });
</script>
