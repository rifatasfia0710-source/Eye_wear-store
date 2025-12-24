<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['name', 'slug'];
    
    
    public function activeProducts()
    {
        return $this->hasMany(Product::class)->where('is_active', true);
    }
    public function products()
{
     return $this->hasMany(Product::class, 'id');
}

}