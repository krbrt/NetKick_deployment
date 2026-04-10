<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display admin inventory list.
     */
    public function inventory()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.inventory', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Product::select('category')->distinct()->pluck('category');
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'brand'    => 'required|string|max:100',
            'type'     => 'required|string', // Footwear or Apparel
            'category' => 'required|string',
            'color'    => 'required|string|max:100',
            'gender'   => 'required|string',
            'price'    => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sizes'    => 'required|string',
            'quality'  => 'required|string', // e.g., Top-Grade, Class A
            'image'    => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Handle "Other" logic for Brand and Category
        $brand = ($request->brand === 'OTHER') ? $request->new_brand : $request->brand;
        $category = ($request->category === 'NEW') ? $request->new_category : $request->category;

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $imagePath = 'images/products/' . $imageName;
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

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Product::select('category')->distinct()->pluck('category');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
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

        // Image Update Logic
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($product->image && File::exists(public_path($product->image))) {
                File::delete(public_path($product->image));
            }

            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $product->image = 'images/products/' . $imageName;
        }

        // Handle "Other" logic
        $brand = ($request->brand === 'OTHER') ? $request->new_brand : $request->brand;
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
            'image'    => $product->image, // Holds new path or old path
            'quality'  => $request->quality,
        ]);

        return redirect()->route('admin.inventory')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image && File::exists(public_path($product->image))) {
            File::delete(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('admin.inventory')->with('success', 'Product deleted successfully!');
    }

    /**
     * CUSTOMER SIDE: Shop / Inventory View with Advanced Filtering.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Multi-select Filtering (Matches the Sidebar Checkboxes)
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

        // Size filtering (Assuming sizes are comma-separated strings in DB)
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
