<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    
public function index(Request $request)
{
    // Base query
    $query = Product::with(['brand', 'category','images', 'colors']);

/* -------------------------
           BRAND FILTER
        --------------------------*/
        if ($request->filled('brands')) {
            $query->whereIn('brand_id', $request->brands);
        }

        /* -------------------------
           CATEGORY FILTER
        --------------------------*/
        if ($request->filled('categories')) {
            $query->whereIn('category_id', $request->categories);
        }

    // Apply filters
    $this->applyFilters($query, $request);

    // Apply sorting
    $this->applySorting($query, $request);

    // Paginated products
    $products = $query->paginate(12)->withQueryString();

    // Sidebar filter data
    $brands = Brand::all();
    $categories = Category::all();
    $colors = Color::all();

    // Unique frame types from products
    $frameTypes = Product::select('frame_type')
        ->whereNotNull('frame_type')
        ->distinct()
        ->pluck('frame_type');

    // Return view with all variables
    return view('frontend.shop', compact(
        'products',
        'brands',
        'categories',
        'colors',
        'frameTypes'
    ));
    // 🔥 These will show ALL seeded brands & categories
        $brands = Brand::where('is_active', true)->orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
    {
    $products = Product::with('brand')->paginate(12);
    return view('frontend.shop', compact('products'));
    }
}

    /**
     * Apply filters to the query
     */
    private function applyFilters($query, Request $request)
    {
        // Brand filter
        if ($request->filled('brands')) {
            $query->whereIn('brand_id', $request->brands);
        }

        // Category filter
        if ($request->filled('categories')) {
            $query->whereIn('category_id', $request->categories);
        }

        // Frame type filter
        if ($request->filled('frame_types')) {
            $query->whereIn('frame_type', $request->frame_types);
        }

        // Color filter
        if ($request->filled('colors')) {
            $query->whereHas('colors', function ($q) use ($request) {
                $q->whereIn('colors.id', $request->colors);
            });
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Search query
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }
    }

    /**
     * Apply sorting to the query
     */
    private function applySorting($query, Request $request)
    {
        $sort = $request->get('sort', 'newest');

        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            
            case 'popular':
                $query->orderBy('views_count', 'desc');
                break;
            
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            
            default:
                $query->orderBy('created_at', 'desc');
        }
    }

    /**
     * Get all filter options
     */
    //

    /**
     * Show single product detail page
     */
    public function show($slug)
    {
        $product = Product::with(['brand', 'category', 'colors', 'images'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
            
        $product = Product::with(['images', 'reviews.user'])
                      ->where('slug', $slug)
                      ->firstOrFail();

    return view('frontend.shop-details', compact('product'));
        // Increment view count
        // $product->increment('views_count');

        // Get related products
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('frontend.shop-details', compact('product', 'relatedProducts'));
    }

    /**
     * Get quick view product data (AJAX)
     */
    public function quickView($id)
    {
        $product = Product::with(['brand', 'category', 'colors', 'images'])
            ->where('id', $id)
            ->where('is_active', true)
            ->firstOrFail();

        return response()->json([
            'success' => true,
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->price,
                'discount_price' => $product->discount_price,
                'image_url' => $product->image_url,
                'images' => $product->images,
                'description' => $product->description,
                'stock' => $product->stock,
                'brand' => $product->brand,
                'colors' => $product->colors,
                'frame_type' => $product->frame_type,
            ]
        ]);
    }
}