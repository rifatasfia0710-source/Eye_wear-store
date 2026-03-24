<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products with filters
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'images'])
            ->active()
            ->inStock();

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Category filter
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Brand filter
        if ($request->filled('brand')) {
            $query->byBrand($request->brand);
        }

        // Gender filter
        if ($request->filled('gender')) {
            $query->byGender($request->gender);
        }

        // Frame shape filter
        if ($request->filled('frame_shape')) {
            $query->byFrameShape($request->frame_shape);
        }

        // Frame material filter
        if ($request->filled('frame_material')) {
            $query->where('frame_material', $request->frame_material);
        }

        // Frame color filter
        if ($request->filled('frame_color')) {
            $query->where('frame_color', $request->frame_color);
        }

        // Lens type filter
        if ($request->filled('lens_type')) {
            $query->where('lens_type', $request->lens_type);
        }

        // Price range filter
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->priceRange($request->min_price, $request->max_price);
        }

        // On sale filter
        if ($request->filled('on_sale') && $request->on_sale == 1) {
            $query->onSale();
        }

        // Featured filter
        if ($request->filled('featured') && $request->featured == 1) {
            $query->featured();
        }

        // New arrivals filter
        if ($request->filled('new') && $request->new == 1) {
            $query->where('is_new', true);
        }

        // Bestsellers filter
        if ($request->filled('bestseller') && $request->bestseller == 1) {
            $query->where('is_bestseller', true);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'popularity':
                // You can add a views or sales count column
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy($sortBy, $sortOrder);
        }

        $products = $query->paginate($request->get('per_page', 12));

        // Get filter options
        $categories = Category::active()->get();
        $brands = Brand::active()->get();
        
        // Get unique values for filters
        $frameShapes = Product::active()->distinct()->pluck('frame_shape')->filter();
        $frameMaterials = Product::active()->distinct()->pluck('frame_material')->filter();
        $frameColors = Product::active()->distinct()->pluck('frame_color')->filter();
        $lensTypes = Product::active()->distinct()->pluck('lens_type')->filter();
        $genders = Product::active()->distinct()->pluck('gender')->filter();

        // Get price range
        $priceRange = [
            'min' => Product::active()->min('price') ?? 0,
            'max' => Product::active()->max('price') ?? 1000
        ];

        return view('products.index', compact(
            'products',
            'categories',
            'brands',
            'frameShapes',
            'frameMaterials',
            'frameColors',
            'lensTypes',
            'genders',
            'priceRange'
        ));
    }

    /**
     * Display the specified product
     */
    public function show($slug)
    {
        $product = Product::with(['category', 'brand', 'images'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        // Get related products (same category, different product)
        $relatedProducts = Product::with(['images'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->active()
            ->inStock()
            ->limit(4)
            ->get();

        // Get similar products (same brand or frame shape)
        $similarProducts = Product::with(['images'])
            ->where(function($query) use ($product) {
                $query->where('brand_id', $product->brand_id)
                      ->orWhere('frame_shape', $product->frame_shape);
            })
            ->where('id', '!=', $product->id)
            ->active()
            ->inStock()
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts', 'similarProducts'));
    }

    /**
     * Search products (AJAX)
     */
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2'
        ]);

        $products = Product::with(['images'])
            ->active()
            ->search($request->query)
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'products' => $products->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->final_price,
                    'image' => $product->primary_image,
                    'url' => route('products.show', $product->slug)
                ];
            })
        ]);
    }

    /**
     * Get products by category
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->active()->firstOrFail();
        
        $products = Product::with(['brand', 'images'])
            ->byCategory($category->id)
            ->active()
            ->inStock()
            ->paginate(12);

        $categories = Category::active()->get();
        $brands = Brand::active()->get();

        return view('products.category', compact('category', 'products', 'categories', 'brands'));
    }

    /**
     * Get products by brand
     */
    public function brand($slug)
    {
        $brand = Brand::where('slug', $slug)->active()->firstOrFail();
        
        $products = Product::with(['category', 'images'])
            ->byBrand($brand->id)
            ->active()
            ->inStock()
            ->paginate(12);

        $categories = Category::active()->get();
        $brands = Brand::active()->get();

        return view('products.brand', compact('brand', 'products', 'categories', 'brands'));
    }
}