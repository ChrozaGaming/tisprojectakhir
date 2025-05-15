@extends('layouts.app')

@section('content')
<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <h2>{{ $product['name'] }}</h2>
                <p class="text-muted">Product ID: {{ $product['id'] }}</p>
                <hr>
                <h5>Description</h5>
                <p>{{ $product['description'] }}</p>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="text-primary">Rp {{ number_format($product['price'], 0, ',', '.') }}</h4>
                    <span class="badge {{ $product['stock'] > 0 ? 'bg-success' : 'bg-danger' }} p-2">
                        {{ $product['stock'] > 0 ? $product['stock'].' in Stock' : 'Out of Stock' }}
                    </span>
                </div>
                
                @if($product['stock'] > 0)
                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $product['id'] }}">
                        <div class="row g-3 align-items-center mb-3">
                            <div class="col-auto">
                                <label for="quantity" class="col-form-label">Quantity:</label>
                            </div>
                            <div class="col-auto">
                                <input type="number" id="quantity" name="quantity" class="form-control" min="1" max="{{ $product['stock'] }}" value="1">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <button class="btn btn-secondary" disabled>Out of Stock</button>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between mb-4">
    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back to Products
    </a>
</div>
@endsection