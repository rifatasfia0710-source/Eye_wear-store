<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productreview extends Model
{
    protected $fillable = ['product_id', 'user_id', 'rating', 'comment'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Helper: star HTML
    public function getStarsAttribute(): string
    {
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            $stars .= $i <= $this->rating ? '★' : '☆';
        }
        return $stars;
    }
}
