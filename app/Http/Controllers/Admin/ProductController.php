<?php

namespace App\Http\Controllers\Admin;

use Log;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
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
        $query = Product::with(['brand', 'category', 'images' => function ($q) {
            $q->where('sort_order', 0)->orWhereRaw('sort_order = (SELECT MIN(sort_order) FROM product_images pi2 WHERE pi2.product_id = product_images.product_id)');
        }]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('sku', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('category'))     $query->where('category_id', $request->category);
        if ($request->filled('brand'))        $query->where('brand_id', $request->brand);
        if ($request->filled('status'))       $query->where('is_active', $request->status === 'active');
        if ($request->filled('featured'))     $query->where('is_featured', (bool) $request->featured);
        if ($request->filled('gender'))       $query->where('gender', $request->gender);
        if ($request->filled('frame_shape'))  $query->where('frame_shape', $request->frame_shape);

        if ($request->filled('stock_status')) {
            match ($request->stock_status) {
                'in_stock'     => $query->where('stock_quantity', '>', 0),
                'out_of_stock' => $query->where('stock_quantity', '<=', 0),
                'low_stock'    => $query->whereRaw('stock_quantity > 0 AND stock_quantity <= low_stock_threshold'),
                default        => null,
            };
        }

        $products   = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $brands     = Brand::where('is_active', true)->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $brands     = Brand::where('is_active', true)->orderBy('name')->get();

        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'                   => 'required|string|max:255',
            'slug'                   => 'nullable|string|unique:products,slug',
            'sku'                    => 'required|string|unique:products,sku',
            'category_id'            => 'required|exists:categories,id',
            'brand_id'               => 'required|exists:brands,id',
            'description'            => 'nullable|string',
            'short_description'      => 'nullable|string|max:500',
            'price'                  => 'required|numeric|min:0',
            'sale_price'             => 'nullable|numeric|min:0|lt:price',
            'cost_price'             => 'nullable|numeric|min:0',
            'stock_quantity'         => 'required|integer|min:0',
            'low_stock_threshold'    => 'nullable|integer|min:0',
            'weight'                 => 'nullable|numeric|min:0',
            'frame_shape'            => 'nullable|string|max:100',
            'frame_material'         => 'nullable|string|max:100',
            'frame_color'            => 'nullable|string|max:100',
            'rim_type'               => 'nullable|string|max:100',
            'lens_type'              => 'nullable|string|max:100',
            'lens_color'             => 'nullable|string|max:100',
            'lens_material'          => 'nullable|string|max:100',
            'temple_length'          => 'nullable|integer',
            'bridge_width'           => 'nullable|integer',
            'lens_width'             => 'nullable|integer',
            'lens_height'            => 'nullable|integer',
            'frame_width'            => 'nullable|integer',
            'gender'                 => 'nullable|in:Men,Women,Unisex,Kids',
            'age_group'              => 'nullable|string|max:50',
            'prescription_available' => 'nullable|boolean',
            'is_featured'            => 'nullable|boolean',
            'is_active'              => 'nullable|boolean',
            'is_new'                 => 'nullable|boolean',
            'is_bestseller'          => 'nullable|boolean',
            'published_at'           => 'nullable|date',
            'meta_title'             => 'nullable|string|max:255',
            'meta_description'       => 'nullable|string|max:500',
            'meta_keywords'          => 'nullable|string|max:500',
            'images'                 => 'nullable|array',
            'images.*'               => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'primary_image'          => 'nullable|integer',
        ]);

        DB::beginTransaction();

        try {
            $validated['slug'] = Str::slug($validated['name']);
            $originalSlug = $validated['slug'];
            $count = 1;
            while (Product::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $originalSlug . '-' . $count++;
            }

            $product = Product::create([
                'name'                   => $validated['name'],
                'slug'                   => $validated['slug'],
                'sku'                    => $validated['sku'],
                'category_id'            => $validated['category_id'],
                'brand_id'               => $validated['brand_id'],
                'description'            => $validated['description'] ?? null,
                'short_description'      => $validated['short_description'] ?? null,
                'price'                  => $validated['price'],
                'sale_price'             => $validated['sale_price'] ?? null,
                'cost_price'             => $validated['cost_price'] ?? null,
                'stock_quantity'         => $validated['stock_quantity'],
                'low_stock_threshold'    => $validated['low_stock_threshold'] ?? 5,
                'weight'                 => $validated['weight'] ?? null,
                'frame_shape'            => $validated['frame_shape'] ?? null,
                'frame_material'         => $validated['frame_material'] ?? null,
                'frame_color'            => $validated['frame_color'] ?? null,
                'rim_type'               => $validated['rim_type'] ?? null,
                'lens_type'              => $validated['lens_type'] ?? null,
                'lens_color'             => $validated['lens_color'] ?? null,
                'lens_material'          => $validated['lens_material'] ?? null,
                'temple_length'          => $validated['temple_length'] ?? null,
                'bridge_width'           => $validated['bridge_width'] ?? null,
                'lens_width'             => $validated['lens_width'] ?? null,
                'lens_height'            => $validated['lens_height'] ?? null,
                'frame_width'            => $validated['frame_width'] ?? null,
                'gender'                 => $validated['gender'] ?? 'Unisex',
                'age_group'              => $validated['age_group'] ?? null,
                'prescription_available' => $request->boolean('prescription_available', true),
                'is_featured'            => $request->boolean('is_featured'),
                'is_active'              => $request->boolean('is_active', true),
                'is_new'                 => $request->boolean('is_new'),
                'is_bestseller'          => $request->boolean('is_bestseller'),
                'published_at'           => $validated['published_at'] ?? now(),
                'meta_title'             => $validated['meta_title'] ?? null,
                'meta_description'       => $validated['meta_description'] ?? null,
                'meta_keywords'          => $validated['meta_keywords'] ?? null,
            ]);

            if ($request->hasFile('images')) {
                $primaryIndex = $request->input('primary_image', 0);
                foreach ($request->file('images') as $index => $image) {
                    $imagePath = $image->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $imagePath,
                        'is_primary' => ($index == $primaryIndex),
                        'sort_order' => $index,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product "' . $product->name . '" created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product creation error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->withInput()->withErrors(['error' => 'Error creating product: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'brand', 'images']);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $product->load('images');
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $brands     = Brand::where('is_active', true)->orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'                   => 'required|string|max:255',
            'slug'                   => 'nullable|string|unique:products,slug,' . $product->id,
            'sku'                    => 'required|string|unique:products,sku,' . $product->id,
            'category_id'            => 'required|exists:categories,id',
            'brand_id'               => 'nullable|exists:brands,id',
            'description'            => 'nullable|string',
            'short_description'      => 'nullable|string|max:500',
            'price'                  => 'required|numeric|min:0',
            'sale_price'             => 'nullable|numeric|min:0|lt:price',
            'cost_price'             => 'nullable|numeric|min:0',
            'stock_quantity'         => 'required|integer|min:0',
            'low_stock_threshold'    => 'nullable|integer|min:0',
            'weight'                 => 'nullable|numeric|min:0',
            'frame_shape'            => 'nullable|string|max:100',
            'frame_material'         => 'nullable|string|max:100',
            'frame_color'            => 'nullable|string|max:100',
            'rim_type'               => 'nullable|string|max:100',
            'lens_type'              => 'nullable|string|max:100',
            'lens_color'             => 'nullable|string|max:100',
            'lens_material'          => 'nullable|string|max:100',
            'temple_length'          => 'nullable|integer',
            'bridge_width'           => 'nullable|integer',
            'lens_width'             => 'nullable|integer',
            'lens_height'            => 'nullable|integer',
            'frame_width'            => 'nullable|integer',
            'gender'                 => 'nullable|in:Men,Women,Unisex,Kids',
            'age_group'              => 'nullable|string|max:50',
            'prescription_available' => 'nullable|boolean',
            'is_featured'            => 'nullable|boolean',
            'is_active'              => 'nullable|boolean',
            'is_new'                 => 'nullable|boolean',
            'is_bestseller'          => 'nullable|boolean',
            'published_at'           => 'nullable|date',
            'meta_title'             => 'nullable|string|max:255',
            'meta_description'       => 'nullable|string|max:500',
            'meta_keywords'          => 'nullable|string|max:500',
            'images'                 => 'nullable|array',
            'images.*'               => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            // New: from modal UI
            'primary_image_id'       => 'nullable|integer|exists:product_images,id',
            'delete_images'          => 'nullable|array',
            'delete_images.*'        => 'integer|exists:product_images,id',
        ]);

        DB::beginTransaction();

        try {
            // ── Slug ──
            if (empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['name']);
                $originalSlug = $validated['slug'];
                $count = 1;
                while (Product::where('slug', $validated['slug'])->where('id', '!=', $product->id)->exists()) {
                    $validated['slug'] = $originalSlug . '-' . $count++;
                }
            }

            $product->update([
                'name'                   => $validated['name'],
                'slug'                   => $validated['slug'],
                'sku'                    => $validated['sku'],
                'category_id'            => $validated['category_id'],
                'brand_id'               => $validated['brand_id'] ?? null,
                'description'            => $validated['description'] ?? null,
                'short_description'      => $validated['short_description'] ?? null,
                'price'                  => $validated['price'],
                'sale_price'             => $validated['sale_price'] ?? null,
                'cost_price'             => $validated['cost_price'] ?? null,
                'stock_quantity'         => $validated['stock_quantity'],
                'low_stock_threshold'    => $validated['low_stock_threshold'] ?? $product->low_stock_threshold ?? 5,
                'weight'                 => $validated['weight'] ?? null,
                'frame_shape'            => $validated['frame_shape'] ?? null,
                'frame_material'         => $validated['frame_material'] ?? null,
                'frame_color'            => $validated['frame_color'] ?? null,
                'rim_type'               => $validated['rim_type'] ?? null,
                'lens_type'              => $validated['lens_type'] ?? null,
                'lens_color'             => $validated['lens_color'] ?? null,
                'lens_material'          => $validated['lens_material'] ?? null,
                'temple_length'          => $validated['temple_length'] ?? null,
                'bridge_width'           => $validated['bridge_width'] ?? null,
                'lens_width'             => $validated['lens_width'] ?? null,
                'lens_height'            => $validated['lens_height'] ?? null,
                'frame_width'            => $validated['frame_width'] ?? null,
                'gender'                 => $validated['gender'] ?? $product->gender,
                'age_group'              => $validated['age_group'] ?? null,
                'prescription_available' => $request->boolean('prescription_available', true),
                'is_featured'            => $request->boolean('is_featured'),
                'is_active'              => $request->boolean('is_active', true),
                'is_new'                 => $request->boolean('is_new'),
                'is_bestseller'          => $request->boolean('is_bestseller'),
                'published_at'           => $validated['published_at'] ?? $product->published_at,
                'meta_title'             => $validated['meta_title'] ?? null,
                'meta_description'       => $validated['meta_description'] ?? null,
                'meta_keywords'          => $validated['meta_keywords'] ?? null,
            ]);

            // ── 1. Delete marked images ──
            if (!empty($validated['delete_images'])) {
                $imagesToDelete = ProductImage::whereIn('id', $validated['delete_images'])
                    ->where('product_id', $product->id)  // security: only this product's images
                    ->get();

                foreach ($imagesToDelete as $img) {
                    Storage::disk('public')->delete($img->image_path);
                    $img->delete();
                }
            }

            // ── 2. Set primary image ──
            if (!empty($validated['primary_image_id'])) {
                // Verify the image belongs to this product
                $primaryImg = ProductImage::where('id', $validated['primary_image_id'])
                    ->where('product_id', $product->id)
                    ->first();

                if ($primaryImg) {
                    // Remove primary from all, then set new one
                    $product->images()->update(['is_primary' => false]);
                    $primaryImg->update(['is_primary' => true]);
                }
            }

            // ── 3. If no primary exists after changes, auto-assign first remaining ──
            $hasPrimary = $product->images()->where('is_primary', true)->exists();
            if (!$hasPrimary) {
                $firstImage = $product->images()->orderBy('sort_order')->first();
                if ($firstImage) {
                    $firstImage->update(['is_primary' => true]);
                }
            }

            // ── 4. Upload new images ──
            if ($request->hasFile('images')) {
                $currentImagesCount = $product->images()->count();

                foreach ($request->file('images') as $index => $image) {
                    $imagePath = $image->store('products', 'public');

                    // If no images exist yet, first upload becomes primary
                    $isPrimary = ($currentImagesCount === 0 && $index === 0);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $imagePath,
                        'is_primary' => $isPrimary,
                        'sort_order' => $currentImagesCount + $index,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product "' . $product->name . '" updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product update error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->withInput()->withErrors(['error' => 'Error updating product: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified product from storage (soft delete).
     */
    public function destroy(Product $product)
    {
        DB::beginTransaction();

        try {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }

            $product->delete();

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product "' . $product->name . '" deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product delete error: ' . $e->getMessage());
            return back()->with('error', 'Error deleting product: ' . $e->getMessage());
        }
    }

    /**
     * Delete a specific product image (standalone route).
     */
    public function deleteImage(Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id) {
            return back()->with('error', 'Image does not belong to this product.');
        }

        Storage::disk('public')->delete($image->image_path);

        $wasPrimary = $image->is_primary;
        $image->delete();

        if ($wasPrimary) {
            $nextImage = $product->images()->orderBy('sort_order')->first();
            if ($nextImage) {
                $nextImage->update(['is_primary' => true]);
            }
        }

        return back()->with('success', 'Image deleted successfully.');
    }

    /**
     * Set a specific image as the primary image (standalone route).
     */
    public function setPrimaryImage(Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id) {
            return back()->with('error', 'Image does not belong to this product.');
        }

        $product->images()->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);

        return back()->with('success', 'Primary image updated successfully.');
    }

    /**
     * Toggle product active status.
     */
    public function toggleStatus(Product $product)
    {
        $product->is_active = !$product->is_active;
        $product->save();

        $status = $product->is_active ? 'activated' : 'deactivated';
        return back()->with('success', 'Product "' . $product->name . '" ' . $status . ' successfully.');
    }

    /**
     * Toggle product featured status.
     */
    public function toggleFeatured(Product $product)
    {
        $product->is_featured = !$product->is_featured;
        $product->save();

        $status = $product->is_featured ? 'marked as featured' : 'removed from featured';
        return back()->with('success', 'Product "' . $product->name . '" ' . $status . '.');
    }

    /**
     * Bulk actions on multiple products.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate,feature,unfeature',
            'ids'    => 'required|array|min:1',
            'ids.*'  => 'exists:products,id',
        ]);

        $products = Product::whereIn('id', $request->ids)->get();
        $count    = $products->count();

        DB::beginTransaction();

        try {
            match ($request->action) {
                'delete'     => $this->bulkDelete($products),
                'activate'   => $products->each(fn($p) => $p->update(['is_active' => true])),
                'deactivate' => $products->each(fn($p) => $p->update(['is_active' => false])),
                'feature'    => $products->each(fn($p) => $p->update(['is_featured' => true])),
                'unfeature'  => $products->each(fn($p) => $p->update(['is_featured' => false])),
            };

            DB::commit();

            $actionLabel = str_replace(['_'], [' '], $request->action) . 'd';
            return redirect()->route('admin.products.index')
                ->with('success', $count . ' product(s) ' . $actionLabel . ' successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk action error: ' . $e->getMessage());
            return back()->with('error', 'Error performing bulk action: ' . $e->getMessage());
        }
    }

    /**
     * Helper: Bulk delete products and their images.
     */
    private function bulkDelete($products): void
    {
        foreach ($products as $product) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
            $product->delete();
        }
    }

    /**
     * Update stock status for all products (utility/maintenance route).
     */
    public function syncStockStatus()
    {
        $products = Product::all();
        $updated  = 0;

        foreach ($products as $product) {
            $stockStatus = $this->resolveStockStatus($product->stock_quantity, $product->low_stock_threshold);
            if ($product->stock_status !== $stockStatus) {
                $product->update(['stock_status' => $stockStatus]);
                $updated++;
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', "Stock status synced. {$updated} product(s) updated.");
    }

    /**
     * Resolve stock status label based on quantity and threshold.
     */
    private function resolveStockStatus(int $quantity, int $threshold = 5): string
    {
        if ($quantity <= 0)         return 'out_of_stock';
        if ($quantity <= $threshold) return 'low_stock';
        return 'in_stock';
    }
}