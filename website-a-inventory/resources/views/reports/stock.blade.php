@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Stock Reports</h1>

    <!-- Stock Overview Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Products</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProducts }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Items in Stock</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalItems }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-warehouse fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Low Stock Items</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($lowStockProducts) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Stock Health</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                        {{ $totalItems > 0 ? round(100 - (count($lowStockProducts) / $totalProducts * 100)) : 0 }}%
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: {{ $totalItems > 0 ? round(100 - (count($lowStockProducts) / $totalProducts * 100)) : 0 }}%">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Low Stock Alerts -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Low Stock Alerts</h6>
        </div>
        <div class="card-body">
            @if(count($lowStockProducts) > 0)
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Name</th>
                            <th>Current Stock</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lowStockProducts as $product)
                        <tr>
                            <td>{{ $product['id'] }}</td>
                            <td>{{ $product['name'] }}</td>
                            <td>{{ $product['stock'] }}</td>
                            <td>
                                @if($product['stock'] <= 2)
                                    <span class="badge badge-danger">Critical</span>
                                    @else
                                    <span class="badge badge-warning">Low</span>
                                    @endif
                            </td>
                            <td>
                                <a href="{{ route('products.edit', $product['id']) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Update Stock
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="alert alert-success">
                All products have adequate stock levels (more than {{ $lowStockThreshold }} items).
            </div>
            @endif
        </div>
    </div>

    <!-- Stock Movement History -->
    {{-- <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Recent Stock Movements</h6>
        </div>
        <div class="card-body">
            <!-- In your stock movements table -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Previous Stock</th>
                            <th>Current Stock</th>
                            <th>Change</th>
                            <th>Type</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stockMovements as $movement)
                        <tr>
                            <td>{{ $movement['product_name'] }}</td>
                            <td>{{ $movement['previous_stock'] }}</td>
                            <td>{{ $movement['current_stock'] }}</td>
                            <td class="{{ $movement['changed_by'] > 0 ? 'text-success' : 'text-danger' }}">
                                {{ $movement['changed_by'] > 0 ? '+' : '' }}{{ $movement['changed_by'] }}
                            </td>
                            <td>
                                @if($movement['type'] == 'addition')
                                <span class="badge badge-success">Addition</span>
                                @else
                                <span class="badge badge-danger">Reduction</span>
                                @endif
                            </td>
                            <td>{{ $movement['date'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No stock movements recorded yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}

    <!-- Current Inventory -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Complete Inventory</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Current Stock</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product['id'] }}</td>
                            <td>{{ $product['name'] }}</td>
                            <td>{{ $product['description'] }}</td>
                            <td>Rp {{ number_format($product['price'], 0, ',', '.') }}</td>
                            <td>{{ $product['stock'] }}</td>
                            <td>
                                @if($product['stock'] <= 2)
                                    <span class="badge badge-danger">Critical</span>
                                    @elseif($product['stock'] <= $lowStockThreshold)
                                        <span class="badge badge-warning">Low</span>
                                        @else
                                        <span class="badge badge-success">Adequate</span>
                                        @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection