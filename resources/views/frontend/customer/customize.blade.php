@extends('frontend.layouts.master')

@section('content')
<section class="pt-4 pb-5" style="background-color: #f9f9f9;">
    <div class="container" style="max-width: 600px;">
        <div class="text-center mb-4">
            <h4 class="fw-bold">Customize Your {{ $name }}</h4>
        </div>

        <!-- Gambar -->
        <div class="text-center mb-3">
            <img src="{{ asset('frontend/images/m1.jpg') }}" alt="{{ $name }}" class="img-fluid rounded" style="max-height: 220px; object-fit: cover;">
        </div>

        <!-- Harga -->
        <p class="text-center fw-semibold">Base Price: $6.00</p>

        <!-- Form Customize -->
        <form action="#" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Choose Add-ons:</label>
                <div class="d-flex flex-wrap justify-content-start gap-3"> <!-- Flexbox untuk mengatur checkbox -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="addons[]" value="Extra Chicken" id="extraChicken">
                        <label class="form-check-label" for="extraChicken">Extra Chicken</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="addons[]" value="Spicy Sauce" id="spicySauce">
                        <label class="form-check-label" for="spicySauce">Spicy Sauce</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="addons[]" value="Cheese" id="cheese">
                        <label class="form-check-label" for="cheese">Cheese</label>
                    </div>
                </div>
            </div>

            <!-- Catatan Tambahan -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Notes (optional):</label>
                <input type="text" class="form-control" name="notes" placeholder="e.g. less spicy, no onion">
            </div>

             <!-- Input Quantity -->
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" name="quantity" id="quantity" value="1" class="form-control" min="1">
            </div>

            <!-- Tombol -->
            <div class="d-flex justify-content-between gap-2">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary w-50">Back</a>
                <button type="submit" class="btn btn-danger w-50">Add to Cart</button>
            </div>
        </form>
    </div>
</section>

@endsection
