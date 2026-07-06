<?php
// app/Http/Controllers/Admin/AdminOrderController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
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
                if ($item->product_variant_id) {
                    ProductVariant::where('id', $item->product_variant_id)
                        ->increment('stock', $item->quantity);
                } else {
                    Product::where('id', $item->product_id)
                        ->increment('stock', $item->quantity);
                }
            }
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    /**
     * Generate a PDF report of orders. Accepts optional filters: status, search, date_from, date_to
     */
    public function reportPdf(Request $request)
    {
        $query = Order::with('user', 'payment', 'orderItems.product');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('order_number', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->get();

        $totalAmount = $orders->sum('total_amount');

        $data = compact('orders', 'totalAmount');

        // If the DOMPDF package is installed (barryvdh/laravel-dompdf), use it.
        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.orders.report-pdf', $data)
                ->setPaper('a4', 'landscape');
            $fileName = 'laporan-pesanan-' . now()->format('Ymd_His') . '.pdf';
            return $pdf->download($fileName);
        }

        // Fallback: render HTML view so admin can still print manually
        return view('admin.orders.report-pdf', $data);
    }
}
