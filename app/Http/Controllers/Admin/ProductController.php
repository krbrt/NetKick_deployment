<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $categories = \App\Models\Product::select('category')->distinct()->pluck('category');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:100',
            'category' => 'required|string',
            'type' => 'required|string',
            'color' => 'required|string|max:100',
            'gender' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sizes' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image && \Illuminate\Support\Facades\File::exists(public_path($product->image))) {
                \Illuminate\Support\Facades\File::delete(public_path($product->image));
            }
            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $product->image = 'images/products/' . $imageName;
        }

        $brand = ($request->brand === 'OTHER') ? $request->new_brand : $request->brand;
        $category = ($request->category === 'NEW') ? $request->new_category : $request->category;

        $product->update([
            'name' => $request->name,
            'brand' => $brand,
            'category' => $category,
            'type' => $request->type,
            'color' => $request->color,
            'gender' => $request->gender,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'sizes' => $request->sizes,
            'image' => $product->image,
        ]);

        return redirect()->route('admin.inventory')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        if ($product->image && \Illuminate\Support\Facades\File::exists(public_path($product->image))) {
            \Illuminate\Support\Facades\File::delete(public_path($product->image));
        }
        $product->delete();
        return redirect()->route('admin.inventory')->with('success', 'Product deleted successfully!');
    }


    /**
     * Eto ang logic para sa User/Customer Side.
     * Dito naba-filter kung Footwear, Apparel, o specific Category ang ipapakita.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // 1. Filter base sa TYPE (Footwear o Apparel)
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        // 2. Filter base sa CATEGORY (e.g. Basketball, T-Shirts)
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        // 3. Filter base sa GENDER (optional kung may filter ka sa sidebar)
        if ($request->has('gender')) {
            $query->where('gender', $request->gender);
        }

        // Kukunin ang products (naka-paginate para hindi mabagal ang loading)
        $products = $query->latest()->paginate(12);

        // Ipapasa ang products sa view
        return view('products.index', compact('products'));
    }

    // Ipinapakita ang Add Product Form
    public function create()
    {
        $categories = Product::select('category')->distinct()->pluck('category');
        return view('admin.products.create', compact('categories'));
    }

    // Sine-save ang data mula sa form
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:100',
            'type' => 'required|string',         // REQUIRED: Footwear or Apparel
            'category' => 'required|string',
            'color' => 'required|string|max:100',
            'gender' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sizes' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $brand = ($request->brand === 'OTHER') ? $request->new_brand : $request->brand;
        $category = ($request->category === 'NEW') ? $request->new_category : $request->category;

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $imagePath = 'images/products/' . $imageName;
        }

        Product::create([
            'name' => $request->name,
            'brand' => $brand,
            'type' => $request->type,        // SAVE TYPE
            'category' => $category,
            'color' => $request->color,
            'gender' => $request->gender,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'sizes' => $request->sizes,
            'image' => $imagePath,
            'is_on_sale' => false,
        ]);

        return redirect()->route('admin.inventory')->with('success', 'Product added successfully!');
    }

    public function inventory()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.inventory', compact('products'));
    }
}
