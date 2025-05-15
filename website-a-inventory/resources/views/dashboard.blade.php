@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Inventory Dashboard</h2>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <h5 class="card-title">Products Management</h5>
                        <p class="card-text">Manage your inventory products</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">Manage Products</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <h5 class="card-title">Stock Reports</h5>
                        <p class="card-text">View stock level reports</p>
                        <a href="/reports/stock" class="btn btn-secondary">View Reports</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <h5 class="card-title">Sales Overview</h5>
                        <p class="card-text">View sales activity</p>
                        <a href="/reports/sales" class="btn btn-info">View Sales</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection