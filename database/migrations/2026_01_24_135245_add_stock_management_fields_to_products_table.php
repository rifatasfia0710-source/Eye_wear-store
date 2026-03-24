<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('low_stock_alert')->default(5)->after('stock_quantity');
            $table->enum('stock_status', ['in_stock', 'low_stock', 'out_of_stock'])
                  ->default('in_stock')
                  ->after('low_stock_alert');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['low_stock_alert', 'stock_status']);
        });
    }
};