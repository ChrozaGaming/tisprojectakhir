<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(Order::with('product')->get());
    }

    public function show($id)
    {
        return response()->json(Order::with('product')->findOrFail($id));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Check if stock is available
        if ($product->stock < $request->quantity) {
            return response()->json(['message' => 'Not enough stock available'], 400);
        }
        
        // Calculate total price
        $totalPrice = $product->price * $request->quantity;
        
        // Create order
        $order = Order::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);
        
        // Update product stock
        $product->stock -= $request->quantity;
        $product->save();
        
        return response()->json($order, 201);
    }

    public function updateStatus($id, Request $request)
    {
        $this->validate($request, [
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        
        return response()->json(['message' => 'Order status updated', 'order' => $order]);
    }
}