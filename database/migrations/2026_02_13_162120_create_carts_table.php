<?php

// database/migrations/xxxx_xx_xx_create_carts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            // Eyewear specific fields (optional)
            $table->string('lens_type')->nullable();       // e.g. single vision, bifocal
            $table->string('frame_color')->nullable();     // e.g. black, gold
            $table->decimal('sph_left', 5, 2)->nullable(); // prescription
            $table->decimal('sph_right', 5, 2)->nullable();
            $table->timestamps();

            // Prevent duplicate product per user (same product = just update qty)
            $table->unique(['user_id', 'product_id', 'lens_type', 'frame_color']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};