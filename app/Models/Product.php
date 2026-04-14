<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            return asset('images/no-image.png');
        }

        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        $path = ltrim($this->image, '/');
        if (Str::startsWith($path, 'storage/')) {
            return asset($path);
        }
        $publicStorageFile = public_path('storage/' . $path);
        if (is_file($publicStorageFile)) {
            return asset('storage/' . $path);
        }

        // Fallback for environments where /public/storage symlink isn't available.
        return route('media.public', ['path' => $path]);
    }
}