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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // Foreign Key sa main Orders table
            $table->foreignId('order_id')->constrained()->onDelete('cascade');

            // Product link - ginamitan ng nullOnDelete para hindi mabura ang order item
            // record kahit mabura ang mismong product sa inventory.
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();

            // Snapshot fields (Para sa history records)
            $table->string('product_name');
            $table->string('product_image')->nullable();
            $table->string('size');
            $table->integer('quantity');

            // 12, 2 is safer para sa malalaking transaction total
            $table->decimal('price', 12, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
