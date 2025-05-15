<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(Product::all());
    }

    public function show($id)
    {
        return response()->json(Product::findOrFail($id));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer'
        ]);

        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return response()->json($product, 200);
    }

    public function updateStock($id, Request $request)
    {
        $this->validate($request, [
            'stock' => 'required|integer'
        ]);

        $product = Product::findOrFail($id);
        $product->stock = $request->stock;
        $product->save();
        
        return response()->json(['message' => 'Stock updated successfully', 'product' => $product]);
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }
}