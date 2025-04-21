@extends('layouts.adminlte4')

@section('content')
<div class="row">
    <!-- Summary Cards -->
    <div class="col-md-4">
        <div class="card bg-primary text-white mb-3">
            <div class="card-body">
                <h5>Available to Payout</h5>
                <p>${{ number_format($availableToPayout, 2) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white mb-3">
            <div class="card-body">
                <h5>Today Revenue</h5>
                <p>${{ number_format($todayRevenue, 2) }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white mb-3">
            <div class="card-body">
                <h5>Today Orders</h5>
                <p>{{ $todayOrders }} Orders</p>
            </div>
        </div>
    </div>
</div>

<!-- Sales Funnel -->
<div class="card mb-4">
    <div class="card-body">
        <h5>Sales Funnel</h5>
        <ul>
            <li>Add to Cart: {{ $salesFunnel['add_to_cart'] }}</li>
            <li>Initiate Checkout: {{ $salesFunnel['checkout'] }}</li>
            <li>Purchases: {{ $salesFunnel['purchase'] }}</li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-body">
                <h5>Order per Hari (7 Hari Terakhir)</h5>
                <canvas id="orderChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card">
            <div class="card-body">
                <h5>Penggunaan Metode Pembayaran</h5>
                <canvas id="paymentChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    const ctxOrder = document.getElementById('orderChart').getContext('2d');
    const orderChart = new Chart(ctxOrder, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($ordersPerDay->toArray())) !!},
            datasets: [{
                label: 'Jumlah Order',
                data: {!! json_encode(array_values($ordersPerDay->toArray())) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
    });

    const ctxPayment = document.getElementById('paymentChart').getContext('2d');
    const paymentChart = new Chart(ctxPayment, {
        type: 'pie',
        data: {
            labels: {!! json_encode($paymentMethods->pluck('name')) !!},
            datasets: [{
                data: {!! json_encode($paymentMethods->pluck('total')) !!},
                backgroundColor: [
                    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b'
                ]
            }]
        }
    });
</script>

<!-- Device Chart dan Audience Chart nanti pakai Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
