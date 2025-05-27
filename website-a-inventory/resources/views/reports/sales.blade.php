@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Sales Overview</h1>

    <!-- Sales Overview Cards -->
    <div class="row">
        <!-- Total Orders -->
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

        <!-- Total Revenue -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Revenue</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average Order Value -->
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

        <!-- Processing Orders -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Processing Orders</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ count(array_filter($orders, fn($o) => $o['status'] === 'processing')) }}
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

    <!-- Sales Chart + Leaderboard -->
    <div class="row">
        <!-- Monthly Revenue Line Chart -->
        {{-- <div class="col-xl-8 col-lg-7">
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
        </div> --}}

        <!-- Top Selling Products Leaderboard -->
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top Selling Products (Leaderboard)</h6>
                </div>
                <div class="card-body">
                    @php
                        $totalUnits = array_sum(array_column($productSales, 'quantity'));
                    @endphp
                    <ul class="list-group list-group-flush">
                        @foreach(array_slice($productSales, 0, 5) as $index => $product)
                            @php
                                $percent = $totalUnits > 0 ? round($product['quantity'] / $totalUnits * 100, 1) : 0;
                                $badgeColors = ['primary', 'success', 'info', 'warning', 'danger'];
                            @endphp
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="badge badge-{{ $badgeColors[$index % 5] }} badge-pill mr-2">
                                            {{ $index + 1 }}
                                        </span>
                                        <strong>{{ $product['product_name'] }}</strong>
                                    </div>
                                    <span class="font-weight-bold">{{ $product['quantity'] }} sold</span>
                                </div>
                                <div class="progress mt-2" style="height: 6px;">
                                    <div class="progress-bar bg-{{ $badgeColors[$index % 5] }}"
                                         role="progressbar"
                                         style="width: {{ $percent }}%;"
                                         aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
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
                            <th>Order&nbsp;ID</th>
                            <th>Product</th>
                            <th>Qty</th>
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
                                    @switch($order['status'])
                                        @case('completed')
                                            <span class="badge badge-success">Completed</span>
                                            @break
                                        @case('processing')
                                            <span class="badge badge-primary">Processing</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge badge-danger">Cancelled</span>
                                            @break
                                        @default
                                            <span class="badge badge-secondary">{{ ucfirst($order['status']) }}</span>
                                    @endswitch
                                </td>
                                <td>{{ date('d M Y, H:i', strtotime($order['created_at'])) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Product Sales Breakdown Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Product Sales Breakdown</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Product&nbsp;ID</th>
                            <th>Product&nbsp;Name</th>
                            <th>Units&nbsp;Sold</th>
                            <th>Revenue</th>
                            <th>% of Revenue</th>
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
                                    {{ $totalRevenue > 0 ? round($product['revenue'] / $totalRevenue * 100, 2) : 0 }}%
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
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    /* ---------- Monthly Revenue Line Chart ---------- */
    const ctx = document.getElementById("monthlySalesChart");
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                @foreach($monthlySales as $month => $value) "{{ $month }}"@if(!$loop->last),@endif @endforeach
            ],
            datasets: [{
                label: "Revenue",
                data: [
                    @foreach($monthlySales as $value) {{ $value }}@if(!$loop->last),@endif @endforeach
                ],
                lineTension: 0.3,
                backgroundColor: "rgba(78,115,223,0.05)",
                borderColor: "rgba(78,115,223,1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78,115,223,1)",
                pointBorderColor: "rgba(78,115,223,1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78,115,223,1)",
                pointHoverBorderColor: "rgba(78,115,223,1)",
                pointHitRadius: 10,
                pointBorderWidth: 2
            }]
        },
        options: {
            maintainAspectRatio: false,
            layout: { padding: { left:10, right:25, top:25, bottom:0 } },
            scales: {
                x: { grid: { display:false, drawBorder:false } },
                y: {
                    ticks: {
                        beginAtZero: true,
                        callback: val => 'Rp ' + val.toLocaleString('id-ID')
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: ctx => 'Revenue: Rp ' + ctx.parsed.y.toLocaleString('id-ID')
                    }
                }
            }
        }
    });
</script>
@endsection
