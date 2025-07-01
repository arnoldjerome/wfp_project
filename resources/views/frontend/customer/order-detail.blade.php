@extends('frontend.layouts.master')

@section('content')
    @php
        $isTakeaway = $order->order_type === 'takeaway';
    @endphp

    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold mb-4">Invoice #{{ $order->order_number }}</h2>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <p><strong>Order Date:</strong> {{ $order->ordered_at->format('Y-m-d H:i') }}</p>
                    <p><strong>Status:</strong> <span class="badge
                        @if($order->status->value == 'completed') bg-success
                        @elseif($order->status->value == 'preparing') bg-primary
                        @elseif($order->status->value == 'pending') bg-warning text-dark
                        @elseif($order->status->value == 'cancelled') bg-danger
                            @else bg-secondary
                        @endif">
                            {{ ucfirst($order->status->value) }}
                        </span>
                    </p>
                    <p><strong>Payment Method:</strong> {{ $order->payment_method_id === 1 ? 'Cash' : 'Card' }}</p>
                    <p><strong>Type:</strong> {{ ucfirst($order->order_type) }}</p>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="mb-3">Items</h5>
                    <ul class="list-group mb-3">
                        @foreach($order->items as $item)
                            <li class="list-group-item">
                                <strong>{{ $item->food->name }}</strong> × {{ $item->quantity }}<br>
                                <small>Price: Rp {{ number_format($item->price, 0, ',', '.') }}</small><br>
                                @if ($item->note)
                                    <small>Note: {{ $item->note }}</small><br>
                                @endif
                                @if ($item->addOns->isNotEmpty())
                                    <small>Add-ons:</small>
                                    <ul class="ms-3">
                                        @foreach($item->addOns as $addon)
                                            @if ($addon->addOn)
                                                <li>Rp {{ $addon->addOn->name }} ({{ number_format($addon->price, 0, ',', '.') }})</li>
                                            @endif
                                        @endforeach

                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <p><strong>Subtotal:</strong> {{ number_format($order->total_price, 0, ',', '.') }} IDR</p>
                    @if ($isTakeaway)
                        <p><strong>Packaging Fee:</strong> 3.000 IDR</p>
                    @endif
                    <p><strong>Total:</strong> {{ number_format($order->final_price, 0, ',', '.') }} IDR</p>
                </div>
            </div>

            <div class="text-end mt-4">
                <a href="{{ route('customer.orders') }}" class="btn btn-secondary">Back to Orders</a>
            </div>
        </div>
    </section>
@endsection