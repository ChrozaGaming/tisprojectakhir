@extends('layouts.app')

@section('content')
<h2 class="mb-4">Your Shopping Cart</h2>

@if(empty($products))
    <div class="alert alert-info">
        Your cart is empty. <a href="{{ route('products.index') }}" class="alert-link">Continue shopping</a>.
    </div>
@else
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>
                                    <a href="{{ route('products.show', $product['id']) }}">{{ $product['name'] }}</a>
                                </td>
                                <td>Rp {{ number_format($product['price'], 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('cart.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $product['id'] }}">
                                        <input type="number" name="quantity" class="form-control form-control-sm" value="{{ $product['quantity'] }}" min="1" max="{{ $product['stock'] }}" style="width: 80px" onchange="this.form.submit()">
                                    </form>
                                </td>
                                <td>Rp {{ number_format($product['price'] * $product['quantity'], 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $product['id'] }}">
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Remove
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <div>
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left"></i> Continue Shopping
            </a>
            <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger">
                    <i class="fas fa-trash"></i> Clear Cart
                </button>
            </form>
        </div>
        <form action="{{ route('orders.checkout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">
                <i class="fas fa-credit-card"></i> Checkout
            </button>
        </form>
    </div>
@endif
@endsection