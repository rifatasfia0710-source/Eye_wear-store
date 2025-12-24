<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['brand', 'primaryImage'])
            ->active()
            ->inStock();

        // Apply filters
        // if ($request->filled('category')) {
        //     $query->byCategory($request->category);
        // }

        if ($request->filled('brand')) {
            $query->byBrand($request->brand);
        }

        if ($request->filled('frame_type')) {
            $query->byFrameType($request->frame_type);
        }

        if ($request->filled('gender')) {
            $query->byGender($request->gender);
        }

        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->priceRange($request->min_price, $request->max_price);
        }

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Sorting
        $sortBy = $request->get('sort', 'newest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popularity':
                $query->orderBy('popularity_score', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Pagination
        $perPage = $request->get('per_page', 12);
        $products = $query->paginate($perPage)->withQueryString();

        // Get filter options
        $categories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();

        return view('products.index', compact('products',  'brands'));
    }

    public function show($slug)
    {
        $product = Product::with([ 'brand', 'images'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        // Increment view count
        $product->increment('views');

        // Get related products
        $relatedProducts = Product::with(['primaryImage'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->inStock()
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}