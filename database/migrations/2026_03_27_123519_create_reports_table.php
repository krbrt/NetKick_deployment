<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('report_number')->unique(); // E.g., RP-2026-001
            $table->string('type'); // 'sales', 'inventory', 'vouchers'
            $table->json('data'); // Stores the actual stats (total earned, items sold, etc.)
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->foreignId('generated_by')->constrained('users'); // Tracks which admin made it
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
