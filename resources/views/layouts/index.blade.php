@extends('layouts.home')

@section('title', 'Eyewear')
@section('content')

<style>
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .hover-scale { transition: transform 0.3s ease; }
        .hover-scale:hover { transform: scale(1.05); }
        .banner-item {
                height: 400px;
                border-radius: 10px;
            }
        /* Remove whitespace between navbar and hero */
.banner-area-two {
    margin-top: 0 !important;
    padding-top: 0 !important;
}

/* Ensure no extra spacing from navbar */
nav {
    margin-bottom: 0 !important;
}
            
</style>

<!-- Hero Section -->
<div class="banner-area-two ">
    <div class="banner-slider owl-carousel owl-theme">
        
        <div class="banner-item" style="background-image: url('{{ asset('storage/slider/1728750992.jpg') }}'); 
        background-size: cover; 
        background-position: center; 
        background-repeat: no-repeat;
        min-height: 500px; 
        display: flex; 
        align-items: center; 
        justify-content: space-between; padding: 0 5%;">
            
            <!-- Left side - Decorative plants -->
            <div class="banner-left" style="flex: 0 0 30%; display: flex; align-items: flex-end; gap: 20px;">
                <!-- Add your plant images or keep as part of background -->
            </div>
            
            <!-- Right side - Content -->
            <!-- <div class="banner-content" style="flex: 0 0 50%; text-align: center; color: white;"> -->
                <!-- <h3 style="font-family: 'Georgia', serif; font-size: 48px; margin-bottom: 10px;">Don't Miss</h3>
                <h2 style="font-size: 56px; font-weight: 600; margin-bottom: 20px;">Our Latest Collection</h2>
                 -->
                <!-- Logo -->
                <!-- <div class="banner-logo" style="margin-bottom: 40px;">
                    <img src="{{ asset('path-to-your-logo.png') }}" alt="Goose Glasses" style="max-width: 150px;">
                </div>
                
                Product Image (Glasses)
                <div class="banner-product">
                    <img src="{{ asset('path-to-glasses-image.png') }}" alt="Glasses" style="max-width: 400px;">
                </div> -->
            <!-- </div> -->
        </div>
        
        <!-- Add more slides as needed -->
    </div>
    
    
</div>
    
    </div>
</div>
            </div>
        </div>
    </div>
