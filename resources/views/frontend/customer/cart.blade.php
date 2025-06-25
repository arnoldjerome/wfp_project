@extends('frontend.layouts.master')

@section('content')
<section class="container py-5">
    <h3 class="mb-4">Your Cart</h3>

    @if(count($cartItems) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Menu</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $id => $item)
                <tr>
                    <td>{{ $item['name'] }}<br>
                        <!-- Menampilkan Addons, pastikan key 'addons' ada -->
                        @if(isset($item['addons']) && count($item['addons']) > 0)
                            <strong>Add-ons:</strong> 
                            <ul>
                                @foreach($item['addons'] as $addon)
                                    <li>{{ $addon }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <!-- Menampilkan Notes, pastikan key 'notes' ada -->
                        @if(isset($item['notes']) && $item['notes'])
                            <strong>Notes:</strong> {{ $item['notes'] }}
                        @endif
                    </td>
                    <td>
                        <!-- Form untuk update quantity -->
                        <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex align-items-center">
                            @csrf
                            @method('PUT')
                            <button type="submit" name="action" value="decrement" class="btn btn-sm btn-outline-secondary">-</button>
                            <input type="text" name="quantity" value="{{ $item['quantity'] }}" readonly class="form-control mx-2 text-center" style="width: 60px;">
                            <button type="submit" name="action" value="increment" class="btn btn-sm btn-outline-secondary">+</button>
                        </form>
                    </td>
                    <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                    <td>
                        <!-- Form untuk menghapus item -->
                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="2" class="text-end fw-bold">Total:</td>
                    <td colspan="2"><strong>${{ number_format($totalPrice, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>


        <a href="{{ route('menu') }}" class="btn btn-primary">Back to Menu</a>
        <div class="d-flex justify-content-end gap-2 mt-3">
            <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Cancel Order</button>
            </form>
            <a href="{{ route('checkout.index') }}" class="btn btn-success">Checkout</a>
        </div>
    @else
        <p>Your cart is empty.</p>
        <a href="{{ route('menu') }}" class="btn btn-primary">Back to Menu</a>
    @endif
</section>
@endsection
