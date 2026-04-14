<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    private function getAvailableSizes(Product $product): array
    {
        return $product->available_sizes;
    }

    private function addItemToSessionCart(Product $product, int $quantityToAdd, string $size): ?string
    {
        if ($product->quantity < $quantityToAdd) {
            return 'Only ' . $product->quantity . ' units left in the vault!';
        }

        $availableSizes = $this->getAvailableSizes($product);
        if (empty($availableSizes)) {
            return 'Size is not available for this product.';
        } elseif (!in_array($size, $availableSizes, true)) {
            // Production-safe fallback: normalize invalid/missing submitted size.
            $size = $availableSizes[0];
        }

        $sizeStockMap = $product->size_stock_map;
        $sizeStock = $sizeStockMap[$size] ?? null;

        $cart = session()->get('cart', []);
        $cartKey = $product->id . '_' . $size;

        if (isset($cart[$cartKey])) {
            if ($sizeStock !== null && ($cart[$cartKey]['quantity'] + $quantityToAdd) > $sizeStock) {
                return 'Only ' . $sizeStock . ' unit(s) available for size ' . $size . '.';
            }
            if (($cart[$cartKey]['quantity'] + $quantityToAdd) > $product->quantity) {
                return 'Cannot add more. Max vault capacity reached for this item.';
            }
            $cart[$cartKey]['quantity'] += $quantityToAdd;
        } else {
            if ($sizeStock !== null && $quantityToAdd > $sizeStock) {
                return 'Only ' . $sizeStock . ' unit(s) available for size ' . $size . '.';
            }
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
        return null;
    }

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
        $quantityToAdd = max(1, (int) $request->input('quantity', 1));
        $size = trim((string) $request->input('size', ''));
        $availableSizes = $this->getAvailableSizes($product);
        if ($size === '' || (!empty($availableSizes) && !in_array($size, $availableSizes, true))) {
            $size = $availableSizes[0] ?? '';
        }
        $errorMessage = $this->addItemToSessionCart($product, $quantityToAdd, $size);
        if ($errorMessage) {
            return redirect()->back()->with('error', $errorMessage);
        }

        // Redirect directly to the cart index page as requested
        return redirect()->route('cart.index')->with('success', 'Product added to vault!');
    }

    public function buyNow(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $quantityToAdd = max(1, (int) $request->input('quantity', 1));
        $size = trim((string) $request->input('size', ''));
        $availableSizes = $this->getAvailableSizes($product);
        if ($size === '' || (!empty($availableSizes) && !in_array($size, $availableSizes, true))) {
            $size = $availableSizes[0] ?? '';
        }

        $errorMessage = $this->addItemToSessionCart($product, $quantityToAdd, $size);
        if ($errorMessage) {
            return redirect()->back()->with('error', $errorMessage);
        }

        return redirect()->route('checkout.index');
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
                    if ($product) {
                        $size = $cart[$request->id]['size'] ?? null;
                        $sizeStock = $size ? ($product->size_stock_map[$size] ?? null) : null;
                        if ($sizeStock !== null && $request->quantity > $sizeStock) {
                            return redirect()->back()->with('error', 'Only ' . $sizeStock . ' unit(s) available for size ' . $size . '.');
                        }
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