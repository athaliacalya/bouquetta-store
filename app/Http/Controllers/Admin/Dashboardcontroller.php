<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Flower;
use App\Models\Subscriber;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_orders'      => Order::count(),
            'pending_orders'    => Order::where('status', 'pending')->count(),
            'total_revenue'     => Order::where('payment_status', 'paid')->sum('total'),
            'total_users'       => User::where('role', 'customer')->count(),
            'total_flowers'     => Flower::count(),
            'total_subscribers' => Subscriber::where('is_active', true)->count(),
        ];

        $recentOrders = Order::latest()->limit(8)->get();

        // MySQL-compatible monthly revenue (current year)
        $monthlyRevenue = Order::where('payment_status', 'paid')
            ->whereYear('created_at', now()->year)
            ->selectRaw('MONTH(created_at) as month, SUM(total) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        return view('admin.dashboard', compact('stats', 'recentOrders', 'monthlyRevenue'));
    }
}
