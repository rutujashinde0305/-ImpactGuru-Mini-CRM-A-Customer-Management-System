<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function index()
    {
        $totalCustomers = Customer::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::sum('amount');
        $recentCustomers = Customer::latest()->take(5)->get();
        $recentOrders = Order::latest()->take(5)->get();
        $unreadNotifications = [];

        if (auth()->user()->role === 'admin') {
            $unreadNotifications = auth()->user()->unreadNotifications()->orderBy('created_at', 'desc')->take(5)->get();
            return view('dashboard.admin', compact('totalCustomers', 'totalOrders', 'totalRevenue', 'recentCustomers', 'recentOrders', 'unreadNotifications'));
        }

        return view('dashboard.staff', compact('totalCustomers', 'totalOrders', 'totalRevenue', 'recentCustomers'));
    }
}
