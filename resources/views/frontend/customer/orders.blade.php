@extends('frontend.layouts.master')

@section('content')
    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold mb-4">My Orders</h2>

            @if($orders->isEmpty())
                <div class="alert alert-info">You don't have any orders yet.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <span class="badge
                                                @if($order->status == 'completed') bg-success
                                                @elseif($order->status == 'processing') bg-primary
                                                @elseif($order->status == 'waiting for payment') bg-warning text-dark
                                                @else bg-secondary @endif">
                                            {{ ucfirst($order->status->value) }}
                                        </span>
                                    </td>
                                    <td>{{ number_format($order->final_price, 0, ',', '.') }} IDR</td>
                                    <td>
                                        <a href="{{ route('invoice.detail', ['id' => $order->id]) }}"
                                            class="btn btn-sm btn-outline-dark">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </section>
@endsection

<script>
    let alreadyNotified = false;

    setInterval(() => {
        if (alreadyNotified) return;

        fetch('{{ route('notifications.index') }}')
            .then(res => res.json())
            .then(data => {
                if (data.notifications.length > 0) {
                    const notif = data.notifications[0];
                    const message = notif.data.message ?? 'You have a new update!';
                    const orderNo = notif.data.order_number ?? '';

                    const alertBox = document.createElement('div');
                    alertBox.className = 'alert alert-info';
                    alertBox.innerText = `Order #${orderNo}: ${message}`;
                    alertBox.style.position = 'fixed';
                    alertBox.style.top = '10px';
                    alertBox.style.left = '50%';
                    alertBox.style.transform = 'translateX(-50%)';
                    alertBox.style.zIndex = 9999;
                    document.body.appendChild(alertBox);

                    // Sembunyikan setelah 5 detik
                    setTimeout(() => {
                        alertBox.remove();
                    }, 5000);

                    // Tandai sudah dibaca
                    fetch(`/notifications/${notif.id}/read`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    alreadyNotified = true;
                }
            });
    }, 5000); // polling setiap 10 detik
</script>
