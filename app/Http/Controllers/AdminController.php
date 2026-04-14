<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Voucher;
use App\Models\Order;
use App\Models\Report;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * DASHBOARD LOGIC (VAULT OVERVIEW)
     */
    public function index()
    {
        // Mas accurate na revenue calculation (Delivered orders only)
$revenue = \App\Models\OrderItem::whereHas('order', function($q) { $q->whereNotIn('status', ['cancelled']); })->sum(DB::raw('quantity * price')) ?? 0;
        $productsCount = Product::count();
        $vouchersCount = Voucher::where('expiry', '>', now())->count();

        $column = Schema::hasColumn('users', 'role') ? 'role' : 'usertype';
        $customersCount = User::whereIn($column, ['user', 'customer'])->count();

        // Get recent transactions with items - prioritized by latest
        $transactions = Order::with(['user', 'items'])->latest()->take(5)->get();

        $productCount = $productsCount;
        $voucherCount = $vouchersCount;
        $totalRevenue = $revenue;
        $customerCount = $customersCount;
        $saleItemCount = Product::where('is_on_sale', true)->count();
        $lowStockCount = Product::where('quantity', '<', 5)->count();
        $mainBanner = Setting::where('key', 'main_banner')->first();

        // Count pending and processing orders for attention badges
        $pendingOrdersCount = Order::where('status', 'pending')->count();
        $processingOrdersCount = Order::where('status', 'processing')->count();

        return view('admin.home', compact(
            'revenue', 'productsCount', 'vouchersCount', 'customersCount', 'transactions',
            'productCount', 'voucherCount', 'totalRevenue',
            'customerCount', 'mainBanner', 'lowStockCount', 'saleItemCount',
            'pendingOrdersCount', 'processingOrdersCount'
        ));
    }

    /**
     * ORDERS MANAGEMENT
     */
    public function orders(Request $request)
    {
        $query = Order::with(['user', 'items']);

        // Filter by status (Pending, Processing, Shipped, etc.)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by Order Number or Customer Name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        $orders = $query->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function orderDetails($id)
    {
        // In-update para isama ang detailed order items at snapshots
        $order = Order::with(['user', 'items'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Logic: Kung ang order ay kinansela, ibalik ang stock sa inventory
        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->increment('quantity', $item->quantity);
                }
            }
        }
        // Logic: Kung ang order ay galing sa cancelled at naging active ulit, bawasan ang stock
        elseif ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
            foreach ($order->items as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    $product->decrement('quantity', $item->quantity);
                }
            }
        }

        $order->update(['status' => $newStatus]);

        return redirect()->back()->with('success', "Order #{$order->order_number} status updated to " . strtoupper($newStatus));
    }

    /**
     * SALES & INVENTORY (Preserved)
     */
    public function sales()
    {
        $salesItems = Product::where('is_on_sale', true)->latest()->paginate(10);
        $grossInventoryValue = $salesItems->sum(function ($item) {
            $grossPrice = $item->original_price > 0 ? $item->original_price : $item->price;
            return $grossPrice * $item->quantity;
        });
        $otherProducts = Product::where('is_on_sale', false)->get();
        return view('admin.sales.index', compact('salesItems', 'otherProducts', 'grossInventoryValue'));
    }

    public function quickAdd(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'sale_price' => 'nullable|numeric|min:0',
            'duration_days' => 'nullable|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $originalPrice = $product->price;
            $salePrice = $originalPrice * (1 - ($request->discount_percentage ?? 10) / 100);
        $discountPercentage = round((($originalPrice - $salePrice) / $originalPrice) * 100);

        $product->update([
            'is_on_sale' => true,
            'original_price' => $originalPrice,
            'price' => $salePrice,
            'discount_percentage' => $discountPercentage,
            'sale_ends_at' => $request->duration_days ? now()->addDays($request->duration_days) : null
        ]);

        return redirect()->back()->with('success', "{$product->name} (–{$discountPercentage}%) deployed to Sale Vault.");
    }

    public function toggleSale(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->is_on_sale) {
            $product->update([
                'is_on_sale' => false,
                'price' => $product->original_price ?? $product->price,
                'original_price' => null,
                'discount_percentage' => null,
                'sale_ends_at' => null
            ]);
            $msg = 'Item pulled from Sale Vault. Original price restored.';
        } else {
            $oldPrice = $product->price;
            $newPrice = $oldPrice * 0.9;
            $discountPct = 10; // Default 10%

            $product->update([
                'is_on_sale' => true,
                'original_price' => $oldPrice,
                'price' => $newPrice,
                'discount_percentage' => $discountPct
            ]);
            $msg = 'Item deployed to Sale Vault at 10% discount.';
        }

        return redirect()->back()->with('success', $msg);
    }

    public function inventory(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('category', 'like', '%' . $request->search . '%')
                  ->orWhere('brand', 'like', '%' . $request->search . '%')
                  ->orWhere('id', 'like', '%' . $request->search . '%');
            });
        }

