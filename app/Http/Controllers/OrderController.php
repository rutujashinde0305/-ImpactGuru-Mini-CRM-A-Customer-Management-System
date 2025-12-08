<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders with filtering and pagination
     */
    public function index(Request $request)
    {
        $orders = Order::when($request->status, function($q) use ($request) {
                $q->where('status', $request->status);
            })
            ->with('customer')
            ->orderBy('order_date', 'desc')
            ->paginate(10);

        $statuses = ['Pending', 'Completed', 'Cancelled'];

        return view('orders.index', compact('orders', 'statuses'));
    }

    /**
     * Show the form for creating a new order
     */
    public function create()
    {
        $customers = \App\Models\Customer::pluck('name', 'id');
        return view('orders.create', compact('customers'));
    }

    /**
     * Store a newly created order in storage and send notification
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_number' => 'required|string|unique:orders,order_number',
            'amount' => 'required|numeric|min:0.01',
            'status' => 'required|in:Pending,Completed,Cancelled',
            'order_date' => 'required|date',
        ]);

        $order = Order::create($validated);

        // Notify all admins about the new order (include creator)
        $creator = auth()->user();
        User::where('role', 'admin')->get()->each(function($admin) use ($order, $creator) {
            $admin->notify(new NewOrderNotification($order, $creator, 'created'));
        });

        return redirect()->route('orders.index')->with('success', 'Order created successfully');
    }

    /**
     * Display the specified order
     */
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order
     */
    public function edit(Order $order)
    {
        $customers = \App\Models\Customer::pluck('name', 'id');
        return view('orders.edit', compact('order', 'customers'));
    }

    /**
     * Update the specified order in storage
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_number' => 'required|string|unique:orders,order_number,' . $order->id,
            'amount' => 'required|numeric|min:0.01',
            'status' => 'required|in:Pending,Completed,Cancelled',
            'order_date' => 'required|date',
        ]);

        $order->update($validated);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully');
    }

    /**
     * Remove the specified order from storage
     */
    public function destroy(Order $order)
    {
        $order->delete();

        // Notify admins about deletion
        $creator = auth()->user();
        User::where('role', 'admin')->get()->each(function($admin) use ($order, $creator) {
            $admin->notify(new NewOrderNotification($order, $creator, 'deleted'));
        });

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully');
    }

    /**
     * Export orders to CSV
     */
    public function exportCsv()
    {
        $fileName = 'orders_' . date('Ymd_His') . '.csv';
        $orders = Order::with('customer')->orderBy('order_date', 'desc')->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $columns = ['id', 'order_number', 'customer_name', 'amount', 'status', 'order_date'];

        $callback = function() use ($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id,
                    $order->order_number,
                    $order->customer->name,
                    $order->amount,
                    $order->status,
                    $order->order_date,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export orders to PDF
     */
    public function exportPdf()
    {
        $orders = Order::with('customer')->orderBy('order_date', 'desc')->get();
        $pdf = \PDF::loadView('orders.pdf', compact('orders'));
        return $pdf->download('orders_' . date('Ymd_His') . '.pdf');
    }
}
