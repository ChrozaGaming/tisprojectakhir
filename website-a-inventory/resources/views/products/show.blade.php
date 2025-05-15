@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Product Details</h3>
        <div>
            <a href="{{ route('products.edit', $product['id']) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h4>{{ $product['name'] }}</h4>
                <p>{{ $product['description'] }}</p>
                <p><strong>Price:</strong> Rp {{ number_format($product['price'], 0, ',', '.') }}</p>
                <p>
                    <strong>Stock:</strong> 
                    @if($product['stock'] <= 5)
                        <span class="badge bg-danger">{{ $product['stock'] }} units</span>
                    @elseif($product['stock'] <= 10)
                        <span class="badge bg-warning">{{ $product['stock'] }} units</span>
                    @else
                        <span class="badge bg-success">{{ $product['stock'] }} units</span>
                    @endif
                </p>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Update Stock</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('products.update-stock', $product['id']) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label for="stock" class="form-label">New Stock Quantity</label>
                                <input type="number" class="form-control" id="stock" name="stock" value="{{ $product['stock'] }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Stock</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection