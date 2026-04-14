<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private function productImageDisk(): string
    {
        return config('filesystems.product_images_disk', 'public');
    }

    private function normalizeSizes(string $sizes): string
    {
        $raw = trim($sizes);
        if ($raw === '') {
            return '';
        }
        $tokens = collect(preg_split('/[\r\n,;]+/', $raw) ?: [])
            ->map(fn ($token) => trim($token))
            ->filter()
            ->values();

        $normalized = [];
        foreach ($tokens as $token) {
            // Range with optional qty: "40-45" or "40-45=3"
            if (preg_match('/^(\d+)\s*-\s*(\d+)(?:\s*=\s*(\d+))?$/', $token, $range)) {
                $start = (int) $range[1];
                $end = (int) $range[2];
                $qty = isset($range[3]) ? (int) $range[3] : 1;
                $qty = max(1, min(6, $qty));
                $step = $start <= $end ? 1 : -1;

                for ($i = $start; $step === 1 ? $i <= $end : $i >= $end; $i += $step) {
                    $normalized[(string) $i] = $qty;
                }
                continue;
            }

            // Single size with optional qty: "42" or "42=4" or "XL=2"
            if (preg_match('/^([^=\s]+)(?:\s*=\s*(\d+))?$/', $token, $single)) {
                $size = trim($single[1]);
                if ($size === '') {
                    continue;
                }

                $qty = isset($single[2]) ? (int) $single[2] : 1;
                $qty = max(1, min(6, $qty));
                $normalized[$size] = $qty;
            }
        }

        return collect($normalized)
            ->map(fn ($qty, $size) => $size . '=' . $qty)
            ->implode(', ');
    }

    private function totalSizeStock(string $sizes): ?int
    {
        $tokens = collect(explode(',', $sizes))
            ->map(fn ($token) => trim($token))
            ->filter(fn ($token) => str_contains($token, '='))
            ->values();

        if ($tokens->isEmpty()) {
            return null;
        }

        return $tokens->sum(function ($token) {
            [, $qty] = array_map('trim', explode('=', $token, 2));
            return max(0, (int) $qty);
        });
    }

    public function inventory()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.inventory', compact('products'));
    }

    public function create()
    {
        $categories = Product::select('category')->distinct()->pluck('category');
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'brand'    => 'required|string|max:100',
            'type'     => 'required|string',
            'category' => 'required|string',
            'color'    => 'required|string|max:100',
            'gender'   => 'required|string',
            'price'    => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sizes'    => 'nullable|string',
            'quality'  => 'required|string',
            'image'    => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $brand    = ($request->brand === 'OTHER') ? $request->new_brand : $request->brand;
        $category = ($request->category === 'NEW') ? $request->new_category : $request->category;

        // ✅ Store in storage/app/public/products — persists on Laravel Cloud
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', $this->productImageDisk());
        }

        $normalizedSizes = $request->filled('sizes') ? $this->normalizeSizes($request->sizes) : null;
        $sizeStockTotal = $normalizedSizes ? $this->totalSizeStock($normalizedSizes) : null;
        $finalQuantity = $sizeStockTotal ?? (int) $request->quantity;

        Product::create([
            'name'       => $request->name,
            'brand'      => $brand,
            'type'       => $request->type,
            'category'   => $category,
            'color'      => $request->color,
            'gender'     => $request->gender,
            'price'      => $request->price,
            'quantity'   => $finalQuantity,
            'sizes'      => $normalizedSizes,
            'image'      => $imagePath,
'quality'    => $request->quality ?? null,
            'is_on_sale' => false,
        ]);

        return redirect()->route('admin.inventory')->with('success', 'Product added successfully!');
    }

    public function edit($id)
    {
        $product    = Product::findOrFail($id);
        $categories = Product::select('category')->distinct()->pluck('category');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'brand'    => 'required|string|max:100',
            'category' => 'required|string',
            'type'     => 'required|string',
            'color'    => 'required|string|max:100',
            'gender'   => 'required|string',
            'price'    => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sizes'    => 'nullable|string',
            'quality'  => 'required|string',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // ✅ Delete old image from storage
            if ($product->image) {
                Storage::disk($this->productImageDisk())->delete($product->image);
            }
            // ✅ Store new image
            $product->image = $request->file('image')->store('products', $this->productImageDisk());
        }

        $brand    = ($request->brand === 'OTHER') ? $request->new_brand : $request->brand;
        $category = ($request->category === 'NEW') ? $request->new_category : $request->category;

        $normalizedSizes = $request->filled('sizes') ? $this->normalizeSizes($request->sizes) : null;
        $sizeStockTotal = $normalizedSizes ? $this->totalSizeStock($normalizedSizes) : null;
        $finalQuantity = $sizeStockTotal ?? (int) $request->quantity;

        $product->update([
            'name'     => $request->name,
            'brand'    => $brand,
            'category' => $category,
            'type'     => $request->type,
            'color'    => $request->color,
            'gender'   => $request->gender,
            'price'    => $request->price,
            'quantity' => $finalQuantity,
            'sizes'    => $normalizedSizes,
            'image'    => $product->image,
'quality'  => $request->quality ?? null,
        ]);

        return redirect()->route('admin.inventory')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // ✅ Delete from storage
        if ($product->image) {
            Storage::disk($this->productImageDisk())->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.inventory')->with('success', 'Product deleted successfully!');
    }

    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('brand')) {
            $query->whereIn('brand', (array)$request->brand);
        }
        if ($request->has('category')) {
            $query->whereIn('category', (array)$request->category);
        }
        if ($request->has('gender')) {
            $query->whereIn('gender', (array)$request->gender);
        }
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        if ($request->has('size')) {
            $sizes = (array)$request->size;
            $query->where(function ($q) use ($sizes) {
                foreach ($sizes as $size) {
                    $q->orWhere('sizes', 'LIKE', "%$size%");
                }
            });
        }

        $products = $query->latest()->paginate(12);
        return view('products.index', compact('products'));
    }
}