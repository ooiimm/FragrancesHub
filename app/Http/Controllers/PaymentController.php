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
        $order->load('payment', 'orderItems.variant');

        // Prepare payment instruction based on payment method
        $paymentInstructions = $this->getPaymentInstructions($order);
        $dummyQr = $this->getDummyQrData($order);

        return view('payment.show', compact('order', 'paymentInstructions', 'dummyQr'));
    }

    public function upload(Request $request, Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        // Only bank transfer and e-wallet require proof upload
        $allowedMethods = ['bank_transfer', 'ovo', 'gopay', 'dana'];
        if (!in_array($order->payment_method, $allowedMethods)) {
            return back()->with('error', 'Metode pembayaran ini tidak memerlukan bukti upload.');
        }

        $request->validate([
            'proof_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('proof_image')->store('payments');

        $order->payment->update([
            'proof_image' => $path,
            'status'      => 'pending',
        ]);

        $order->update(['status' => 'payment_uploaded']);

        return redirect()->route('payment.show', $order->id)
            ->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
    }

    private function getPaymentInstructions($order)
    {
        return match ($order->payment_method) {
            'bank_transfer' => [
                'title' => 'Transfer Bank',
                'icon' => '🏦',
                'steps' => [
                    'Buka aplikasi perbankan Anda (BCA, Mandiri, BNI, dll)',
                    'Pilih menu Transfer Antar Bank',
                    'Masukkan nomor rekening: 6801397384',
                    'Atas nama: FragrancesHub Store',
                    'Jumlah transfer: Rp ' . number_format($order->total_amount, 0, ',', '.'),
                    'Upload bukti transfer di form dibawah',
                ],
            ],
            'ovo' => [
                'title' => 'OVO',
                'icon' => '📱',
                'steps' => [
                    'Buka aplikasi OVO Anda',
                    'Pilih menu "Bayar/Top Up"',
                    'Cari merchant "FragrancesHub Store"',
                    'Masukkan jumlah: Rp ' . number_format($order->total_amount, 0, ',', '.'),
                    'Selesaikan transaksi',
                    'Upload bukti pembayaran di form dibawah',
                ],
            ],
            'gopay' => [
                'title' => 'GoPay',
                'icon' => '📱',
                'steps' => [
                    'Buka aplikasi GoPay',
                    'Pilih "Pembayaran"',
                    'Cari merchant "FragrancesHub Store"',
                    'Masukkan jumlah: Rp ' . number_format($order->total_amount, 0, ',', '.'),
                    'Masukkan PIN GoPay',
                    'Upload bukti pembayaran di form dibawah',
                ],
            ],
            'dana' => [
                'title' => 'Dana',
                'icon' => '📱',
                'steps' => [
                    'Buka aplikasi Dana Anda',
                    'Pilih menu "Pembayaran"',
                    'Cari "FragrancesHub Store"',
                    'Masukkan jumlah: Rp ' . number_format($order->total_amount, 0, ',', '.'),
                    'Konfirmasi dan selesaikan pembayaran',
                    'Upload bukti pembayaran di form dibawah',
                ],
            ],
            'cod' => [
                'title' => 'Cash On Delivery (COD)',
                'icon' => '🚚',
                'steps' => [
                    'Pesanan Anda telah dikonfirmasi!',
                    'Barang akan dikirim ke alamat pengiriman Anda',
                    'Bayar tunai kepada kurir saat barang sampai',
                    'Jumlah pembayaran: Rp ' . number_format($order->total_amount, 0, ',', '.'),
                    'Pastikan jumlah uang pas saat membayar',
                ],
            ],
            default => [
                'title' => 'Pembayaran',
                'icon' => '💳',
                'steps' => ['Menunggu instruksi pembayaran...'],
            ],
        };
    }

    private function getDummyQrData(Order $order): ?array
    {
        if ($order->payment_method === 'cod') {
            return null;
        }

        $payload = implode('|', [
            'FRAGRANCESHUB-DUMMY-PAYMENT',
            $order->order_number,
            strtoupper($order->payment_method),
            (int) $order->total_amount,
        ]);

        return [
            'merchant' => 'FragrancesHub Store',
            'reference' => $order->order_number,
            'amount' => $order->formatted_total,
            'method' => $order->payment_method_label,
            'payload' => $payload,
            'matrix' => $this->makeDummyQrMatrix($payload),
        ];
    }

    private function makeDummyQrMatrix(string $payload): array
    {
        $size = 21;
        $matrix = array_fill(0, $size, array_fill(0, $size, false));
        $finderOrigins = [[0, 0], [14, 0], [0, 14]];

        foreach ($finderOrigins as [$originX, $originY]) {
            for ($y = 0; $y < 7; $y++) {
                for ($x = 0; $x < 7; $x++) {
                    $isBorder = $x === 0 || $x === 6 || $y === 0 || $y === 6;
                    $isCenter = $x >= 2 && $x <= 4 && $y >= 2 && $y <= 4;
                    $matrix[$originY + $y][$originX + $x] = $isBorder || $isCenter;
                }
            }
        }

        $hash = hash('sha256', $payload);
        $hashLength = strlen($hash);

        for ($y = 0; $y < $size; $y++) {
            for ($x = 0; $x < $size; $x++) {
                if ($this->isInsideFinder($x, $y)) {
                    continue;
                }

                $position = ($x + ($y * $size)) % $hashLength;
                $value = hexdec($hash[$position]);
                $matrix[$y][$x] = (($value + $x + $y) % 3) !== 0;
            }
        }

        return $matrix;
    }

    private function isInsideFinder(int $x, int $y): bool
    {
        return ($x <= 6 && $y <= 6)
            || ($x >= 14 && $y <= 6)
            || ($x <= 6 && $y >= 14);
    }
}
