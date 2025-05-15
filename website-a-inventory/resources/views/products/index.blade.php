@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Products Inventory</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary">Add New Product</a>
</div>

<div class="card">
    <div class="card-body">
        @if(empty($products))
            <div class="alert alert-info">No products found.</div>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product['id'] }}</td>
                                <td>{{ $product['name'] }}</td>
                                <td>Rp {{ number_format($product['price'], 0, ',', '.') }}</td>
                                <td>
                                    @if($product['stock'] <= 5)
                                        <span class="badge bg-danger">{{ $product['stock'] }}</span>
                                    @elseif($product['stock'] <= 10)
                                        <span class="badge bg-warning">{{ $product['stock'] }}</span>
                                    @else
                                        <span class="badge bg-success">{{ $product['stock'] }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('products.show', $product['id']) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('products.edit', $product['id']) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('products.destroy', $product['id']) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection