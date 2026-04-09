<?php

namespace App\Http\Controllers; // Ensure this matches app/Http/Controllers/HomeController.php

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * CENTRAL NAVIGATION HUB
     * Redirects users to their specific workspace based on usertype.
     */
    public function index()
    {
        // 1. Safety Check: If not logged in, send to login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $usertype = Auth::user()->usertype;

        // --- ADMIN REDIRECT ---
        // We redirect to the admin.home route so the AdminController 
        // can handle the complex stats (Revenue, Vouchers, etc.)
        if ($usertype == 'admin') {
            return redirect()->route('admin.home');
        }

        // --- USER PROTOCOL ---
        // For regular users, we show the main dashboard with latest products
        if ($usertype == 'user') {
            $products = Product::latest()->take(8)->get(); // Optimization: take only 8
            return view('dashboard', compact('products'));
        }

        // Default fallback
        return redirect('/');
    }
}