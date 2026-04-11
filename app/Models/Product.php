<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'type',
        'category',
        'color',
        'gender',
        'price',
        'quantity',
        'sizes',
        'image',
        'quality',
        'is_on_sale',
        'original_price',
        'discount_percentage',
        'sale_ends_at',
    ];

    protected $casts = [
        'is_on_sale'          => 'boolean',
        'price'               => 'decimal:2',
        'original_price'      => 'decimal:2',
        'discount_percentage' => 'integer',
        'sale_ends_at'        => 'datetime',
    ];

    public function isSaleActive(): bool
    {
        if (!$this->is_on_sale) return false;
        if (!$this->sale_ends_at) return true;
        return $this->sale_ends_at->isFuture();
    }
}