<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            // $table->id();
            // $table->foreignId('category_id')->constrained()->onDelete('cascade');
            // $table->string('name');
            // $table->string('slug')->unique();
            // $table->string('frame_type');
            // $table->text('description')->nullable();
            // $table->text('short_description')->nullable();
            // $table->decimal('price', 10, 2);
            // $table->decimal('discount_price', 10, 2)->nullable();
            // $table->string('sku')->unique();
            // $table->integer('stock_quantity')->default(0);
            //  $table->integer('sales_count')->default(0);
            // $table->boolean('featured')->default(false);
            // $table->enum('status', ['active', 'inactive', 'out_of_stock'])->default('active');
            //  $table->string('meta_title')->nullable();
            //  $table->text('meta_description')->nullable();
            //  $table->timestamps();
            //  $table->softDeletes();
            
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            
            // Pricing
            $table->decimal('price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->decimal('cost_price', 10, 2)->nullable();
            
            // Relationships
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->constrained()->onDelete('cascade');
            
            // Inventory
            $table->integer('stock_quantity')->default(0);
            $table->integer('low_stock_threshold')->default(5);
            $table->decimal('weight', 8, 2)->nullable(); // in grams
            
            // Eyewear Specific Fields - Frame
            $table->string('frame_shape')->nullable(); // Round, Square, Rectangle, Cat-Eye, Aviator, Wayfarer, Oval, etc.
            $table->string('frame_material')->nullable(); // Acetate, Metal, Plastic, Titanium, Wood, etc.
            $table->string('frame_color')->nullable();
            $table->string('rim_type')->nullable(); // Full-rim, Semi-rimless, Rimless
            
            // Eyewear Specific Fields - Lens
            $table->string('lens_type')->nullable(); // Single Vision, Bifocal, Progressive, Reading, Sunglasses, Blue Light
            $table->string('lens_color')->nullable();
            $table->string('lens_material')->nullable(); // Plastic, Polycarbonate, High-index, Glass
            
            // Measurements (in mm)
            $table->integer('temple_length')->nullable(); // Arm length
            $table->integer('bridge_width')->nullable(); // Bridge width
            $table->integer('lens_width')->nullable(); // Lens width
            $table->integer('lens_height')->nullable(); // Lens height
            $table->integer('frame_width')->nullable(); // Total frame width
            
            // Demographics
            $table->enum('gender', ['Men', 'Women', 'Unisex', 'Kids'])->default('Unisex');
            $table->string('age_group')->nullable(); // Adults, Kids, Teens
            
            // Features
            $table->boolean('prescription_available')->default(true);
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            
            // Status flags
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_bestseller')->default(false);
            
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('slug');
            $table->index('sku');
            $table->index('category_id');
            $table->index('brand_id');
            $table->index('is_active');
            $table->index('is_featured');
            $table->index('frame_shape');
            $table->index('gender');
            $table->index(['price', 'sale_price']);
        });
    }

    
 public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

