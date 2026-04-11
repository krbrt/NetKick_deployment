<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    /**
     * Store a new product with image
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'brand'    => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'sizes'    => 'nullable|string',
            'color'    => 'nullable|string',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name'     => $request->name,
            'price'    => $request->price,
            'quantity' => $request->quantity,
            'brand'    => $request->brand,
            'category' => $request->category,
            'sizes'    => $request->sizes,
            'color'    => $request->color,
            'image'    => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Product added successfully.');
    }

    /**
     * Update an existing product with image
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'brand'    => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'sizes'    => 'nullable|string',
            'color'    => 'nullable|string',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name'     => $request->name,
            'price'    => $request->price,
            'quantity' => $request->quantity,
            'brand'    => $request->brand,
            'category' => $request->category,
            'sizes'    => $request->sizes,
            'color'    => $request->color,
            'image'    => $product->image,
        ]);

        return redirect()->back()->with('success', 'Product updated successfully.');
    }

    /**
     * Delete a product and its image
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully.');
    }
}