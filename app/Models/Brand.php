<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class Brand extends Model
// {
//     protected $fillable = ['name', 'slug'];
    
    
//     public function activeProducts()
//     {
//         return $this->hasMany(Product::class)->where('is_active', true);
//     }
//     public function products()
// {
//      return $this->hasMany(Product::class, 'id');
// }

// }


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'website',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    // Relationships
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}