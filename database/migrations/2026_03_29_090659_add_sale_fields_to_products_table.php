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
            // Placing these after existing columns for a cleaner DB structure
            $table->boolean('is_on_sale')->default(false)->after('image');
            $table->decimal('original_price', 10, 2)->nullable()->after('price'); 
            $table->integer('discount_percentage')->nullable()->after('original_price');
            $table->timestamp('sale_ends_at')->nullable()->after('discount_percentage');
        });
    }

    /**
     * Reverse the migrations (Rollback logic).
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'is_on_sale', 
                'original_price', 
                'discount_percentage', 
                'sale_ends_at'
            ]);
        });
    }
};