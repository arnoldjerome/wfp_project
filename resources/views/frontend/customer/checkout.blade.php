@extends('frontend.layouts.master')

@section('content')
    <!-- Tambahkan Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Breadcrumb -->
    <section class="fp__breadcrumb" style="background-image: url('{{ asset('frontend/images/breadcrumb_bg.jpg') }}');">
        <div class="container">
            <div class="fp__breadcrumb_text">
                <h1>Checkout</h1>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Checkout</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Checkout Page -->
    <section class="fp__checkout mt_100 xs_mt_70 mb_100 xs_mb_70">
        <div class="container">
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Billing Details -->
                    <div class="col-lg-7">
                        <div class="fp__checkout_form">
                            <h3>Billing Details</h3>
                            <div class="border rounded p-3 mb-4 bg-light">
                                <p><strong>First Name:</strong> John</p>
                                <p><strong>Last Name:</strong> Doe</p>
                                <p><strong>Email:</strong> johndoe@example.com</p>
                                <p><strong>Phone:</strong> 081234567890</p>
                                <p><strong>Address:</strong> Jalan Raya No. 123</p>
                                <p><strong>City:</strong> Denpasar</p>
                                <p><strong>Postal Code:</strong> 80111</p>
                                <p><strong>Notes:</strong> Please deliver between 10AM - 12PM</p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="col-lg-5">
                        <div class="fp__checkout_order">
                            <h3>Your Order</h3>
                            <ul class="order_list">
                                @foreach($cartItems as $item)
                                    <li>
                                        {{ $item['name'] }} × {{ $item['quantity'] }}
                                        <span>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }} IDR</span>
                                    </li>
                                @endforeach
                                <li class="total">
                                    Total <span>{{ number_format($totalPrice, 0, ',', '.') }} IDR</span>
                                </li>
                            </ul>

                            <!-- Payment Method Visual -->
                            <div class="payment_methods mb-4">
                                <h5>Choose Payment Method</h5>
                                <div class="row text-center">
                                    <div class="col-6">
                                        <input type="radio" class="btn-check" name="payment_method" id="cash" value="cash"
                                            autocomplete="off" checked>
                                        <label class="btn btn-outline-secondary w-100 py-3 rounded" for="cash">
                                            <i class="fas fa-money-bill-wave fa-2x mb-2"></i><br>
                                            Cash
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <input type="radio" class="btn-check" name="payment_method" id="card" value="card"
                                            autocomplete="off">
                                        <label class="btn btn-outline-danger w-100 py-3 rounded" for="card">
                                            <i class="fas fa-credit-card fa-2x mb-2"></i><br>
                                            Debit/Credit
                                        </label>
                                    </div>
                                </div>

                                <!-- Transfer Info (hidden by default) -->
                                <div id="transfer-info" class="mt-4" style="display: none;">
                                    <h6 class="fw-bold">Transfer to bank account:</h6>
                                    <p><strong>Bank:</strong> BCA</p>
                                    <p><strong>Account Number:</strong> 1234-5678-90</p>
                                    <p><strong>Account Name:</strong> PT. Violet Online Store</p>

                                    <div class="mb-3">
                                        <label for="transfer_proof" class="form-label">Upload Transfer Proof:</label>
                                        <input class="form-control" type="file" name="transfer_proof" id="transfer_proof">
                                    </div>
                                </div>
                            </div>

                            <!-- Proceed Button -->
                            <button type="submit" class="btn btn-warning w-100 py-3 fw-bold fs-5">Proceed</button>
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
                if (cardRadio.checked) {
                    transferInfo.style.display = "block";
                } else {
                    transferInfo.style.display = "none";
                }
            }

            // Jalankan saat load
            toggleTransferInfo();

            // Jalankan saat ada perubahan
            cashRadio.addEventListener("change", toggleTransferInfo);
            cardRadio.addEventListener("change", toggleTransferInfo);
        });
    </script>

@endsection