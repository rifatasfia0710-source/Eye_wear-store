@extends('layouts.home')

@section('title', 'About Us - Premium Eyewear')

@section('content')
    <style>
        body { font-family: 'Inter', sans-serif; }
        .hover-scale { transition: 0.3s ease; }
        .hover-scale:hover { transform: scale(1.05); }
    </style>

<!-- Product Details -->
<section class="py-16">
    <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-2 gap-12">

        <!-- Left Images -->
        <div>
            <!-- Main Image -->
            <div class="bg-gray-200 w-full h-96 flex items-center justify-center rounded-xl">
                <img src="{{ asset('storage/shop-details/product5.webp') }}" 
                     alt="Eyewear" 
                     class="object-contain w-full h-full rounded-xl">
            </div>

            <!-- Thumbnail Images -->
            <div class="flex space-x-3 mt-4">
                <img src="{{ asset('storage/shop-details/product1.webp') }}" alt="Eyewear 1" class="w-20 h-20 object-cover rounded-lg">
                <img src="{{ asset('storage/shop-details/product2.webp') }}" alt="Eyewear 2" class="w-20 h-20 object-cover rounded-lg">
                <img src="{{ asset('storage/shop-details/product3.webp') }}" alt="Eyewear 3" class="w-20 h-20 object-cover rounded-lg">
                <img src="{{ asset('storage/shop-details/product4.webp') }}" alt="Eyewear 4" class="w-20 h-20 object-cover rounded-lg">
            </div>
        </div>

        <!-- Right Content -->
        <div>
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Premium Classic Frame</h2>

            <div class="flex items-center space-x-4 mb-4">
                <span class="text-3xl font-bold text-purple-600">$129</span>
                <span class="line-through text-gray-500">$159</span>
                <span class="text-green-600 font-semibold">20% OFF</span>
            </div>

            <p class="text-gray-600 mb-6">
                Experience unmatched comfort and clarity with our premium eyewear. 
                Designed with ultra-lightweight materials for all-day wear.
            </p>

            <div class="mb-6">
                <h3 class="font-semibold mb-2 text-gray-700">Select Color:</h3>
                <div class="flex space-x-3">
                    <div class="w-8 h-8 rounded-full bg-black cursor-pointer border-2 border-gray-300"></div>
                    <div class="w-8 h-8 rounded-full bg-gray-600 cursor-pointer"></div>
                    <div class="w-8 h-8 rounded-full bg-blue-600 cursor-pointer"></div>
                </div>
            </div>

            <button class="w-full bg-purple-600 text-white py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
                Add to Cart
            </button>
        </div>

    </div>
</section>

<!-- Description + Specs -->
<section class="py-10 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <div>
                <h3 class="text-2xl font-bold mb-3 text-gray-800">Product Description</h3>
                <p class="text-gray-600 leading-7">
                    These classic frames are engineered with precision to provide ultimate comfort 
                    and durability. Perfect for both casual and professional looks.
                </p>
            </div>

            <div>
                <h3 class="text-2xl font-bold mb-3 text-gray-800">Specifications</h3>
                <ul class="text-gray-600 space-y-2">
                    <li>✔ Lightweight acetate frame</li>
                    <li>✔ UV 400 protection lenses</li>
                    <li>✔ Scratch-resistant finish</li>
                    <li>✔ Unisex modern style</li>
                </ul>
            </div>

        </div>
    </div>
</section>

<!-- Customer Reviews -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">

        <h2 class="text-3xl font-bold text-gray-800 mb-8">Customer Reviews</h2>

        <div class="space-y-6">

            <div class="bg-white p-6 rounded-lg shadow">
                <h4 class="font-semibold">Rina Akter</h4>
                <p class="text-sm text-gray-500 mb-2">⭐⭐⭐⭐⭐</p>
                <p class="text-gray-600">Amazing quality! Super comfortable & stylish!</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h4 class="font-semibold">Javed Islam</h4>
                <p class="text-sm text-gray-500 mb-2">⭐⭐⭐⭐</p>
                <p class="text-gray-600">Great frame, delivery was fast.</p>
            </div>

        </div>

    </div>
</section>

<!-- Related Products -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-8 text-gray-800">Related Products</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <!-- Product Card 1 -->
            <div class="product-card bg-white shadow rounded-lg overflow-hidden hover-scale cursor-pointer">
                <img src="{{ asset('storage/product_images/classic-oversized_1724439844.webp') }}" alt="Classic Frame" class="w-full h-48 object-cover" />
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-1">Classic Frame</h3>
                    <p class="text-gray-600 text-sm mb-3">Ray-Ban</p>
                    <div class="flex items-center justify-between">
                        <p class="price text-purple-600 font-bold text-xl">৳99</p>
                        <button class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 transition">Add to Cart</button>
                    </div>
                </div>
            </div>

            <!-- Product Card 2 -->
            <div class="product-card bg-white shadow rounded-lg overflow-hidden hover-scale cursor-pointer">
                <img src="{{ asset('storage/product_images/dior-majesty_1724234557.webp') }}" alt="Modern Metal Frame" class="w-full h-48 object-cover" />
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-1">Modern Metal Frame</h3>
                    <p class="text-gray-600 text-sm mb-3">Gucci</p>
                    <div class="flex items-center justify-between">
                        <span class="text-purple-600 font-bold text-xl">৳150</span>
                        <button class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 transition">Add to Cart</button>
                    </div>
                </div>
            </div>

            <!-- Product Card 3 -->
            <div class="product-card bg-white shadow rounded-lg overflow-hidden hover-scale cursor-pointer">
                <img src="{{ asset('storage/product_images/prada-oversized-sunglasses_1717183016.webp') }}" alt="Golden Round Glasses" class="w-full h-48 object-cover" />
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-1">Golden Round Glasses</h3>
                    <p class="text-gray-600 text-sm mb-3">Armani</p>
                    <div class="flex items-center justify-between">
                        <p class="price text-purple-600 font-bold text-xl">৳140</p>
                        <button class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 transition">Add to Cart</button>
                    </div>
                </div>
            </div>

            <!-- Product Card 4 -->
            <div class="product-card bg-white shadow rounded-lg overflow-hidden hover-scale cursor-pointer">
                <img src="{{ asset('storage/product_images/roundify-glasses_1724931415.webp') }}" alt="Brown Vintage Frame" class="w-full h-48 object-cover" />
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-1">Brown Vintage Frame</h3>
                    <p class="text-gray-600 text-sm mb-3">Oakley</p>
                    <div class="flex items-center justify-between">
                        <p class="price text-purple-600 font-bold text-xl">৳85</p>
                        <button class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 transition">Add to Cart</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection