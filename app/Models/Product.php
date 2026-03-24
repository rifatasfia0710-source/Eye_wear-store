<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'description',
        'short_description',
        'price',
        'sale_price',
        'cost_price',
        'category_id',
        'brand_id',
        'stock_status',
        'stock_quantity',
        'low_stock_threshold',

        // Eyewear fields
        'frame_shape',
        'frame_material',
        'frame_color',
        'lens_type',
        'lens_color',
        'lens_material',
        'gender',
        'rim_type',

        // Status
        'is_featured',
        'is_active',
        'is_new',
        'published_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'low_stock_threshold' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'is_new' => 'boolean',
        'published_at' => 'datetime',
    ];

    /* =====================
       RELATIONSHIPS
    ====================== */

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'color_product');
    }

    /* =====================
       ACCESSORS
    ====================== */

    public function getFinalPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    public function getIsInStockAttribute()
    {
        return $this->stock_quantity > 0;
    }

    public function getPrimaryImageAttribute()
    {
        return $this->images()->first()?->image_path;
             return $path ? 'storage/' . $path : 'images/placeholder.jpg';
    }

    /* =====================
       SCOPES
    ====================== */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByBrand($query, $brandIds)
    {
        return $query->whereIn('brand_id', (array) $brandIds);
    }

    public function scopeByCategory($query, $categoryIds)
    {
        return $query->whereIn('category_id', (array) $categoryIds);
    }

    public function scopePriceRange($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }
    public function reviews(): HasMany
{
    return $this->hasMany(Review::class)->where('is_approved', true)->latest();
}

public function averageRating()
{
    return $this->reviews()->avg('rating') ?? 0;
}

public function reviewCount()
{
    return $this->reviews()->count();
}
}