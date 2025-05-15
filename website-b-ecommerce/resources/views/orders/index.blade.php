@extends('layouts.app')

@section('content')
<h2 class="mb-4">Your Orders</h2>

@if(empty($orders))
    <div class="alert alert-info">
        You haven't placed any orders yet. <a href="{{ route('products.index') }}" class="alert-link">Start shopping</a>.
    </div>
@else
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order['id'] }}</td>
                        <td>{{ $order['product']['name'] }}</td>
                        <td>{{ $order['quantity'] }}</td>
                        <td>Rp {{ number_format($order['total_price'], 0, ',', '.') }}</td>
                        <td>
                            <span class="badge 
                                @if($order['status'] == 'completed') bg-success 
                                @elseif($order['status'] == 'processing') bg-primary 
                                @elseif($order['status'] == 'cancelled') bg-danger 
                                @else bg-warning @endif">
                                {{ ucfirst($order['status']) }}
                            </span>
                        </td>
                        <td>{{ date('d M Y, H:i', strtotime($order['created_at'])) }}</td>
                        <td>
                            <a href="{{ route('orders.show', $order['id']) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection