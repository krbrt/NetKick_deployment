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

        $raw = trim(str_replace('\\', '/', (string) $this->image));
        $path = $raw;

        // If DB contains absolute URL from old domain, reuse only /storage/... path.
        if (Str::startsWith($raw, ['http://', 'https://'])) {
            $parsedPath = (string) parse_url($raw, PHP_URL_PATH);
            if (Str::contains($parsedPath, '/storage/')) {
                $path = Str::after($parsedPath, '/storage/');
            } else {
                return $raw;
            }
        }

        $path = ltrim($path, '/');
        if (Str::startsWith($path, 'storage/')) {
            $path = Str::after($path, 'storage/');
        }
        if (Str::startsWith($path, 'public/')) {
            $path = Str::after($path, 'public/');
        }

        $publicStorageFile = public_path('storage/' . ltrim($path, '/'));
        if (is_file($publicStorageFile)) {
            return asset('storage/' . $path);
        }

        // Fallback for environments where /public/storage symlink isn't available.
        return route('media.public', ['path' => $path]);
    }
}