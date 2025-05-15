@extends('layouts.app')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h3>Order #{{ $order['id'] }}</h3>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <h5>Order Details</h5>
                <p><strong>Date:</strong> {{ date('d M Y, H:i', strtotime($order['created_at'])) }}</p>
                <p>
                    <strong>Status:</strong> 
                    <span class="badge 
                        @if($order['status'] == 'completed') bg-success 
                        @elseif($order['status'] == 'processing') bg-primary 
                        @elseif($order['status'] == 'cancelled') bg-danger 
                        @else bg-warning @endif">
                        {{ ucfirst($order['status']) }}
                    </span>
                </p>
                <p><strong>Total:</strong> Rp {{ number_format($order['total_price'], 0, ',', '.') }}</p>
            </div>
            <div class="col-md-6">
                <h5>Product Information</h5>
                <p><strong>Product:</strong> {{ $order['product']['name'] }}</p>
                <p><strong>Unit Price:</strong> Rp {{ number_format($order['product']['price'], 0, ',', '.') }}</p>
                <p><strong>Quantity:</strong> {{ $order['quantity'] }}</p>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between">
    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back to Orders
    </a>
    <a href="{{ route('products.index') }}" class="btn btn-primary">
        <i class="fas fa-shopping-bag"></i> Continue Shopping
    </a>
</div>
@endsection