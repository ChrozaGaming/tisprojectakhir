@extends('layouts.app')

@section('content')
<div class="jumbotron p-5 mb-4 bg-light rounded-3">
    <div class="container">
        <h1 class="display-4">Welcome to E-commerce Store</h1>
        <p class="lead">Find the best products at the best prices.</p>
        <hr class="my-4">
        <p>Browse our extensive catalog of products or search for something specific.</p>
        <a class="btn btn-primary btn-lg" href="{{ route('products.index') }}" role="button">Shop Now</a>
    </div>
</div>

<div class="row mb-5">
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-truck fa-3x mb-3 text-primary"></i>
                <h5 class="card-title">Fast Delivery</h5>
                <p class="card-text">We deliver your orders as quickly as possible.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-shield-alt fa-3x mb-3 text-primary"></i>
                <h5 class="card-title">Secure Payments</h5>
                <p class="card-text">Your payment information is always secure with us.</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body text-center">
                <i class="fas fa-headset fa-3x mb-3 text-primary"></i>
                <h5 class="card-title">24/7 Support</h5>
                <p class="card-text">Our customer service team is always ready to help you.</p>
            </div>
        </div>
    </div>
</div>
@endsection