<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockReportController;
use App\Http\Controllers\SalesOverviewController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::patch('/products/{id}/stock', [ProductController::class, 'updateStock'])->name('products.update-stock');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

// Report Routes
Route::get('/reports/stock', [StockReportController::class, 'index'])->name('reports.stock');
Route::get('/reports/sales', [SalesOverviewController::class, 'index'])->name('reports.sales');