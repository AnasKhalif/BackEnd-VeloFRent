<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Get all orders
        $orders = Order::all();

        // Return a response
        return response()->json([
            'orders' => $orders
        ], 200);
    }


    public function store(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'motor_name' => 'required|string',
            'pickup_option' => 'required|string',
            'total_payment' => 'required|numeric',
        ]);

        // Create a new order
        $order = Order::create($validated);

        // Return a response
        return response()->json([
            'message' => 'Order successfully created!',
            'order' => $order
        ], 201);
    }
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update([
            'pickup_option' => $request->pickup_option,
        ]);

        return response()->json(['message' => 'Order updated successfully'], 200);
    }

    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }
}
