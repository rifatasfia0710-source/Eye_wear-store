<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
   protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'slug',
        'frame_type',
        'sales_count',
        'sku',
        'stock_quantity',
        'featured',
        'short_description',
        'discount_price',
        'status',
        // ... other fields
    ];
    public function primaryImage()
{
    return $this->hasOne(ProductImage::class)->where('is_primary', 1);
}
public function images()
{
    return $this->hasMany(ProductImage::class);
}
public function isInStock()
{
    return $this->stock_quantity > 0;
}

public function productImages()
{
    return $this->hasMany(ProductImage::class);
}

// protected static function booted()
// {
//     static::addGlobalScope('active', function ($query) {
//         // do nothing because is_active doesn't exist
//     });
// }
public function brand()
{
    return $this->belongsTo(Brand::class, 'brand_id');
}
public function category()
{
    return $this->belongsTo(Category::class, 'category_id');
}

public function colors()
{
    return $this->belongsToMany(Color::class, 'color_product', 'product_id', 'color_id');
}
 }


