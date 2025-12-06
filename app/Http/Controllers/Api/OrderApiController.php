<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderApiController extends Controller
{
    /**
     * Display a paginated listing of orders
     */
    public function index(Request $request)
    {
        $query = Order::with('customer');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        return response()->json([
            'success' => true,
            'data' => $query->orderBy('order_date', 'desc')->paginate(15),
        ]);
    }

    /**
     * Display the specified order
     */
    public function show($id)
    {
        $order = Order::with('customer')->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    /**
     * Store a newly created order
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

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'data' => $order,
        ], 201);
    }

    /**
     * Update the specified order (Admin only)
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

        return response()->json([
            'success' => true,
            'message' => 'Order updated successfully',
            'data' => $order,
        ]);
    }

    /**
     * Delete the specified order (Admin only)
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order deleted successfully',
        ]);
    }
}
