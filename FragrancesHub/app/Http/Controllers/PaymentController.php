<?php
// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function show(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        $order->load('payment', 'orderItems');

        return view('payment.show', compact('order'));
    }

    public function upload(Request $request, Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        $request->validate([
            'proof_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('proof_image')
            ->store('payments', 'public');

        $order->payment->update([
            'proof_image' => $path,
            'status'      => 'pending',
        ]);

        $order->update(['status' => 'payment_uploaded']);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
    }
}
