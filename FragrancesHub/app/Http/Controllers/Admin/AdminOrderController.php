<?php
// app/Http/Controllers/Admin/AdminOrderController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user', 'payment');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%');
        }

        $orders = $query->latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'orderItems.product', 'payment');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,waiting_payment,payment_uploaded,processing,shipped,delivered,cancelled',
        ]);

        $previousStatus = $order->status;
        $newStatus      = $request->status;

        $order->update(['status' => $newStatus]);

        // Jika admin verifikasi pembayaran
        if ($newStatus === 'processing' && $order->payment) {
            $order->payment->update(['status' => 'verified']);
        }

        // Kembalikan stok jika order di-cancel
        // (hanya jika status sebelumnya bukan cancelled agar tidak double-restore)
        if ($newStatus === 'cancelled' && $previousStatus !== 'cancelled') {
            $order->load('orderItems');
            foreach ($order->orderItems as $item) {
                Product::where('id', $item->product_id)
                    ->increment('stock', $item->quantity);
            }
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
