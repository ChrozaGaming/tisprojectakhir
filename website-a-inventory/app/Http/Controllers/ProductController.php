<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use App\Models\StockMovement;

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

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer'
        ]);

        $response = Http::post("{$this->apiUrl}/products", [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock
        ]);

        if ($response->successful()) {
            return redirect()->route('products.index')->with('success', 'Product created successfully');
        }

        return back()->with('error', 'Failed to create product');
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

    public function edit($id)
    {
        $response = Http::get("{$this->apiUrl}/products/{$id}");

        if ($response->successful()) {
            $product = $response->json();
            return view('products.edit', compact('product'));
        }

        return redirect()->route('products.index')->with('error', 'Product not found');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer'
        ]);

        $response = Http::put("{$this->apiUrl}/products/{$id}", [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock
        ]);

        if ($response->successful()) {
            return redirect()->route('products.index')->with('success', 'Product updated successfully');
        }

        return back()->with('error', 'Failed to update product');
    }

    // In the updateStock method
    public function updateStock(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $previousStock = $product->stock;

        // Update the stock
        $product->stock = $request->stock;
        $product->save();

        // Create stock movement record
        StockMovement::create([
            'product_id' => $product->id,
            'previous_stock' => $previousStock,
            'current_stock' => $product->stock,
            'type' => $product->stock > $previousStock ? 'addition' : 'reduction',
            'notes' => $request->notes ?? 'Stock manually updated'
        ]);

        return redirect()->back()->with('success', 'Stock updated successfully');
    }

    public function destroy($id)
    {
        $response = Http::delete("{$this->apiUrl}/products/{$id}");

        if ($response->successful()) {
            return redirect()->route('products.index')->with('success', 'Product deleted successfully');
        }

        return back()->with('error', 'Failed to delete product');
    }
}
