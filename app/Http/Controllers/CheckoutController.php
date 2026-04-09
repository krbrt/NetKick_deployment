<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Ipakita ang Checkout Form (address, payment method, etc.)
     */
    public function index()
    {
        $cartItems = session()->get('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('checkout.index', compact('cartItems', 'total'));
    }

    /**
     * I-save ang Order sa Database
     */
    public function process(Request $request)
    {
        // COD only
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'payment_method' => 'required|in:cod,gcash',
            'gcash_reference' => 'required_if:payment_method,gcash|nullable|string|max:255',
        ]);

        $cartItems = session()->get('cart', []);
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = 0;
        foreach ($cartItems as $cartItem) {
            $total += $cartItem['price'] * $cartItem['quantity'];
        }

        return DB::transaction(function () use ($request, $cartItems, $total) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'NK-' . strtoupper(uniqid()),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'subtotal' => $total,
                'discount_amount' => 0,
                'total_amount' => $total,
                'total_price' => $total,
'payment_method' => $request->payment_method,
'status' => $request->payment_method === 'gcash' ? 'paid' : 'pending',
'notes' => $request->payment_method === 'gcash' ? 'GCash Ref: ' . $request->gcash_reference : null,
                'status' => 'pending',
            ]);

            foreach ($cartItems as $cartItem) {
                $product = Product::find($cartItem['id']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem['id'],
                    'product_name' => $cartItem['name'],
                    'product_image' => $cartItem['image'],
                    'quantity' => $cartItem['quantity'],
                    'price' => $cartItem['price'],
                    'size' => $cartItem['size'] ?? null,
                ]);

                if ($product) {
                    $product->decrement('quantity', $cartItem['quantity']);
                }
            }

            session()->forget('cart');

            return redirect()->route('checkout.success')->with('order_number', $order->order_number);
        });
    }

    public function success()
    {
        return view('checkout.success');
    }
}
