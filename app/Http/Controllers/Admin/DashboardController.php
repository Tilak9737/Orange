<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Wishlist;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total');
        $totalOrders = Order::count();
        $totalUsers = User::where('role', 'customer')->count();
        $totalProducts = Product::count();
        $totalWishlist = Wishlist::count();

        $recentOrders = Order::with('user')->latest()->take(5)->get();

        // Chart Data (Last 7 Days)
        $chartData = [];
        $chartLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartLabels[] = $date->format('M d');
            $chartData[] = Order::whereDate('created_at', $date)
                ->where('status', '!=', 'cancelled')
                ->sum('total');
        }

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'totalUsers',
            'totalProducts',
            'totalWishlist',
            'recentOrders',
            'chartLabels',
            'chartData'
        ));
    }
}
