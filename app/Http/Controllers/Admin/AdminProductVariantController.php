<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminProductVariantController extends Controller
{
    public function create(Product $product)
    {
        return view('admin.products.variants.create', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'size'  => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        // Cek apakah varian size ini sudah ada
        $existingVariant = $product->variants()
            ->where('size', $request->size)
            ->first();

        if ($existingVariant) {
            return back()->with('error', "Varian '{$request->size}' sudah ada untuk produk ini!");
        }

        ProductVariant::create([
            'product_id' => $product->id,
            'size'       => $request->size,
            'price'      => $request->price,
            'stock'      => $request->stock,
            'is_active'  => true,
        ]);

        return redirect()->route('admin.products.edit', $product)
            ->with('success', "Varian '{$request->size}' berhasil ditambahkan!");
    }

    public function edit(Product $product, ProductVariant $variant)
    {
        if ($variant->product_id !== $product->id) {
            abort(404);
        }

        return view('admin.products.variants.edit', compact('product', 'variant'));
    }

    public function update(Request $request, Product $product, ProductVariant $variant)
    {
        if ($variant->product_id !== $product->id) {
            abort(404);
        }

        $request->validate([
            'size'  => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        // Cek apakah size sudah digunakan varian lain
        $existingVariant = $product->variants()
            ->where('size', $request->size)
            ->where('id', '!=', $variant->id)
            ->first();

        if ($existingVariant) {
            return back()->with('error', "Varian '{$request->size}' sudah ada untuk produk ini!");
        }

        $variant->update($request->only(['size', 'price', 'stock']));

        return redirect()->route('admin.products.edit', $product)
            ->with('success', 'Varian berhasil diperbarui!');
    }

    public function destroy(Product $product, ProductVariant $variant)
    {
        if ($variant->product_id !== $product->id) {
            abort(404);
        }

        $variant->delete();

        return back()->with('success', 'Varian berhasil dihapus!');
    }
}
