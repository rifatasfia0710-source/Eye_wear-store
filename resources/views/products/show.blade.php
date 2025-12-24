@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-2 gap-8 mb-12">
        <!-- Product Images -->
        <div>
            <div class="mb-4">
                <img id="mainImage" src="{{ $product->images->first()?->image_path ?? '/images/placeholder.jpg' }}" 
                     alt="{{ $product->name }}"
                     class="w-full rounded-lg shadow-lg">
            </div>
            
            @if($product->images->count() > 1)
                <div class="grid grid-cols-4 gap-2">
                    @foreach($product->images as $image)
                        <img src="{{ $image->image_path }}" 
                             alt="{{ $product->name }}"
                             onclick="changeMainImage('{{ $image->image_path }}')"
                             class="w-full aspect-square object-cover rounded cursor-pointer hover:opacity-75 border-2 border-transparent hover:border-blue-500">
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Product Info -->
        <div>
            <nav class="text-sm text-gray-600 mb-4">
                <a href="{{ route('products.index') }}" class="hover:text-blue-600">Products</a>
                <span class="mx-2">/</span>
                <a href="{{ route('products.index', ['category' => $product->category_id]) }}" class="hover:text-blue-600">
                    {{ $product->category->name }}
                </a>
            </nav>

            <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
            <p class="text-lg text-gray-600 mb-4">{{ $product->brand->name }}</p>

            <div class="flex items-center gap-4 mb-6">
                @if($product->sale_price)
                    <span class="text-3xl font-bold text-red-600">${{ $product->sale_price }}</span>
                    <span class="text-xl text-gray-500 line-through">${{ $product->price }}</span>
                    <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-semibold">
                        {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF
                    </span>
                @else
                    <span class="text-3xl font-bold">${{ $product->price }}</span>
                @endif
            </div>

            <!-- Product Attributes -->
            <div class="border-t border-b py-4 mb-6 space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Frame Type:</span>
                    <span class="font-medium">{{ ucfirst(str_replace('-', ' ', $product->frame_type)) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Gender:</span>
                    <span class="font-medium">{{ ucfirst($product->gender) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Availability:</span>
                    <span class="font-medium {{ $product->stock_quantity > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                    </span>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <h3 class="font-semibold text-lg mb-2">Description</h3>
                <p class="text-gray-700">{{ $product->description }}</p>
            </div>

            <!-- Add to Cart -->
            @if($product->stock_quantity > 0)
                <button class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Add to Cart
                </button>
            @else
                <button class="w-full bg-gray-400 text-white py-3 rounded-lg font-semibold cursor-not-allowed" disabled>
                    Out of Stock
                </button>
            @endif
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6">Related Products</h2>
            <div class="grid grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                        <a href="{{ route('products.show', $related->slug) }}">
                            <img src="{{ $related->primaryImage?->image_path ?? '/images/placeholder.jpg' }}" 
                                 alt="{{ $related->name }}"
                                 class="w-full aspect-square object-cover rounded-t-lg">
                            <div class="p-4">
                                <h3 class="font-semibold mb-1">{{ $related->name }}</h3>
                                <p class="text-sm text-gray-600 mb-2">{{ $related->brand->name }}</p>
                                <span class="text-lg font-bold">${{ $related->effective_price }}</span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script>
function changeMainImage(src) {
    document.getElementById('mainImage').src = src;
}
</script>
@endsection