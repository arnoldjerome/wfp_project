@extends('frontend.layouts.master')

@section('content')
<section class="container py-5">
    <h3 class="mb-4 fw-bold text-center">Your Cart</h3>

    @if(count($cartItems) > 0)
        <div class="table-responsive">
            <table class="table align-middle text-center table-bordered">
                <thead style="background-color: #8b0000; color: white;">
                    <tr>
                        <th>Menu</th>
                        <th width="160px">Quantity</th>
                        <th width="120px">Price</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $id => $item)
                        <tr>
                            <td class="text-start bg-white">
                                <strong>{{ $item['name'] }}</strong><br>

                                @if(isset($item['addons']) && count($item['addons']) > 0)
                                    <small><strong>Add-ons:</strong></small>
                                    <ul class="mb-1">
                                        @foreach($item['addons'] as $addon)
                                            <li><small>{{ $addon }}</small></li>
                                        @endforeach
                                    </ul>
                                @endif

                                @if(isset($item['notes']) && $item['notes'])
                                    <small><strong>Notes:</strong> {{ $item['notes'] }}</small>
                                @endif
                            </td>

                            <td class="bg-white">
                                <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex justify-content-center align-items-center">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" name="action" value="decrement" class="btn btn-sm btn-outline-secondary px-2">−</button>
                                    <input type="text" name="quantity" value="{{ $item['quantity'] }}" readonly class="form-control mx-2 text-center" style="width: 50px;">
                                    <button type="submit" name="action" value="increment" class="btn btn-sm btn-outline-secondary px-2">+</button>
                                </form>
                            </td>

                            <td class="fw-semibold bg-white">${{ number_format($item['price'] * $item['quantity'], 2) }}</td>

                            <td class="bg-white">
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    <tr class="table-light">
                        <td colspan="2" class="text-end fw-bold">Total:</td>
                        <td colspan="2" class="fw-bold text-success">${{ number_format($totalPrice, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 gap-3">
            <a href="{{ route('menu') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left me-1"></i> Back to Menu
            </a>

            <div class="d-flex gap-2">
                <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger bg-white border border-danger text-danger custom-cancel-btn">
                        Cancel Order
                    </button>
                </form>

                <a href="{{ route('checkout.index') }}" class="btn btn-success">Checkout</a>
            </div>
        </div>

        <style>
            .custom-cancel-btn:hover {
                background-color: #dc3545 !important;
                color: white !important;
            }
        </style>

    @else
        <div class="text-center">
            <p class="fs-5">Your cart is currently empty.</p>
            <a href="{{ route('menu') }}" class="btn btn-primary">Browse Menu</a>
        </div>
    @endif
</section>
@endsection
