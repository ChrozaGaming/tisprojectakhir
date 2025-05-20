<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('API_URL', 'http://localhost:8000/api');
    }

    public function index()
    {
        $response = Http::get("{$this->apiUrl}/products");
        $products = $response->json();

        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $response = Http::get("{$this->apiUrl}/products/{$id}");

        if ($response->successful()) {
            $product = $response->json();
            return view('products.show', compact('product'));
        }

        return redirect()->route('products.index')->with('error', 'Product not found');
    }
}
