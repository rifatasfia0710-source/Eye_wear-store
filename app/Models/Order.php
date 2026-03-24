<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 
        'total_amount', 
        'payment_method', 
        'payment_status',  // unpaid, paid
        'status',          // pending, confirmed, processing, shipped, delivered, cancelled
        'address',
        'cancel_reason',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Status badge color helper
    public function statusBadgeClass(): string
    {
        return match($this->status) {
            'pending'   => 'badge-pending',
            'confirmed' => 'badge-confirmed',
            'processing'=> 'badge-processing',
            'shipped'   => 'badge-shipped',
            'delivered' => 'badge-delivered',
            'cancelled' => 'badge-cancelled',
            default     => 'badge-pending',
        };
    }
    public function paymentBadgeClass(): string
    {
        return $this->payment_status === 'paid' ? 'badge-paid' : 'badge-unpaid';
    }
}
