<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Ray-Ban',
                'slug' => 'ray-ban',
                'description' => 'Iconic American-Italian brand',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Oakley',
                'slug' => 'oakley',
                'description' => 'Premium sports eyewear',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Gucci',
                'slug' => 'gucci',
                'description' => 'Luxury Italian fashion brand',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Prada',
                'slug' => 'prada',
                'description' => 'High-end Italian luxury brand',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Titan Eye+',
                'slug' => 'titan-eye-plus',
                'description' => 'Leading Indian eyewear brand',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Lenskart',
                'slug' => 'lenskart',
                'description' => 'Popular online eyewear retailer',
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}