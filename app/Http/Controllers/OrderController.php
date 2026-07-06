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
        $cartItems = Cart::with(['product', 'variant'])
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja kosong.');
        }

        $total = $cartItems->sum(function ($item) {
            if ($item->product_variant_id) {
                return $item->quantity * $item->variant->price;
            }
            return $item->quantity * $item->product->discounted_price;
        });

        $paymentMethods = [
            'bank_transfer' => 'Transfer Bank (BCA, Mandiri, BNI, dll)',
            'ovo' => 'OVO',
            'gopay' => 'GoPay',
            'dana' => 'Dana',
            'cod' => 'Cash On Delivery (COD)',
        ];

        return view('checkout.index', compact('cartItems', 'total', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'phone'            => 'required|string|max:20',
            'notes'            => 'nullable|string|max:500',
            'payment_method'   => 'required|in:bank_transfer,ovo,gopay,dana,cod',
            'ewallet_phone'    => 'nullable|required_if:payment_method,ovo,gopay,dana|string|max:20',
        ]);

        $cartItems = Cart::with(['product', 'variant'])
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang belanja kosong.');
        }

        // Cek stok semua produk
        foreach ($cartItems as $item) {
            $stock = $item->product_variant_id ? $item->variant->stock : $item->product->stock;
            if ($stock < $item->quantity) {
                $name = $item->product_variant_id 
                    ? "{$item->product->name} ({$item->variant_size})"
                    : $item->product->name;
                return back()->with('error', "Stok $name tidak mencukupi.");
            }
        }

        DB::transaction(function () use ($request, $cartItems) {
            $total = $cartItems->sum(function ($i) {
                if ($i->product_variant_id) {
                    return $i->quantity * $i->variant->price;
                }
                return $i->quantity * $i->product->discounted_price;
            });

            // Buat order
            $order = Order::create([
                'user_id'          => auth()->id(),
                'order_number'     => 'ORD-' . strtoupper(uniqid()),
                'total_amount'     => $total,
                'shipping_address' => $request->shipping_address,
                'phone'            => $request->phone,
                'notes'            => $request->notes,
                'status'           => 'waiting_payment',
                'payment_method'   => $request->payment_method,
            ]);

            // Buat order items & kurangi stok
            foreach ($cartItems as $item) {
                $price = $item->product_variant_id ? $item->variant->price : $item->product->discounted_price;
                
                OrderItem::create([
                    'order_id'            => $order->id,
                    'product_id'          => $item->product_id,
                    'product_variant_id'  => $item->product_variant_id,
                    'product_name'        => $item->product->name,
                    'variant_size'        => $item->variant_size,
                    'price'               => $price,
                    'quantity'            => $item->quantity,
                    'subtotal'            => $item->quantity * $price,
                ]);

                // Kurangi stok
                if ($item->product_variant_id) {
                    $item->variant->decrement('stock', $item->quantity);
                } else {
                    $item->product->decrement('stock', $item->quantity);
                }
            }

            // Buat payment record based on payment method
            $this->createPaymentRecord($order, $request->payment_method, $request->ewallet_phone);

            // Kosongkan cart
            Cart::where('user_id', auth()->id())->delete();

            session(['last_order_id' => $order->id]);
        });

        $orderId = session('last_order_id');

        return redirect()->route('payment.show', $orderId)
            ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }

    private function createPaymentRecord($order, $paymentMethod, $ewalletPhone = null)
    {
        $paymentData = [
            'order_id'       => $order->id,
            'payment_method' => $paymentMethod,
            'amount'         => $order->total_amount,
            'status'         => 'pending',
        ];

        // Add method-specific data
        if ($paymentMethod === 'bank_transfer') {
            $paymentData['recipient_name'] = 'FragrancesHub Store';
            $paymentData['recipient_account'] = '6801397384 (BCA)';
            $paymentData['payment_notes'] = "📋 INSTRUKSI TRANSFER BANK:\n\n" .
                "1. Buka aplikasi perbankan Anda (BCA, Mandiri, BNI, etc)\n" .
                "2. Pilih Transfer/Kirim Uang\n" .
                "3. Pilih Transfer Antar Bank\n" .
                "4. Masukkan Data:\n" .
                "   - Nomor Rekening: 6801397384\n" .
                "   - Atas Nama: FragrancesHub Store\n" .
                "   - Nominal: Rp " . number_format($order->total_amount, 0, ',', '.') . "\n" .
                "5. Konfirmasi dan selesaikan transfer\n" .
                "6. Simpan bukti transfer\n" .
                "7. Upload bukti di halaman pesanan Anda";
        } elseif (in_array($paymentMethod, ['ovo', 'gopay', 'dana'])) {
            $paymentData['phone_number'] = $ewalletPhone;
            $methodName = strtoupper($paymentMethod);
            $paymentData['payment_notes'] = "📱 INSTRUKSI PEMBAYARAN {$methodName}:\n\n" .
                "1. Buka aplikasi {$methodName} Anda\n" .
                "2. Pilih Menu Pembayaran/Transfer\n" .
                "3. Cari merchant 'FragrancesHub Store'\n" .
                "4. Masukkan Nominal: Rp " . number_format($order->total_amount, 0, ',', '.') . "\n" .
                "5. Masukkan PIN/Password Anda\n" .
                "6. Selesaikan pembayaran\n" .
                "7. Simpan bukti pembayaran\n" .
                "8. Upload bukti di halaman pesanan Anda";
        } elseif ($paymentMethod === 'cod') {
            $paymentData['payment_notes'] = "🚚 INSTRUKSI PEMBAYARAN COD (CASH ON DELIVERY):\n\n" .
                "1. Pesanan Anda akan dikemas dan disiapkan\n" .
                "2. Kurir kami akan menghubungi Anda untuk konfirmasi pengiriman\n" .
                "3. Barang akan dikirim ke alamat yang Anda berikan\n" .
                "4. Bayar langsung ke kurir saat barang tiba\n" .
                "5. Nominal: Rp " . number_format($order->total_amount, 0, ',', '.') . "\n" .
                "6. Pastikan uang pas atau siapkan kembalian";
        }

        Payment::create($paymentData);
    }
}
