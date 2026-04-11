<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
    'name', 'brand', 'type', 'category', 'color',
    'gender', 'price', 'quantity', 'sizes', 'image',
    'quality', 'is_on_sale',
        // --- SALE VAULT ATTRIBUTES ---
        'is_on_sale',
        'original_price',
        'discount_percentage',
'sale_ends_at',
        'quality' => 'string',
    ];

    /**
     * Casting ensures data types are consistent.
     * 'sale_ends_at' as 'datetime' allows you to use Carbon methods
     * like ->diffForHumans() in your Blade files.
     */
    protected $casts = [
        'is_on_sale' => 'boolean',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'discount_percentage' => 'integer',
        'sale_ends_at' => 'datetime',
    ];

    /**
     * HELPER: Check if the sale is still active based on the date.
     */
    public function isSaleActive(): bool
    {
        if (!$this->is_on_sale) return false;

        // If no end date is set, assume it's an indefinite sale
        if (!$this->sale_ends_at) return true;

        return $this->sale_ends_at->isFuture();
    }
}
