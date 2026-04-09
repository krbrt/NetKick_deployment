<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'first_name')) {
                $table->string('first_name');
            }
            if (!Schema::hasColumn('orders', 'last_name')) {
                $table->string('last_name');
            }
            if (!Schema::hasColumn('orders', 'phone')) {
                $table->string('phone');
            }
            if (!Schema::hasColumn('orders', 'address')) {
                $table->text('address');
            }
            if (!Schema::hasColumn('orders', 'subtotal')) {
                $table->decimal('subtotal', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('orders', 'discount_amount')) {
                $table->decimal('discount_amount', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('orders', 'voucher_code')) {
                $table->string('voucher_code')->nullable();
            }
            if (!Schema::hasColumn('orders', 'total_amount')) {
                $table->decimal('total_amount', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method')->default('cod');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'phone', 
                'address',
                'subtotal',
                'discount_amount',
                'voucher_code',
                'total_amount',
                'payment_method'
            ]);
        });
    }
};

