@extends('layouts.adminlte4')

@section('form-name')
    <h3 class="mb-0">Laporan</h3>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5>Makanan Paling Banyak Dipesan</h5>
                <p>{{ $mostOrderedFood->name ?? 'Tidak ada data' }} ({{ $mostOrderedFood->total_ordered ?? 0 }} pesanan)</p>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h5>Kategori dengan Makanan Terbanyak</h5>
                <p>{{ $categoryWithMostFoods->name ?? 'Tidak ada data' }} ({{ $categoryWithMostFoods->total_foods ?? 0 }} makanan)</p>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5>Customer Paling Sering Beli</h5>
                <p>{{ $topCustomer->name ?? 'Tidak ada data' }} ({{ $topCustomer->total_orders ?? 0 }} kali)</p>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5>Metode Pembayaran Terbanyak</h5>
                <p>{{ $mostUsedPaymentMethod->payment ?? 'Tidak ada data' }} ({{ $mostUsedPaymentMethod->total ?? 0 }} kali)</p>
            </div>
        </div>
    </div>

    <div class="col-12 mb-3">
        <div class="card bg-dark text-white">
            <div class="card-body">
                <h5>Total Uang Pesanan</h5>
                <p>Rp{{ number_format($totalOrderAmount, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection