<?php

// app/Models/Cart.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'lens_type',
        'frame_color',
        'sph_left',
        'sph_right',
    ];

    // Relationship: Cart item belongs to a User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: Cart item belongs to a Product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Helper: get subtotal for this cart item
    public function getSubtotalAttribute(): float
    {
        return $this->quantity * $this->product->price;
    }
}