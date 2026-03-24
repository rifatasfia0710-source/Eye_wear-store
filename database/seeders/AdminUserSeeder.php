<?php

namespace Database\Seeders;
use App\Models\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         User::create([
            'name' => 'Admin',
            'email' => 'admin@eyewear.com',
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Test Customer',
            'email' => 'customer@eyewear.com',
            'password' => Hash::make('12345678'),
            'role' => 'customer',
            'email_verified_at' => now(),
             'remember_token' => Str::random(10),
        ]);
    }
}
