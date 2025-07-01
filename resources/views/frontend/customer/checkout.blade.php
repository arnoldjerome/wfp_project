@extends('frontend.layouts.master')

@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    @php
        $orderType = request()->cookie('order_type') ?? old('order_type', 'dinein');
        $takeawayFee = $takeawayFee ?? 3000;
        $finalTotal = $finalTotal ?? 0;
        $totalPrice = collect(Session::get('cart', []))->sum(fn($item) => $item['price'] * $item['quantity']);
    @endphp

    <section class="fp__breadcrumb" style="background-image: url('{{ asset('frontend/images/breadcrumb_bg.jpg') }}');">
        <div class="container">
            <div class="fp__breadcrumb_text">
                <h1>Checkout</h1>
                <ul>
                    <li><a href="{{ route('customer.home') }}">Home</a></li>
                    <li>Checkout</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_type" value="{{ $orderType }}">

                <div class="row g-4">
                    <div class="col-lg-7">
                        <div class="bg-light p-4 rounded shadow-sm h-100">
                            <div class="mb-3">
                                <span class="badge bg-{{ $orderType === 'takeaway' ? 'danger' : 'primary' }}">
                                    {{ strtoupper($orderType) }}
                                </span>
                            </div>
                            <h4 class="mb-3 fw-bold">Billing Details</h4>
                            <ul class="list-unstyled mb-0">
                                <li><strong>Order Type:</strong> {{ ucfirst($orderType) }}</li>
                                <li><strong>Name:</strong> {{ Auth::user()->name}} </li>
                                <li><strong>Email:</strong> {{ Auth::user()->email}} </li>

                                @php $notesList = collect($cartItems)->pluck('notes')->filter()->unique(); @endphp
                                @if($notesList->isNotEmpty())
                                    <li><strong>Notes:</strong>

                                        @foreach($notesList as $note)
                                            <p>{{ $note }}</p>
                                        @endforeach

                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="bg-white border p-4 rounded shadow-sm">
                            <h4 class="mb-3 fw-bold">Your Order</h4>
                            <ul class="list-group mb-3">
                                @foreach($cartItems as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            {{ $item['name'] }} × {{ $item['quantity'] }}
                                            @if(isset($item['note']) && $item['note'])
                                                <small class="text-muted d-block ms-3">Note: {{ $item['note'] }}</small>
                                            @endif
                                        </div>
                                        <span>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} IDR</span>
                                    </li>
                                @endforeach

                                @if($orderType === 'takeaway')
                                    <li class="list-group-item d-flex justify-content-between">
                                        Packaging Fee (Take Away)
                                        <span>{{ number_format($takeawayFee, 0, ',', '.') }} IDR</span>
                                    </li>
                                @endif

                                <li class="list-group-item small text-muted">
                                    <em>* Total includes applicable takeaway packaging fee.</em>
                                </li>

                                <li class="list-group-item d-flex justify-content-between fw-bold">
                                    Total
                                    <span class="text-success fs-5">{{ number_format($finalTotal, 0, ',', '.') }} IDR</span>
                                </li>
                            </ul>

                            <div class="mb-4">
                                <h5 class="fw-bold mb-3">Choose Payment Method</h5>
                                <div class="row g-2 text-center">
                                    <div class="col-6">
                                        <input type="radio" class="btn-check" name="payment_method" id="cash" value="cash"
                                            autocomplete="off" checked>
                                        <label class="btn btn-outline-secondary w-100 py-3 rounded" for="cash">
                                            <i class="fas fa-money-bill-wave fa-lg mb-2 d-block"></i>
                                            Cash
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <input type="radio" class="btn-check" name="payment_method" id="card" value="card"
                                            autocomplete="off">
                                        <label class="btn btn-outline-danger w-100 py-3 rounded" for="card">
                                            <i class="fas fa-credit-card fa-lg mb-2 d-block"></i>
                                            Debit/Credit
                                        </label>
                                    </div>
                                </div>

                                <div id="transfer-info" class="mt-4" style="display: none;">
                                    <h6 class="fw-bold">Transfer to Bank Account</h6>
                                    <p class="mb-1"><strong>Bank:</strong> BCA</p>
                                    <p class="mb-1"><strong>Account Number:</strong> 1234-5678-90</p>
                                    <p class="mb-3"><strong>Account Name:</strong> PT. Violet Online Store</p>

                                    {{-- <div class="mb-3">
                                        <label for="transfer_proof" class="form-label">Upload Transfer Proof</label>
                                        <input type="file" class="form-control" name="transfer_proof" id="transfer_proof">
                                    </div> --}}
                                </div>
                            </div>

                            <button type="submit" class="btn btn-warning w-100 py-3 fw-bold fs-5">
                                <i class="fas fa-check me-2"></i> Proceed
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const cashRadio = document.getElementById("cash");
            const cardRadio = document.getElementById("card");
            const transferInfo = document.getElementById("transfer-info");

            function toggleTransferInfo() {
                transferInfo.style.display = cardRadio.checked ? "block" : "none";
            }

            toggleTransferInfo();
            cashRadio.addEventListener("change", toggleTransferInfo);
            cardRadio.addEventListener("change", toggleTransferInfo);

        });
    </script>
@endsection