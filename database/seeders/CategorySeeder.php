<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Eyeglasses',
                'slug' => 'eyeglasses',
                'description' => 'Prescription eyeglasses for clear vision',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Sunglasses',
                'slug' => 'sunglasses',
                'description' => 'Stylish sunglasses for UV protection',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Contact Lenses',
                'slug' => 'contact-lenses',
                'description' => 'Comfortable contact lenses',
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Reading Glasses',
                'slug' => 'reading-glasses',
                'description' => 'Reading glasses for close-up work',
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Blue Light Glasses',
                'slug' => 'blue-light-glasses',
                'description' => 'Protect your eyes from digital screens',
                'is_active' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}