</section>



    <!-- Categories Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Shop by Category</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 text-center hover-scale cursor-pointer">
                    <div class="text-5xl mb-4">👓</div>
                    <h3 class="text-xl font-semibold mb-2">Prescription</h3>
                    <p class="text-gray-600">Clear vision, perfect fit</p>
                </div>
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-6 text-center hover-scale cursor-pointer">
                    <div class="text-5xl mb-4">🕶️</div>
                    <h3 class="text-xl font-semibold mb-2">Sunglasses</h3>
                    <p class="text-gray-600">UV protection & style</p>
                </div>
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 text-center hover-scale cursor-pointer">
                    <div class="text-5xl mb-4">💼</div>
                    <h3 class="text-xl font-semibold mb-2">Blue Light</h3>
                    <p class="text-gray-600">Digital eye strain relief</p>
                </div>
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 text-center hover-scale cursor-pointer">
                    <div class="text-5xl mb-4">👶</div>
                    <h3 class="text-xl font-semibold mb-2">Kids</h3>
                    <p class="text-gray-600">Durable & playful</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <!-- <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Featured Products</h2>
                <a href="#" class="text-purple-600 font-semibold hover:text-purple-700">View All →</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
               @forelse($products as $product)

                <div class="bg-white rounded-xl shadow-md overflow-hidden hover-scale cursor-pointer">           
                    <div class="bg-gray-200 h-64 flex items-center justify-center overflow-hidden">
                        @if($product->productImages && $product->productImages->isNotEmpty())
                            <img src="{{ asset('storage/' . $product->productImages->first()->image_path) }}" 
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover">
                        @elseif($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="text-gray-400">No Image</div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-lg mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm mb-3">{{ Str::limit($product->short_description, 50) }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-purple-600 font-bold text-xl">{{ number_format($product->price, 0) }}</span>
                            <button class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 transition">Add to Cart</button>
                        </div>
                    </div>
                </div>
                
             @empty
                 <div class="col-span-4 text-center py-12">
                    <svg class="w-24 h-24 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p class="text-gray-500 text-lg mb-2">No products available at the moment</p>
                    <p class="text-gray-400 text-sm">Check back soon for new arrivals!</p>
                </div>
                @endforelse
            </div>
        </div> -->
   
<!-- Featured Products -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-12">
            <h2 class="text-3xl font-bold text-gray-800">Featured Products</h2>
            <a href="#" class="text-purple-600 font-semibold hover:text-purple-700">View All →</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Static Product 1 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover-scale cursor-pointer">
                <div class="bg-gray-200 h-64 flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('storage/product_images/prada-fancy-sunglasses_1717267654.webp') }}" alt="Classic Glasses" class="w-full h-full object-cover">
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-2">Classic Glasses</h3>
                    <p class="text-gray-600 text-sm mb-3">Timeless style for everyday wear</p>
                    <div class="flex items-center justify-between">
                        <span class="text-purple-600 font-bold text-xl">৳120</span>
                        <button class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 transition">Add to Cart</button>
                    </div>
                </div>
            </div>

            <!-- Static Product 2 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover-scale cursor-pointer">
                <div class="bg-gray-200 h-64 flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('storage/product_images/n-one-catseye_1724834843.webp') }}" alt="Modern Sunglasses" class="w-full h-full object-cover">
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-2">Modern Sunglasses</h3>
                    <p class="text-gray-600 text-sm mb-3">Stylish protection from the sun</p>
                    <div class="flex items-center justify-between">
                        <span class="text-purple-600 font-bold text-xl">৳150</span>
                        <button class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 transition">Add to Cart</button>
                    </div>
                </div>
            </div>

            <!-- Static Product 3 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover-scale cursor-pointer">
                <div class="bg-gray-200 h-64 flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('storage/product_images/fendi-premium-oversized_1724494759.webp') }}" alt="Blue Light Glasses" class="w-full h-full object-cover">
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-2">Blue Light Glasses</h3>
                    <p class="text-gray-600 text-sm mb-3">Protect your eyes from screens</p>
                    <div class="flex items-center justify-between">
                        <span class="text-purple-600 font-bold text-xl">৳90</span>
                        <button class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 transition">Add to Cart</button>
                    </div>
                </div>
            </div>

            <!-- Static Product 4 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover-scale cursor-pointer">
                <div class="bg-gray-200 h-64 flex items-center justify-center overflow-hidden">
                    <img src="{{ asset('storage/product_images/dior-majesty_1724234557.webp') }}" alt="Kids Glasses" class="w-full h-full object-cover">
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-2">Kids Glasses</h3>
                    <p class="text-gray-600 text-sm mb-3">Fun and durable eyewear for children</p>
                    <div class="flex items-center justify-between">
                        <span class="text-purple-600 font-bold text-xl">৳60</span>
                        <button class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-purple-700 transition">Add to Cart</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
    <!-- Banner Section -->
    <section class="py-16 bg-gradient-to-br from-purple-300 to-purple-500">
        <div class="container mx-auto px-4 text-center text-white">
            <h2 class="text-4xl font-bold mb-4">Get 20% Off Your First Order</h2>
            <p class="text-xl mb-8">Sign up for our newsletter and receive exclusive deals</p>
            <div class="flex justify-center">
                <input type="email" placeholder="Enter your email" class="px-6 py-3 rounded-l-lg w-80 text-gray-800 focus:outline-none">
                <button class="bg-white text-purple-600 px-8 py-3 rounded-r-lg font-semibold hover:bg-gray-100 transition">Subscribe</button>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <!-- <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Quality Assured</h3>
                    <p class="text-gray-600">Premium materials & craftsmanship</p>
                </div>
                <div>
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Fast Delivery</h3>
                    <p class="text-gray-600">3-5 business days shipping</p>
                </div>
                <div>
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Easy Returns</h3>
                    <p class="text-gray-600">30-day return policy</p>
                </div>
                <div>
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Expert Support</h3>
                    <p class="text-gray-600">24/7 customer service</p>
                </div>
            </div>
        </div>
    </section> -->


@endsection

