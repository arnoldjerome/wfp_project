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
            @if(isset($addons) && count($addons) > 0)
            <div class="mb-3">
                <label class="form-label fw-semibold">Choose Add-ons:</label>
                <div class="d-flex flex-wrap justify-content-start gap-3">
                    @foreach($addons as $addon)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="addons[]" value="{{ $addon->name }}" id="addon{{ $addon->id }}" data-price="{{ number_format($addon->price, 2, '.', '') }}">
                            <label class="form-check-label" for="addon{{ $addon->id }}">{{ $addon->name }} ({{ number_format($addon->price, 2) }})</label>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

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

            <!-- Total Price -->
            <div class="mb-3">
                <p class="text-center fw-semibold">Total Price: $<span id="totalPrice">6.00</span></p>
            </div>

            <!-- Tombol -->
            <div class="d-flex justify-content-between gap-2">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary w-50">Back</a>
                <button type="submit" class="btn btn-danger w-50">Add to Cart</button>
            </div>
        </form>
    </div>
</section>

<script>
    // Get all checkboxes for add-ons
    const addonCheckboxes = document.querySelectorAll('input[name="addons[]"]');
    const totalPriceElement = document.getElementById('totalPrice');
    const basePrice = 6.00;

    // Update the total price based on selected add-ons and quantity
    function updateTotalPrice() {
        let totalPrice = basePrice;
        let quantity = document.getElementById('quantity').value;

        addonCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                totalPrice += parseFloat(checkbox.getAttribute('data-price'));
            }
        });

        totalPrice *= quantity; // Multiply by quantity
        totalPriceElement.textContent = totalPrice.toFixed(2); // Update total price on the page
    }

    // Add event listeners to the checkboxes
    addonCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateTotalPrice);
    });

    // Update price when quantity changes
    document.getElementById('quantity').addEventListener('input', updateTotalPrice);

    // Initial price update
    updateTotalPrice();
</script>
@endsection
