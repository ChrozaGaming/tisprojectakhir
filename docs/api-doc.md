📘 DOCUMENTATION: API ROUTES & ENDPOINT FLOW

===============================
🔗 *Database Central (Lumen API)*
===============================

📁 File: `routes/web.php` (Lumen)

```php
$router->get('/', function () use ($router) {
    return $router->app->version();
});

// 🛒 Product Routes
$router->group(['prefix' => 'api/products'], function () use ($router) {
    $router->get('/', 'ProductController@index');         // 🔍 Get all products
    $router->post('/', 'ProductController@store');        // ➕ Create product
    $router->get('/{id}', 'ProductController@show');      // 🔎 Get single product
    $router->put('/{id}', 'ProductController@update');    // ✏️ Update product
    $router->patch('/{id}/stock', 'ProductController@updateStock'); // 🔄 Update stock
    $router->delete('/{id}', 'ProductController@destroy');          // ❌ Delete product
});

// 📦 Order Routes
$router->group(['prefix' => 'api/orders'], function () use ($router) {
    $router->get('/', 'OrderController@index');              // 📋 List orders
    $router->post('/', 'OrderController@store');             // 🛒 Place order
    $router->get('/{id}', 'OrderController@show');           // 🔍 Order detail
    $router->patch('/{id}/status', 'OrderController@updateStatus'); // 🔁 Update status
});
```

===============================
🧮 *Website A (Inventori Admin)*
===============================

📁 File: `routes/web.php` (Laravel)

```php
// 🏠 Dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// 📦 Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::patch('/products/{id}/stock', [ProductController::class, 'updateStock'])->name('products.update-stock');
Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');

// 📊 Report Routes
Route::get('/reports/stock', [StockReportController::class, 'index'])->name('reports.stock');
Route::get('/reports/sales', [SalesOverviewController::class, 'index'])->name('reports.sales');
```

===============================
🛍️ *Website B (E-Commerce Front)*
===============================

📁 File: `routes/web.php` (Laravel)

```php
// 🏠 Home Page
Route::get('/', function () {
    return view('home');
})->name('home');

// 🛒 Product Routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// 🛍️ Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// 📦 Order Routes
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
Route::post('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
```

📌 Semua endpoint ini terintegrasi melalui API Lumen sebagai middleware REST untuk sinkronisasi data real-time antara sistem Inventori (Admin) dan E-Commerce (User).