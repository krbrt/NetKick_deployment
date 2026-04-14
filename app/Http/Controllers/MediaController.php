<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function public(string $path)
    {
        $cleanPath = ltrim($path, '/');

        if (!Storage::disk('public')->exists($cleanPath)) {
            abort(404);
        }

        return Storage::disk('public')->response($cleanPath);
    }
}

