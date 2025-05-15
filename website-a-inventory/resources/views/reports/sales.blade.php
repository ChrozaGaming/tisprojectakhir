@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Sales Overview</h1>
    
    <!-- Sales Overview Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Orders</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalOrders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
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
                                Total Revenue</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                                Average Order Value</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ $totalOrders > 0 ? number_format($totalRevenue / $totalOrders, 0, ',', '.') : 0 }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
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
                                Processing Orders</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ count(array_filter($orders, function($order) { return $order['status'] == 'processing'; })) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-spinner fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Chart -->
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Monthly Revenue Overview</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="monthlySalesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Selling Products -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top Selling Products</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="productSalesChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        @foreach(array_slice($productSales, 0, 5) as $index => $product)
                            <span class="mr-2">
                                <i class="fas fa-circle" style="color: {{ ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'][$index % 5] }}"></i> {{ $product['product_name'] }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Recent Orders</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(array_slice($orders, 0, 10) as $order)
                            <tr>
                                <td>{{ $order['id'] }}</td>
                                <td>{{ $order['product']['name'] }}</td>
                                <td>{{ $order['quantity'] }}</td>
                                <td>Rp {{ number_format($order['total_price'], 0, ',', '.') }}</td>
                                <td>
                                    @if($order['status'] == 'completed')
                                        <span class="badge badge-success">Completed</span>
                                    @elseif($order['status'] == 'processing')
                                        <span class="badge badge-primary">Processing</span>
                                    @elseif($order['status'] == 'cancelled')
                                        <span class="badge badge-danger">Cancelled</span>
                                    @else
                                        <span class="badge badge-secondary">{{ ucfirst($order['status']) }}</span>
                                    @endif
                                </td>
                                <td>{{ date('d M Y, H:i', strtotime($order['created_at'])) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Top Selling Products Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Product Sales Breakdown</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Units Sold</th>
                            <th>Revenue</th>
                            <th>% of Total Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productSales as $product)
                            <tr>
                                <td>{{ $product['product_id'] }}</td>
                                <td>{{ $product['product_name'] }}</td>
                                <td>{{ $product['quantity'] }}</td>
                                <td>Rp {{ number_format($product['revenue'], 0, ',', '.') }}</td>
                                <td>
                                    {{ $totalRevenue > 0 ? round(($product['revenue'] / $totalRevenue) * 100, 2) : 0 }}%
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

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Monthly Sales Chart
    var ctx = document.getElementById("monthlySalesChart");
    var monthlySalesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                @foreach($monthlySales as $month => $value) 
                    "{{ $month }}"@if(!$loop->last),@endif
                @endforeach
            ],
            datasets: [{
                label: "Revenue",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: [
                    @foreach($monthlySales as $value) 
                        {{ $value }}@if(!$loop->last),@endif
                    @endforeach
                ]
            }]
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                },
                y: {
                    ticks: {
                        beginAtZero: true,
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Revenue: Rp ' + context.parsed.y.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

    // Product Sales Pie Chart
    var ctx2 = document.getElementById("productSalesChart");
    var productSalesChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: [
                @foreach(array_slice($productSales, 0, 5) as $product) 
                    "{{ $product['product_name'] }}"@if(!$loop->last),@endif
                @endforeach
            ],
            datasets: [{
                data: [
                    @foreach(array_slice($productSales, 0, 5) as $product) 
                        {{ $product['quantity'] }}@if(!$loop->last),@endif
                    @endforeach
                ],
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#dda20a', '#be2617'],
                hoverBorderColor: "rgba(234, 236, 244, 1)"
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.label + ': ' + context.parsed + ' units';
                        }
                    }
                }
            },
            cutout: '70%'
        }
    });
</script>
@endsection