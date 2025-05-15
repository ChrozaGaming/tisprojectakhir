<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .product-card {
            height: 100%;
            transition: transform 0.3s;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .cart-count {
            position: relative;
            top: -10px;
            right: 5px;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">E-commerce Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('orders.index') }}">My Orders</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <a href="{{ route('cart.index') }}" class="btn btn-outline-light">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="badge bg-danger cart-count">
                            {{ count(Session::get('cart', [])) }}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="mt-5 py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>E-commerce Store</h5>
                    <p>Your one-stop shop for all your needs.</p>
                </div>
                <div class="col-md-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('products.index') }}">Products</a></li>
                        <li><a href="{{ route('cart.index') }}">Cart</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Contact</h5>
                    <address>
                        <strong>E-commerce, Inc.</strong><br>
                        123 Shopping Street<br>
                        Jakarta, Indonesia<br>
                        <i class="fas fa-envelope"></i> info@ecommerce.com<br>
                        <i class="fas fa-phone"></i> +62 123 456 7890
                    </address>
                </div>
            </div>
            <hr>
            <p class="text-center">© 2023 E-commerce Store. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>