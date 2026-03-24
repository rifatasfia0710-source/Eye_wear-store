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
        Schema::table('orders', function (Blueprint $table) {

        if (!Schema::hasColumn('orders', 'transaction_id')) {
            $table->string('transaction_id')->unique()->nullable();
        }

        if (!Schema::hasColumn('orders', 'currency')) {
            $table->string('currency')->default('BDT');
        }

        if (!Schema::hasColumn('orders', 'amount')) {
            $table->decimal('amount', 10, 2)->nullable();
        }

    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
