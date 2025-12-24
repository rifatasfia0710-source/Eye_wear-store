<?php

namespace App\Http\Controllers\Admin;

use Log;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $query = Product::with(['primaryImage']);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%');
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by stock status
        if ($request->has('stock_status')) {
            if ($request->stock_status == 'in_stock') {
                $query->where('stock_quantity', '>', 0);
            } elseif ($request->stock_status == 'out_of_stock') {
                $query->where('stock_quantity', '=', 0);
            } elseif ($request->stock_status == 'low_stock') {
                $query->where('stock_quantity', '>', 0)
                      ->where('stock_quantity', '<=', 10);
            }
        }

        // Filter by featured
        if ($request->has('featured') && $request->featured != '') {
            $query->where('featured', $request->featured);
        }

        $products = $query->latest()->paginate(15);
        $categories = Category::where('status', 'active')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::where('status', 'active')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:products,slug',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'frame_type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'required|string|unique:products,sku',
            'stock_quantity' => 'required|integer|min:0',
            'featured' => 'nullable|boolean',
            'status' => 'required|in:active,inactive,out_of_stock',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'images' => 'nullable|array', // Changed to nullable
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'primary_image' => 'nullable|integer'
        ]);

        DB::beginTransaction();

        try {
            // Generate slug from name
            $validated['slug'] = Str::slug($validated['name']);
            
            // Create product
            $product = Product::create([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'category_id' => $validated['category_id'],
                'description' => $validated['description'] ?? null,
                'short_description' => $validated['short_description'] ?? null,
                'frame_type' => $validated['frame_type'],
                'price' => $validated['price'],
                'discount_price' => $validated['discount_price'] ?? null,
                'sku' => $validated['sku'],
                'stock_quantity' => $validated['stock_quantity'],
                'featured' => $request->has('featured') ? 1 : 0,
                'status' => $validated['status'],
                'meta_title' => $validated['meta_title'] ?? null,
                'meta_description' => $validated['meta_description'] ?? null,
            ]);

            // Handle image uploads
            if ($request->hasFile('images')) {
                $primaryIndex = $request->input('primary_image', 0);
                
                foreach ($request->file('images') as $index => $image) {
                    $imagePath = $image->store('products', 'public');
                    
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $imagePath,
                        'is_primary' => ($index == $primaryIndex),
                        'sort_order' => $index
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product creation error: ' . $e->getMessage());
            
            return back()->withInput()
                ->withErrors(['error' => 'Error creating product: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load(['images']);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('status', 'active')->get();
        $product->load('images');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:products,slug,' . $product->id,
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'frame_type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'stock_quantity' => 'required|integer|min:0',
            'featured' => 'nullable|boolean',
            'status' => 'required|in:active,inactive,out_of_stock',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'primary_image' => 'nullable|integer'
        ]);

        DB::beginTransaction();

        try {
            // Generate slug if not provided
            if (empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['name']);
            }

            // Update product
            $product->update([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'category_id' => $validated['category_id'],
                'description' => $validated['description'] ?? null,
                'short_description' => $validated['short_description'] ?? null,
                'frame_type' => $validated['frame_type'],
                'price' => $validated['price'],
                'discount_price' => $validated['discount_price'] ?? null,
                'sku' => $validated['sku'],
                'stock_quantity' => $validated['stock_quantity'],
                'featured' => $request->has('featured') ? 1 : 0,
                'status' => $validated['status'],
                'meta_title' => $validated['meta_title'] ?? null,
                'meta_description' => $validated['meta_description'] ?? null,
            ]);

            // Handle new image uploads
            if ($request->hasFile('images')) {
                $primaryIndex = $request->input('primary_image', 0);
                $currentImagesCount = $product->images()->count();
                
                foreach ($request->file('images') as $index => $image) {
                    $imagePath = $image->store('products', 'public');
                    
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $imagePath,
                        'is_primary' => ($index == $primaryIndex && $currentImagesCount == 0),
                        'sort_order' => $currentImagesCount + $index
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product update error: ' . $e->getMessage());
            
            return back()->withInput()
                ->withErrors(['error' => 'Error updating product: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        DB::beginTransaction();

        try {
            // Delete all product images
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }

            $product->delete();

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error deleting product: ' . $e->getMessage());
        }
    }

    /**
     * Delete a specific product image.
     */
    public function deleteImage(Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id) {
            return back()->with('error', 'Image does not belong to this product.');
        }

        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }

    /**
     * Toggle product status.
     */
    public function toggleStatus(Product $product)
    {
        $product->status = $product->status === 'active' ? 'inactive' : 'active';
        $product->save();

        return back()->with('success', 'Product status updated successfully.');
    }

    /**
     * Bulk delete products.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id'
        ]);

        DB::beginTransaction();

        try {
            $products = Product::whereIn('id', $request->ids)->get();

            foreach ($products as $product) {
                foreach ($product->images as $image) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
                $product->delete();
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Selected products deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error deleting products: ' . $e->getMessage());
        }
    }
}