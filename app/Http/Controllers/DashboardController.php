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

        if (auth()->user()->role === 'admin') {
            return view('dashboard.admin', compact('totalCustomers', 'totalOrders', 'totalRevenue', 'recentCustomers', 'recentOrders'));
        }

        return view('dashboard.staff', compact('totalCustomers', 'totalOrders', 'totalRevenue', 'recentCustomers'));
    }
}
