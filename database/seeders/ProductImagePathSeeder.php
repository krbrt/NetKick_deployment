<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductImagePathSeeder extends Seeder
{
    public function run(): void
    {
        $updated = 0;

        Product::query()->select(['id', 'image'])->chunkById(200, function ($products) use (&$updated): void {
            foreach ($products as $product) {
                $original = $product->image;
                $normalized = $this->normalizeImagePath($original);

                if ($normalized !== $original) {
                    Product::where('id', $product->id)->update(['image' => $normalized]);
                    $updated++;
                }
            }
        });

        $this->command?->info("ProductImagePathSeeder completed. Updated {$updated} product image path(s).");
    }

    private function normalizeImagePath(?string $path): ?string
    {
        if (empty($path)) {
            return $path;
        }

        $value = trim(str_replace('\\', '/', $path));

        // Keep external URLs unchanged.
        if (Str::startsWith($value, ['http://', 'https://'])) {
            return $value;
        }

        // Convert full URL/path containing /storage/... to relative public disk path.
        $storagePos = strpos($value, '/storage/');
        if ($storagePos !== false) {
            $value = substr($value, $storagePos + strlen('/storage/'));
        }

        // Strip common prefixes so DB stores only relative public-disk path.
        if (Str::startsWith($value, '/')) {
            $value = ltrim($value, '/');
        }
        if (Str::startsWith($value, 'storage/')) {
            $value = Str::after($value, 'storage/');
        }
        if (Str::startsWith($value, 'public/')) {
            $value = Str::after($value, 'public/');
        }

        // If only a filename is stored, assume it belongs to products folder.
        if (!Str::contains($value, '/') && Str::contains($value, '.')) {
            $candidate = 'products/' . $value;
            if (Storage::disk('public')->exists($candidate)) {
                return $candidate;
            }
        }

        return $value;
    }
}

