<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductDisplayController extends Controller
{
    /**
     * Common method para sa Main Shop Page (hn.index)
     */
    public function index(Request $request)
    {
        $query = Product::where('quantity', '>', 0);

        $filters = $this->getFilterSidebarData(clone $query);
        $products = $this->applyFilters($query, $request)
            ->latest()
            ->paginate(16)
            ->withQueryString();

        return view('hn.featured', compact('products', 'filters'));
    }

    /**
     * Helper to apply common filters
     */
    private function applyFilters($query, Request $request)
    {
        // 1. Filter by Gender
        if ($request->filled('gender')) {
            $genders = (array)$request->gender;
            $query->where(function($q) use ($genders) {
                $q->whereIn('gender', $genders);
                // Kung Men/Women ang pinili, isama ang Unisex automatically
                if (in_array('Men', $genders) || in_array('Women', $genders)) {
                    $q->orWhere('gender', 'Unisex');
                }
            });
        }

        // 2. Filter by Category
        if ($request->filled('category')) {
            $query->whereIn('category', (array)$request->category);
        }

        // 3. Filter by Brand
        if ($request->filled('brand')) {
            $query->whereIn('brand', (array)$request->brand);
        }

        // 4. Filter by Color
        if ($request->filled('color')) {
            $query->whereIn('color', (array)$request->color);
        }

        // 5. Filter by Size (Gumagamit ng LIKE dahil JSON/String usually ang sizes)
        if ($request->filled('size')) {
            $query->where(function($q) use ($request) {
                foreach ((array)$request->size as $size) {
                    $q->orWhere('sizes', 'LIKE', '%' . trim($size) . '%');
                }
            });
        }

        // 6. Filter by Price Range
        if ($request->filled('price')) {
            $query->where(function($q) use ($request) {
                foreach ((array)$request->price as $range) {
                    switch ($range) {
                        case 'Under ₱2,500': $q->orWhere('price', '<', 2500); break;
                        case '₱2,500 - ₱5,000': $q->orWhereBetween('price', [2500, 5000]); break;
                        case '₱5,000 - ₱7,500': $q->orWhereBetween('price', [5000, 7500]); break;
                        case 'Over ₱7,500': $q->orWhere('price', '>', 7500); break;
                    }
                }
            });
        }

        // 7. Filter by Sale
        if ($request->boolean('sale')) {
            $query->where('is_on_sale', true)
                  ->where(function($q) {
                      $q->whereNull('sale_ends_at')->orWhere('sale_ends_at', '>', now());
                  });
        }

        return $query;
    }

    /**
     * Dynamic Sidebar Data - Kinukuha ang options base sa database
     */
    private function getFilterSidebarData($baseQuery = null)
    {
        $query = $baseQuery ?? Product::query();

        return [
            'gender' => [
                'label' => 'Gender',
                'options' => ['Men', 'Women', 'Unisex']
            ],
            'brand' => [
                'label' => 'Brand',
                'options' => (clone $query)->distinct()->whereNotNull('brand')->pluck('brand')->toArray()
            ],
            'color' => [
                'label' => 'Color',
                'options' => (clone $query)->distinct()->whereNotNull('color')->pluck('color')->toArray()
            ],
            'price' => [
                'label' => 'Price',
                'options' => ['Under ₱2,500', '₱2,500 - ₱5,000', '₱5,000 - ₱7,500', 'Over ₱7,500']
            ]
        ];
    }

    public function sale(Request $request)
    {
        $query = Product::where('quantity', '>', 0)
            ->where('is_on_sale', true)
            ->where(function($q) {
                $q->whereNull('sale_ends_at')->orWhere('sale_ends_at', '>', now());
            });

        $filters = $this->getFilterSidebarData(clone $query);
        $products = $this->applyFilters($query, $request)->latest()->paginate(16)->withQueryString();

        return view('hn.sale', compact('products', 'filters'));
    }

    public function featured(Request $request)
    {
        $query = Product::where('quantity', '>', 0); // O lagyan mo ng logic for 'is_featured'
        $filters = $this->getFilterSidebarData(clone $query);
        $products = $this->applyFilters($query, $request)->latest()->paginate(12)->withQueryString();

        return view('hn.featured', compact('products', 'filters'));
    }

    public function clothes(Request $request)
    {
        $apparelCategories = ['T-Shirts', 'Jersey', 'Hoodies', 'Socks', 'Apparel'];

        $query = Product::where('quantity', '>', 0)
            ->where(function($q) use ($apparelCategories) {
                $q->where('type', 'Apparel')
                  ->orWhere('type', 'Clothes')
                  ->orWhereIn('category', $apparelCategories);
            });

        $filters = $this->getFilterSidebarData(clone $query);
        $products = $this->applyFilters($query, $request)->latest()->paginate(16)->withQueryString();

        return view('hn.clothes', compact('products', 'filters'));
    }

    public function shoes(Request $request)
    {
        $shoeCategories = ['Basketball Shoes', 'Running Shoes', 'Lifestyle Sneakers', 'Jordan Brand', 'Lifestyle'];

        $query = Product::where('quantity', '>', 0)
            ->where(function($q) use ($shoeCategories) {
                $q->whereIn('category', $shoeCategories)
                  ->orWhere('type', 'Footwear');
            });

        $filters = $this->getFilterSidebarData(clone $query);
        $products = $this->applyFilters($query, $request)->latest()->paginate(16)->withQueryString();

        return view('hn.shoes', compact('products', 'filters'));
    }

    public function crocs(Request $request)
    {
        $crocsCategories = ['Clogs', 'Echo', 'Sandals', 'Classic Clogs', 'Echo Collection', 'Sandals & Slides'];

        $query = Product::where('quantity', '>', 0)
            ->where(function($q) use ($crocsCategories) {
                $q->where('brand', 'Crocs')
                  ->orWhereIn('category', $crocsCategories)
                  ->orWhere('type', 'Crocs')
                  ->orWhere('category', 'LIKE', '%Crocs%');
            });

        $filters = $this->getFilterSidebarData(clone $query);
        $products = $this->applyFilters($query, $request)->latest()->paginate(16)->withQueryString();

        return view('hn.crocs', compact('products', 'filters'));
    }
}
