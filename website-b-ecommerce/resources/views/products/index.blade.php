@extends('layouts.app')

@section('content')
<h2 class="mb-4">Our Products</h2>

<div class="row">
    @if(empty($products))
        <div class="col-12">
            <div class="alert alert-info">No products available at the moment.</div>
        </div>
    @else
        @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card product-card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product['name'] }}</h5>
                        <p class="card-text">{{ \Illuminate\Support\Str::limit($product['description'], 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-primary fw-bold">Rp {{ number_format($product['price'], 0, ',', '.') }}</span>
                            <span class="badge {{ $product['stock'] > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $product['stock'] > 0 ? 'In Stock' : 'Out of Stock' }}
                            </span>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-top-0 d-flex justify-content-between">
                        <a href="{{ route('products.show', $product['id']) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                        @if($product['stock'] > 0)
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product['id'] }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fas fa-cart-plus"></i> Add to Cart
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection