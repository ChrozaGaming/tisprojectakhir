<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SalesOverviewController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = env('API_URL', 'http://localhost:8000/api');
    }

    public function index()
    {
        // Get orders for sales overview
        $response = Http::get("{$this->apiUrl}/orders");
        $orders = $response->json();
        
        // Calculate sales statistics
        $totalOrders = count($orders);
        $totalRevenue = array_sum(array_column($orders, 'total_price'));
        
        // Group orders by product to find top sellers
        $productSales = [];
        foreach ($orders as $order) {
            $productId = $order['product_id'];
            if (!isset($productSales[$productId])) {
                $productSales[$productId] = [
                    'product_id' => $productId,
                    'product_name' => $order['product']['name'],
                    'quantity' => 0,
                    'revenue' => 0
                ];
            }
            $productSales[$productId]['quantity'] += $order['quantity'];
            $productSales[$productId]['revenue'] += $order['total_price'];
        }
        
        // Sort by quantity to get top sellers
        usort($productSales, function($a, $b) {
            return $b['quantity'] <=> $a['quantity'];
        });
        
        // Monthly sales data for chart
        $monthlySales = [
            'Jan' => 0, 'Feb' => 0, 'Mar' => 0, 'Apr' => 0, 'May' => 0, 'Jun' => 0,
            'Jul' => 0, 'Aug' => 0, 'Sep' => 0, 'Oct' => 0, 'Nov' => 0, 'Dec' => 0
        ];
        
        foreach ($orders as $order) {
            $month = date('M', strtotime($order['created_at']));
            $monthlySales[$month] += $order['total_price'];
        }
        
        return view('reports.sales', compact('orders', 'totalOrders', 'totalRevenue', 'productSales', 'monthlySales'));
    }
}