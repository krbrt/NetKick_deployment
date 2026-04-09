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
            // Adds the 'color' column after 'brand' (or 'category' if brand doesn't exist yet)
            if (!Schema::hasColumn('products', 'color')) {
                $table->string('color')->nullable()->after('category');
            }

            // Safety check: Adds 'brand' if it was missing from previous updates
            if (!Schema::hasColumn('products', 'brand')) {
                $table->string('brand')->nullable()->after('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['color', 'brand']);
        });
    }
};