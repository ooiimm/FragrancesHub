<?php
// app/Http/Controllers/CartController.php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with(['product.category', 'variant'])
            ->where('user_id', auth()->id())
            ->get();

        $total = $cartItems->sum(function ($item) {
            if ($item->product_variant_id) {
                return $item->quantity * $item->variant->price;
            }
            return $item->quantity * $item->product->discounted_price;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
            'variant_id' => 'nullable|integer',
        ]);

        // Handle variant_id = 0 as base product (no variant)
        if (
            $product->variants()->exists()
            && !$request->filled('variant_id')
            && $request->input('variant_id') !== '0'
        ) {
            return back()->with('error', 'Pilih varian produk terlebih dahulu.');
        }

        $variantId = $request->filled('variant_id') && $request->variant_id != '0'
            ? (int) $request->variant_id
            : null;

        $variant = $variantId ? $product->variants()->find($variantId) : null;

        if ($variantId && !$variant) {
            return back()->with('error', 'Varian produk tidak valid.');
        }

        // Check stock based on variant or product
        $stock = $variant ? $variant->stock : $product->stock;

        if ($stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi. Tersedia: ' . $stock . ' pcs.');
        }

        // Check if item already in cart
        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->where('product_variant_id', $variantId)
            ->first();

        if ($cartItem) {
            $newQty = $cartItem->quantity + $request->quantity;
            if ($newQty > $stock) {
                return back()->with('error', 'Total melebihi stok (' . $stock . ' pcs).');
            }
            $cartItem->update(['quantity' => $newQty]);
        } else {
            Cart::create([
                'user_id'              => auth()->id(),
                'product_id'           => $product->id,
                'product_variant_id'   => $variantId,
                'variant_size'         => $variant?->size,
                'quantity'             => $request->quantity,
            ]);
        }

        return back()->with('success', '"' . $product->name . '" ditambahkan ke keranjang!');
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            return back()->with('error', 'Akses ditolak.');
        }

        $request->validate(['quantity' => 'required|integer|min:1|max:100']);

        $stock = $cart->product_variant_id 
            ? $cart->variant->stock 
            : $cart->product->stock;

        if ($request->quantity > $stock) {
            return back()->with('error', 'Stok tidak mencukupi. Tersedia: ' . $stock . ' pcs.');
        }

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Jumlah berhasil diperbarui.');
    }

    public function remove(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            return back()->with('error', 'Akses ditolak.');
        }

        $name = $cart->product->name;
        $cart->delete();

        return back()->with('success', '"' . $name . '" dihapus dari keranjang.');
    }
}
