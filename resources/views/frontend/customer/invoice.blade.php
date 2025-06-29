@extends('frontend.layouts.master')

@section('content')
@php
    $takeawayFee = 3000;
    $isTakeaway = isset($order['order_type']) && $order['order_type'] === 'takeaway';
    $subtotal = collect($order['items'])->sum(fn($item) => $item['price'] * $item['quantity']);
    $finalTotal = $isTakeaway ? $subtotal + $takeawayFee : $subtotal;
@endphp

<section class="py-5">
    <div class="container">
        <h2 class="mb-4 fw-bold">Invoice</h2>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <!-- Header Info -->
                <div class="d-flex justify-content-between mb-4">
                    <div>
                        <p class="mb-1"><strong>Order Date:</strong> {{ $order['order_date'] ?? now()->format('Y-m-d') }}</p>
                        <p class="mb-0"><strong>Order Type:</strong>
                            <span class="badge {{ $isTakeaway ? 'bg-danger' : 'bg-primary' }}">
                                {{ strtoupper($order['order_type'] ?? 'DINEIN') }}
                            </span>
                        </p>
                    </div>
                    <div class="text-end">
                        <p class="mb-1"><strong>Status:</strong>
                            @php
                                $status = strtolower($order['status'] ?? 'processing');
                                $badgeClass = match($status) {
                                    'waiting for payment' => 'bg-warning text-dark',
                                    'processing' => 'bg-primary',
                                    'completed' => 'bg-success',
                                    default => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ ucfirst($order['status'] ?? 'Processing') }}</span>
                        </p>
                        <p class="mb-0"><strong>Payment:</strong> {{ ucfirst($order['customer']['payment_method'] ?? 'Cash') }}</p>
                    </div>
                </div>

                <!-- Customer Info -->
                <h5 class="mb-3 fw-bold">Customer Info</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $order['customer']['name'] }}</p>
                        <p><strong>Email:</strong> {{ $order['customer']['email'] }}</p>
                        <p><strong>Notes:</strong> {{ $order['customer']['notes'] ?? '-' }}</p>
                    </div>
                </div>

                <hr>

                <!-- Order Items -->
                <h5 class="mb-3 fw-bold">Order Details</h5>
                <ul class="list-group mb-3">
                    @foreach($order['items'] as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $item['name'] }} × {{ $item['quantity'] }}
                            <span>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} IDR</span>
                        </li>
                    @endforeach

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Subtotal
                        <span>{{ number_format($subtotal, 0, ',', '.') }} IDR</span>
                    </li>

                    @if($isTakeaway)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Packaging Fee (Takeaway)
                            <span>{{ number_format($takeawayFee, 0, ',', '.') }} IDR</span>
                        </li>
                    @endif

                    <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                        Total
                        <span>{{ number_format($finalTotal, 0, ',', '.') }} IDR</span>
                    </li>
                </ul>

                <!-- Back Button -->
                <div class="text-end">
                    <a href="{{ route('menu') }}" class="btn btn-primary px-4">Back to Menu</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
