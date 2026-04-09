<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    /**
     * Display the cart contents.
     */
    public function index()
    {
        $cartItems = session()->get('cart', []);
        return view('cart.index', compact('cartItems'));
    }

    /**
     * Add a product to the cart (Vault).
     * Updated with inventory validation.
     */
    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        // Retrieve quantity and size from the request (defaults to 1 and Standard)
        $quantityToAdd = $request->input('quantity', 1);
        $size = $request->input('size', 'Standard');
        
        // --- INVENTORY CHECK ---
        if ($product->quantity < $quantityToAdd) {
            return redirect()->back()->with('error', 'Only ' . $product->quantity . ' units left in the vault!');
        }

        $cart = session()->get('cart', []);

        // We create a unique key based on ID and Size so different sizes 
        // of the same shoe appear as separate items in the cart
        $cartKey = $product->id . '_' . $size;

        if(isset($cart[$cartKey])) {
            // Check if total quantity (existing + new) exceeds stock
            if (($cart[$cartKey]['quantity'] + $quantityToAdd) > $product->quantity) {
                return redirect()->back()->with('error', 'Cannot add more. Max vault capacity reached for this item.');
            }
            $cart[$cartKey]['quantity'] += $quantityToAdd;
        } else {
            $cart[$cartKey] = [
                "id"       => $product->id,
                "name"     => $product->name,
                "quantity" => $quantityToAdd,
                "size"     => $size,
                "price"    => $product->price,
                "image"    => $product->image,
                "category" => $product->category ?? 'General Apparel'
            ];
        }

        session()->put('cart', $cart);

        // Redirect directly to the cart index page as requested
        return redirect()->route('cart.index')->with('success', 'Product added to vault!');
    }

    /**
     * Update quantity via + / - buttons.
     * Updated to prevent exceeding stock during manual updates.
     */
    public function update(Request $request)
    {
        // Use the cartKey (id_size) to find the correct item
        if($request->id && isset($request->quantity)) {
            $cart = session()->get('cart');

            if(isset($cart[$request->id])) {
                // Find the original product to check stock again
                $product = Product::find($cart[$request->id]['id']);

                if($request->quantity <= 0) {
                    unset($cart[$request->id]);
                } else {
                    // Check if the manual input/increase exceeds stock
                    if ($product && $request->quantity > $product->quantity) {
                        return redirect()->back()->with('error', 'Only ' . $product->quantity . ' units available.');
                    }
                    $cart[$request->id]["quantity"] = $request->quantity;
                }

                session()->put('cart', $cart);
                return redirect()->back()->with('success', 'Vault updated!');
            }
        }
        
        return redirect()->back();
    }

    /**
     * Remove an item entirely.
     */
    public function destroy($id)
    {
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item removed from vault.');
    }

    
}