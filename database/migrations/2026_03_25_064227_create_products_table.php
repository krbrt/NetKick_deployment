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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('category');
        $table->enum('gender', ['Men', 'Women', 'Unisex'])->default('Unisex');
        $table->decimal('price', 10, 2);
        $table->integer('quantity');
        $table->string('sizes'); // I-save natin ito bilang string (e.g., "7, 8, 9")
        $table->string('image'); // Dito isasave ang path ng file
        $table->timestamps();
    });

}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
