<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('API_URL', 'http://localhost:8000/api');
    }

    public function index()
    {
        $cart = Session::get('cart', []);
        $products = [];
        $total = 0;
        
        foreach ($cart as $id => $details) {
            $response = Http::get("{$this->apiUrl}/products/{$id}");
            if ($response->successful()) {
                $product = $response->json();
                $product['quantity'] = $details['quantity'];
                $products[] = $product;
                $total += $product['price'] * $details['quantity'];
            }
        }
        
        return view('cart.index', compact('products', 'total'));
    }

    public function add(Request $request)
    {
        $id = $request->id;
        $quantity = $request->quantity ?? 1;
        
        // Check product existence and stock
        $response = Http::get("{$this->apiUrl}/products/{$id}");
        if (!$response->successful()) {
            return back()->with('error', 'Product not found');
        }
        
        $product = $response->json();
        if ($product['stock'] < $quantity) {
            return back()->with('error', 'Not enough stock available');
        }
        
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'quantity' => $quantity
            ];
        }
        
        Session::put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Product added to cart');
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = Session::get('cart');
            $cart[$request->id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
        }
        
        return redirect()->route('cart.index')->with('success', 'Cart updated');
    }

    public function remove(Request $request)
    {
        if ($request->id) {
            $cart = Session::get('cart');
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                Session::put('cart', $cart);
            }
        }
        
        return redirect()->route('cart.index')->with('success', 'Product removed from cart');
    }

    public function clear()
    {
        Session::forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared');
    }
}