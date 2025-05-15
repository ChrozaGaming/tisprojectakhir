<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('API_URL', 'http://localhost:8000/api');
    }

    public function index()
    {
        $response = Http::get("{$this->apiUrl}/orders");
        $orders = $response->json();
        
        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $response = Http::get("{$this->apiUrl}/orders/{$id}");
        
        if ($response->successful()) {
            $order = $response->json();
            return view('orders.show', compact('order'));
        }
        
        return redirect()->route('orders.index')->with('error', 'Order not found');
    }

    public function checkout()
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }
        
        // Process each cart item as a separate order
        $orders = [];
        $errors = [];
        
        foreach ($cart as $id => $details) {
            $response = Http::post("{$this->apiUrl}/orders", [
                'product_id' => $id,
                'quantity' => $details['quantity']
            ]);
            
            if ($response->successful()) {
                $orders[] = $response->json();
            } else {
                $errors[] = "Failed to process order for product ID: {$id}";
            }
        }
        
        // Clear cart if at least one order was successful
        if (!empty($orders)) {
            Session::forget('cart');
            return redirect()->route('orders.index')->with('success', 'Order placed successfully');
        }
        
        return redirect()->route('cart.index')->with('error', implode(', ', $errors));
    }
}