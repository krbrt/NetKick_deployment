<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
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
            'sizes'    => 'required|string',
            'quality'  => 'required|string',
            'image'    => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $brand    = ($request->brand === 'OTHER') ? $request->new_brand : $request->brand;
        $category = ($request->category === 'NEW') ? $request->new_category : $request->category;

        // ✅ Store in storage/app/public/products — persists on Laravel Cloud
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');;
        }

        Product::create([
            'name'       => $request->name,
            'brand'      => $brand,
            'type'       => $request->type,
            'category'   => $category,
            'color'      => $request->color,
            'gender'     => $request->gender,
            'price'      => $request->price,
            'quantity'   => $request->quantity,
            'sizes'      => $request->sizes,
            'image'      => $imagePath,
            'quality'    => $request->quality,
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
            'sizes'    => 'required|string',
            'quality'  => 'required|string',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // ✅ Delete old image from storage
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            // ✅ Store new image
            $product->image = $request->file('image')->store('products', 'public');
        }

        $brand    = ($request->brand === 'OTHER') ? $request->new_brand : $request->brand;
        $category = ($request->category === 'NEW') ? $request->new_category : $request->category;

        $product->update([
            'name'     => $request->name,
            'brand'    => $brand,
            'category' => $category,
            'type'     => $request->type,
            'color'    => $request->color,
            'gender'   => $request->gender,
            'price'    => $request->price,
            'quantity' => $request->quantity,
            'sizes'    => $request->sizes,
            'image'    => $product->image,
            'quality'  => $request->quality,
        ]);

        return redirect()->route('admin.inventory')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // ✅ Delete from storage
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
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