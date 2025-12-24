<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'city',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

// Check if user is admin
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Check if user is customer
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }
// public function orders()
//     {
//         return $this->hasMany(\App\Models\Order::class);
//     }
    
//     // Add appends for orders_count attribute
//     protected $appends = ['orders_count'];
    
//     public function getOrdersCountAttribute()
//     {
//         // Return 0 if Order model doesn't exist yet
//         if (!class_exists(\App\Models\Order::class)) {
//             return 0;
//         }
//         return $this->orders()->count();
//     }
}
