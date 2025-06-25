@extends('frontend.layouts.master')

@section('content')
    <section class="container py-5">
        <h2 class="mb-4">Invoice</h2>

        <div class="card p-4">
            <!-- Customer Info -->
            <h5>Customer Info</h5>
            <p><strong>Name:</strong> {{ $order['customer']['first_name'] }} {{ $order['customer']['last_name'] }}</p>
            <p><strong>Email:</strong> {{ $order['customer']['email'] }}</p>
            <p><strong>Phone:</strong> {{ $order['customer']['phone'] }}</p>
            <p><strong>Address:</strong> {{ $order['customer']['address'] }}, {{ $order['customer']['city'] }},
                {{ $order['customer']['postal_code'] }}</p>
            <p><strong>Notes:</strong> {{ $order['customer']['notes'] }}</p>

            <hr>

            <!-- Order Items -->
            <h5>Order Details</h5>
            <ul class="list-group mb-3">
                @foreach($order['items'] as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $item['name'] }} × {{ $item['quantity'] }}
                        <span>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} IDR</span>
                    </li>
                @endforeach
                <li class="list-group-item d-flex justify-content-between align-items-center fw-bold">
                    Total
                    <span>{{ number_format($order['total'], 0, ',', '.') }} IDR</span>
                </li>
            </ul>

            <!-- Payment & Status -->
            <p><strong>Payment Method:</strong> {{ ucfirst($order['customer']['payment_method']) }}</p>
            @if(isset($order['status']))
                <p><strong>Status:</strong>
                    @if($order['status'] === 'Waiting for Payment')
                        <span class="badge bg-warning text-dark">{{ $order['status'] }}</span>
                    @elseif($order['status'] === 'Processing')
                        <span class="badge bg-primary">{{ $order['status'] }}</span>
                    @else
                        <span class="badge bg-secondary">{{ $order['status'] }}</span>
                    @endif
                </p>
            @endif


            <a href="{{ route('menu') }}" class="btn btn-primary mt-3">Back to Menu</a>
        </div>
    </section>
@endsection