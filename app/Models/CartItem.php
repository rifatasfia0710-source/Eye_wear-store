<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'price',
        'prescription_data'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'prescription_data' => 'array'
    ];

    // Relationships
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Accessors
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->price;
    }

    public function getCurrentPriceAttribute()
    {
        return $this->product->final_price;
    }

    // Check if price has changed since added to cart
    public function getPriceChangedAttribute()
    {
        return $this->price != $this->product->final_price;
    }
}