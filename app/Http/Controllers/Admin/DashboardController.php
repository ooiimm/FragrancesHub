<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;


class DashboardController extends Controller
{
    public function customers()
    {
        $q = request('q');

        $customersQuery = User::query()
            ->where('role', 'user');

        if (!empty($q)) {
            $customersQuery->where(function ($sub) use ($q) {
                $sub->where('name', 'like', '%' . $q . '%')
                    ->orWhere('email', 'like', '%' . $q . '%');
            });
        }

        $customers = $customersQuery
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }


    public function index()
    { 

        $stats = [
            'total_products'  => Product::count(),
            'total_orders'    => Order::count(),
            'total_users'     => User::where('role', 'user')->count(),
            'total_revenue'   => Order::whereIn('status', ['processing', 'shipped', 'delivered'])->sum('total_amount'),
            'pending_orders'  => Order::where('status', 'payment_uploaded')->count(),
        ];

        $recentOrders = Order::with('user')
            ->latest()
            ->limit(5)
            ->get();


        // Grafik penjualan per bulan (pakai total_amount dari order yang sudah selesai)
        // Ambil 12 bulan terakhir.
        $startMonth = now()->subMonths(11)->startOfMonth();
        $endMonth   = now()->endOfMonth();

        $monthlySalesRaw = Order::query()
            ->whereBetween('created_at', [$startMonth, $endMonth])
            ->whereIn('status', ['processing', 'shipped', 'delivered'])
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total_amount) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Susun agar selalu ada 12 titik (walau tidak ada transaksi di bulan tertentu)
        $monthlySales = [];
        $labels = [];
        for ($i = 0; $i < 12; $i++) {
            $dt = now()->subMonths(11 - $i);
            $key = $dt->format('Y-m');
            $labels[] = $dt->format('M Y');
            $monthlySales[$key] = 0;
        }

        foreach ($monthlySalesRaw as $row) {
            $monthlySales[$row->month] = (float) $row->total;
        }

        $monthlySalesSeries = array_values($monthlySales);

        return view('admin.dashboard', compact('stats', 'recentOrders', 'labels', 'monthlySalesSeries'));
    }
}