$products = $query->latest()->paginate(10);
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
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:100',
            'category' => 'required|string',
            'type' => 'required|string',
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
            $request->image->move(public_path('storage/products'), $imageName);
            $imagePath = 'storage/products/' . $imageName;
        }

        Product::create([
            'name' => $request->name,
            'brand' => $brand,
            'category' => $category,
            'type' => $request->type,
            'color' => $request->color,
            'gender' => $request->gender,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'sizes' => $request->sizes,
            'image' => $imagePath,
            'is_on_sale' => false,
        ]);

        return redirect()->route('admin.inventory')->with('success', 'Product deployed to vault.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:100',
            'category' => 'required|string',
            'type' => 'required|string',
            'color' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $isOnSale = $product->is_on_sale;
        $originalPrice = $product->original_price;
        $discountPercent = $product->discount_percentage;

        if ($request->price != $product->price) {
            $isOnSale = false;
            $originalPrice = null;
            $discountPercent = null;
        }

        if ($request->hasFile('image')) {
            if ($product->image && File::exists(public_path($product->image))) {
                File::delete(public_path($product->image));
            }
            $imageName = time() . '_' . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $product->image = 'images/products/' . $imageName;
        }

        $product->update([
            'name' => $request->name,
            'brand' => $request->brand,
            'category' => $request->category,
            'type' => $request->type,
            'color' => $request->color,
            'gender' => $request->gender ?? $product->gender,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'sizes' => $request->sizes ?? $product->sizes,
            'is_on_sale' => $isOnSale,
            'original_price' => $originalPrice,
            'discount_percentage' => $discountPercent,
            'image' => $product->image,
        ]);

        return redirect()->route('admin.inventory')->with('success', 'Vault item recalibrated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image && File::exists(public_path($product->image))) {
            File::delete(public_path($product->image));
        }
        $product->delete();
        return redirect()->route('admin.inventory')->with('success', 'Item purged.');
    }

    public function vouchers()
    {
        $vouchers = Voucher::latest()->get();
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function storeVoucher(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:vouchers,code|max:50',
            'type' => 'required|in:percent,fixed',
            'discount' => 'required|numeric|min:0',
            'expiry' => 'required|date|after:today',
            'limit' => 'nullable|integer|min:1',
            'status' => 'required|in:active,disabled'
        ]);

        Voucher::create([
            'code' => strtoupper($request->code),
            'type' => $request->type,
            'discount' => $request->discount,
            'expiry' => $request->expiry,
            'limit' => $request->limit,
            'status' => $request->status
        ]);

        return redirect()->route('admin.vouchers.index')->with('success', 'Voucher Secured.');

    }

    public function destroyVoucher($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();
        return redirect()->back()->with('success', 'Voucher deleted.');
    }

    public function reports()
    {
        // Consistent with dashboard: accurate revenue from delivered order items
// Gross revenue: use original_price if on sale, else price

$totalRevenue = \App\Models\OrderItem::whereHas('order', function($q) {
            $q->whereNotIn('status', ['cancelled']);
        })->sum(DB::raw('quantity * price'));

        
$totalOrders = Order::count();
        $avgOrder = $totalOrders > 0 ? ($totalRevenue / $totalOrders) : 0;

$sales = Order::withCount('items')->latest()->paginate(10);
        $generatedReports = Report::latest()->get();

        return view('admin.reports', compact('totalRevenue', 'totalOrders', 'avgOrder', 'sales', 'generatedReports'));
    }

    public function customers()
    {
        $column = Schema::hasColumn('users', 'role') ? 'role' : 'usertype';
        $customers = User::whereIn($column, ['user', 'customer'])->latest()->paginate(10);
        return view('admin.customers', compact('customers'));
    }

    public function updateBanner(Request $request)
    {
        $request->validate(['image' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072']);
        $setting = Setting::firstOrCreate(['key' => 'main_banner']);

        if ($request->hasFile('image')) {
            if ($setting->value && File::exists(public_path($setting->value))) {
                File::delete(public_path($setting->value));
            }
            $imageName = 'banner_' . time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/banners'), $imageName);
            $setting->update(['value' => 'images/banners/' . $imageName]);
        }
        return redirect()->back()->with('success', 'Banner updated.');
    }
}
