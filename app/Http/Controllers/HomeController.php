<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage
     */
    public function index()
    {
        // Featured products
        $featuredProducts = Product::with(['images'])
            ->active()
            ->featured()
            ->inStock()
            ->limit(8)
            ->get();

        // New arrivals
        $newArrivals = Product::with(['images'])
            ->active()
            ->where('is_new', true)
            ->inStock()
            ->latest()
            ->limit(8)
            ->get();

        // Bestsellers
        $bestsellers = Product::with(['images'])
            ->active()
            ->where('is_bestseller', true)
            ->inStock()
            ->limit(8)
            ->get();

        // On sale products
        $onSaleProducts = Product::with(['images'])
            ->active()
            ->onSale()
            ->inStock()
            ->limit(8)
            ->get();

        // Categories
        $categories = Category::active()
            ->parent()
            ->withCount('products')
            ->get();

        // Brands
        $brands = Brand::active()
            ->withCount('products')
            ->orderBy('sort_order')
            ->get();

        return view('home', compact(
            'featuredProducts',
            'newArrivals',
            'bestsellers',
            'onSaleProducts',
            'categories',
            'brands'
        ));
    }
}