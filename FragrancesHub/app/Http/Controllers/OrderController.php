<?php
// app/Http/Controllers/OrderController.php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('payment')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Pastikan order milik user yang login
        abort_if($order->user_id !== auth()->id(), 403);

        $order->load('orderItems.product', 'payment');

        return view('orders.show', compact('order'));
    }

    public function checkout()
    {
        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja kosong.');
        }

        $total = $cartItems->sum(fn($item) => $item->quantity * $item->product->discounted_price);

        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'phone'            => 'required|string|max:20',
            'notes'            => 'nullable|string|max:500',
        ]);

        $cartItems = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja kosong.');
        }

        // Cek stok semua produk
        foreach ($cartItems as $item) {
            if ($item->product->stock < $item->quantity) {
                return back()->with('error',
                    "Stok {$item->product->name} tidak mencukupi.");
            }
        }

        DB::transaction(function () use ($request, $cartItems) {
            $total = $cartItems->sum(fn($i) => $i->quantity * $i->product->discounted_price);

            // Buat order
            $order = Order::create([
                'user_id'          => auth()->id(),
                'order_number'     => 'ORD-' . strtoupper(uniqid()),
                'total_amount'     => $total,
                'shipping_address' => $request->shipping_address,
                'phone'            => $request->phone,
                'notes'            => $request->notes,
                'status'           => 'waiting_payment',
            ]);

            // Buat order items & kurangi stok
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name,
                    'price'        => $item->product->discounted_price,
                    'quantity'     => $item->quantity,
                    'subtotal'     => $item->quantity * $item->product->discounted_price,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            // Buat record payment (info rekening bank)
            Payment::create([
                'order_id'       => $order->id,
                'bank_name'      => 'BCA',
                'account_number' => '6801397384',
                'account_name'   => 'FragrancesHub Store',
                'amount'         => $total,
                'status'         => 'pending',
            ]);

            // Kosongkan cart
            Cart::where('user_id', auth()->id())->delete();

            session(['last_order_id' => $order->id]);
        });

        $orderId = session('last_order_id');

        return redirect()->route('payment.show', $orderId)
            ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }
}
