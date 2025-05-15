<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\StockMovement;

class StockReportController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('API_URL', 'http://localhost:8000/api');
    }

    public function index()
    {
        // Get products for stock report
        $response = Http::get("{$this->apiUrl}/products");
        $products = $response->json();
        
        // Calculate stock statistics
        $totalProducts = count($products);
        $totalItems = array_sum(array_column($products, 'stock'));
        $lowStockThreshold = 5;
        $lowStockProducts = array_filter($products, function($product) use ($lowStockThreshold) {
            return $product['stock'] <= $lowStockThreshold;
        });
        
        // Get real stock movements from database
        $stockMovements = StockMovement::with('product')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function($movement) {
                return [
                    'product_id' => $movement->product_id,
                    'product_name' => $movement->product->name,
                    'previous_stock' => $movement->previous_stock,
                    'current_stock' => $movement->current_stock,
                    'changed_by' => $movement->current_stock - $movement->previous_stock,
                    'date' => $movement->created_at->format('Y-m-d H:i:s'),
                    'type' => $movement->type
                ];
            });
        
        return view('reports.stock', compact('products', 'totalProducts', 'totalItems', 'lowStockProducts', 'lowStockThreshold', 'stockMovements'));
    }
}