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
                <!-- Customer Info -->
                <h5 class="mb-3 fw-bold">Customer Info</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Name:</strong> {{ $order['customer']['first_name'] }} {{ $order['customer']['last_name'] }}</p>
                        <p><strong>Email:</strong> {{ $order['customer']['email'] }}</p>
                        <p><strong>Phone:</strong> {{ $order['customer']['phone'] }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Address:</strong> {{ $order['customer']['address'] }}, {{ $order['customer']['city'] }}, {{ $order['customer']['postal_code'] }}</p>
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

                    @if($isTakeaway)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Packaging Fee (Take Away)
                            <span>{{ number_format($takeawayFee, 0, ',', '.') }} IDR</span>
                        </li>
                    @endif

                    <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                        Total
                        <span>{{ number_format($finalTotal, 0, ',', '.') }} IDR</span>
                    </li>
                </ul>

                <!-- Payment & Status -->
                <div class="mb-3">
                    <p class="mb-1"><strong>Payment Method:</strong> {{ ucfirst($order['customer']['payment_method']) }}</p>
                    @if(isset($order['status']))
                        <p class="mb-0"><strong>Status:</strong>
                            @php
                                $status = strtolower($order['status']);
                                $badgeClass = match($status) {
                                    'waiting for payment' => 'bg-warning text-dark',
                                    'processing' => 'bg-primary',
                                    'completed' => 'bg-success',
                                    default => 'bg-secondary',
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">{{ $order['status'] }}</span>
                        </p>
                    @endif
                </div>

                <!-- Back Button -->
                <div class="text-end">
                    <a href="{{ route('menu') }}" class="btn btn-primary px-4">Back to Menu</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
