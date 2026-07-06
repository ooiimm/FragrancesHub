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
        $cartItems = Cart::with(['product.category'])
            ->where('user_id', auth()->id())
            ->get();

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->discounted_price;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi. Tersedia: ' . $product->stock . ' pcs.');
        }

        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $newQty = $cartItem->quantity + $request->quantity;
            if ($newQty > $product->stock) {
                return back()->with('error', 'Total melebihi stok (' . $product->stock . ' pcs).');
            }
            $cartItem->update(['quantity' => $newQty]);
        } else {
            Cart::create([
                'user_id'    => auth()->id(),
                'product_id' => $product->id,
                'quantity'   => $request->quantity,
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

        if ($request->quantity > $cart->product->stock) {
            return back()->with('error', 'Stok tidak mencukupi. Tersedia: ' . $cart->product->stock . ' pcs.');
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
