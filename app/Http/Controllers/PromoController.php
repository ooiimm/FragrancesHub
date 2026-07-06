<?php
// app/Http/Controllers/PromoController.php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index(Request $request)
    {
        $now = now();
        
        // Get active promos (siaran/broadcasts)
        $promos = Promo::where('is_active', 1)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->latest()
            ->paginate(6);

        // Get products on sale (diskon produk)
        $query = Product::with('category')
            ->where('is_active', 1)
            ->where('discount_percent', '>', 0);

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('sort')) {
            match($request->sort) {
                'discount_high' => $query->orderBy('discount_percent', 'desc'),
                'discount_low'  => $query->orderBy('discount_percent', 'asc'),
                'price_low'     => $query->orderBy('price', 'asc'),
                'price_high'    => $query->orderBy('price', 'desc'),
                default         => $query->latest(),
            };
        } else {
            $query->orderBy('discount_percent', 'desc');
        }

        $products   = $query->paginate(8);
        $categories = Category::orderBy('name')->get();
        $totalPromo = Product::where('is_active', 1)->where('discount_percent', '>', 0)->count();

        return view('promo.index', compact('promos', 'products', 'categories', 'totalPromo'));
    }
}
