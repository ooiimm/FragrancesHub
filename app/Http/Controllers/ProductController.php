<?php
// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')
            ->orderByRaw('CASE WHEN stock > 0 THEN 0 ELSE 1 END')
            ->latest();

        // Cek dulu apakah kolom is_active ada sebelum filter
        if (Schema::hasColumn('products', 'is_active')) {
            $query->where('is_active', 1);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $products   = $query->latest()->paginate(12);
        $categories = Category::orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(string $slug)
    {
        $product = Product::with(['category', 'variants'])
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedQuery = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id);

        if (Schema::hasColumn('products', 'is_active')) {
            $relatedQuery->where('is_active', 1);
        }

        $related = $relatedQuery->latest()->limit(4)->get();

        return view('products.show', compact('product', 'related'));
    }
}
