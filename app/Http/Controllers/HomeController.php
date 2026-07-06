<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if (Schema::hasColumn('products', 'is_active')) {
            $query->where('is_active', 1);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products   = $query->latest()->paginate(8);
        $categories = Category::orderBy('name')->get();

        // Get featured products
        $featuredQuery = Product::with('category', 'variants')
            ->where('is_active', 1)
            ->where('is_featured', 1)
            ->latest();
        $featured = $featuredQuery->limit(6)->get();

        // Get active promos
        $now = now();
        $promos = Promo::where('is_active', 1)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->latest()
            ->limit(5)
            ->get();

        // Get best sellers (top by total quantity sold)
        // Using order_items.quantity as the source.
        $bestSellers = Product::with('category', 'variants')
            ->select('products.*', 
                \DB::raw('SUM(order_items.quantity) as total_sold')
            )
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->where('products.is_active', 1)
            // MySQL strict mode (ONLY_FULL_GROUP_BY) requires every selected column to be in GROUP BY.
            ->groupBy(
                'products.id',
                'products.category_id',
                'products.name',
                'products.slug',
                'products.description',
                'products.price',
                'products.stock',
                'products.image',
                'products.is_active',
                'products.is_featured',
                'products.created_at',
                'products.updated_at'
            )
            ->when(Schema::hasColumn('products', 'discount_percent'), function ($query) {
                $query->groupBy('products.discount_percent');
            })
            ->orderByDesc('total_sold')
            ->limit(3)
            ->get();


        return view('home', compact('products', 'categories', 'featured', 'promos', 'bestSellers'));
    }
}

