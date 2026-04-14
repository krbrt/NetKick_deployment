<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function public(string $path)
    {
        $cleanPath = ltrim($path, '/');
        $disk = config('filesystems.product_images_disk', 'public');

        // For non-local disks, redirect to native disk URL.
        if ($disk !== 'public') {
            if (!Storage::disk($disk)->exists($cleanPath)) {
                abort(404);
            }

            return redirect()->away(Storage::disk($disk)->url($cleanPath));
        }

        if (!Storage::disk('public')->exists($cleanPath)) {
            abort(404);
        }

        return Storage::disk('public')->response($cleanPath);
    }
}

