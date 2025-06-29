@extends('frontend.layouts.master')

@section('content')
@php
    use Illuminate\Support\Facades\Cookie;
    $orderType = request()->cookie('order_type') ?? 'dinein';
    $takeawayFee = 3000;
    $cart = Session::get('cart', []);
    $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
    $totalItem = collect($cart)->sum('quantity');
    $finalTotal = $orderType === 'takeaway' ? $total + $takeawayFee : $total;
@endphp

<section class="menu_kiosk pt-4 pb-5" style="background-image: url('{{ asset('frontend/images/bg.png') }}'); background-size: cover; background-repeat: repeat; background-position: center; margin-top: 0;">
    <div class="container pb-5" style="padding-bottom: 120px !important; background-color: rgba(255, 255, 255, 0.92); border-radius: 10px;">
        <div class="mb-3 text-center">
            <h5 class="fw-bold">What would you like to eat?</h5>
        </div>

        <div class="d-flex gap-4 overflow-auto pb-3 mb-4 border-bottom text-center justify-content-center">
            @php
                // Kategori: All + dari database
                $categoryNames = ['All'];
                if(isset($categories)) {
                    foreach($categories as $cat) {
                        $categoryNames[] = $cat->name;
                    }
                }
            @endphp
            @foreach ($categoryNames as $cat)
                <div onclick="filterMenu('{{ $cat }}')" class="category-card text-center" style="cursor:pointer;">
                    <div class="rounded-circle overflow-hidden mx-auto border border-secondary category-img-wrapper">
                        <img src="{{ asset('frontend/images/' . strtolower(str_replace(' ', '', $cat)) . '.jpg') }}" alt="{{ $cat }}" class="category-img">
                    </div>
                    <p class="mt-2 fw-semibold mb-0">{{ $cat }}</p>
                </div>
            @endforeach
        </div>

        <div class="row row-cols-2 row-cols-md-3 g-3" id="menuContainer">
            {{-- Loop menu dari database --}}
            @foreach ($foods as $food)
                <div class="col menu-item" data-category="{{ $food->category->name ?? 'Uncategorized' }}">
                    <div class="card h-100 shadow-sm text-center menu-card">
                        @php
                            $imgUrl = $food->img_url ? asset(ltrim($food->img_url, '/')) : asset('frontend/images/default.jpg');
                        @endphp
                        <img src="{{ $imgUrl }}" alt="{{ $food->name }}" class="card-img-top" style="height: 140px; object-fit: cover;">
                        <div class="card-body">
                            <h6 class="card-title fw-bold">{{ $food->name }}</h6>
                            <p class="text-muted mb-1">{{ $food->category->name ?? 'Uncategorized' }}</p>
                            <p class="card-text mb-2">${{ number_format($food->price, 2) }}</p>

                            {{-- Tombol Customize/Add --}}
                            @if ($food->addOns->count() > 0)
                                <a href="{{ route('customize.page', ['name' => $food->name]) }}" class="btn btn-danger btn-sm w-100">Customize</a>
                            @else
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="name" value="{{ $food->name }}">
                                    <input type="hidden" name="price" value="{{ $food->price }}">
                                    <button class="btn btn-warning btn-sm w-100">Add</button>
                                </form>
                            @endif

                            <button class="btn btn-info btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#menuDetailModal{{ $food->id }}">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Modal Detail --}}
                <div class="modal fade" id="menuDetailModal{{ $food->id }}" tabindex="-1" aria-labelledby="menuDetailModalLabel{{ $food->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $food->name }} - Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <img src="{{ $imgUrl }}" class="img-fluid mb-3" style="max-height: 200px; object-fit: cover;">
                                <p><strong>Description:</strong> {{ $food->description ?? '-' }}</p>
                                <p><strong>Nutrition:</strong> {{ $food->nutrition_fact ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="fixed-bottom bg-white shadow p-3 border-top">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <div>
                    <a href="{{ route('cart.index') }}" class="text-decoration-none text-danger fw-bold">
                        <i class="fas fa-shopping-cart text-danger"></i>
                        <span class="ms-2">VIEW ORDERS</span>
                        <span class="badge bg-danger ms-1">{{ $totalItem }}</span>
                    </a>
                    <div id="order_type" class="d-flex align-items-center gap-2 mt-2">
                        <span class="text-muted small">Order Type:</span>
                        <span class="badge bg-{{ $orderType === 'dinein' ? 'primary' : 'danger' }} px-3 py-2 fw-bold">
                            {{ strtoupper($orderType) }}
                        </span>
                        <button class="btn btn-outline-secondary btn-sm d-flex align-items-center" 
                                data-bs-toggle="modal" data-bs-target="#orderTypeModal">
                            Change
                        </button>
                    </div>

                    @if($orderType === 'takeaway')
                        <div class="text-muted small">
                            Packaging Fee: <strong>{{ number_format($takeawayFee, 0, ',', '.') }} IDR</strong>
                        </div>
                    @endif
                </div>
                <div class="fw-bold">
                    SUB TOTAL:
                    <span class="text-success">{{ number_format($finalTotal, 0, ',', '.') }} IDR</span>
                </div>
            </div>
            <div class="d-flex gap-2">
                <form action="{{ route('cart.clear') }}" method="POST" class="w-50">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100 bg-white">Cancel Order</button>
                </form>
                <a href="{{ route('checkout.index') }}" class="btn btn-danger w-50">Confirm Order</a>
            </div>
        </div>
    </div>
</section>


<div class="modal fade" id="orderTypeModal" tabindex="-1" aria-labelledby="orderTypeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-header border-0">
        <h5 class="modal-title w-100 fw-bold" id="orderTypeModalLabel">Select Order Type</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-4">
        <p class="mb-4">Please choose your order method</p>
        <div class="d-flex justify-content-around">
            <button class="btn btn-outline-success px-4 py-2" onclick="setOrderType('dinein')">Dine In</button>
            <button class="btn btn-outline-danger px-4 py-2" onclick="setOrderType('takeaway')">Take Away</button>
        </div>
      </div>
    </div>
  </div>
</div>


<script>  
    function filterMenu(category) {
        const items = document.querySelectorAll('.menu-item');
        items.forEach(item => {
            item.style.display = (category === 'All' || item.dataset.category === category) ? 'block' : 'none';
        });
    }

        function setOrderType(type) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('order.type.set') }}";

        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'order_type';
        input.value = type;

        form.appendChild(csrf);
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }

</script>

<style>
    .menu-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .menu-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        z-index: 2;
    }

    .category-img-wrapper {
        width: 100px;
        height: 100px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .category-card:hover .category-img-wrapper {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        border-color: #dc3545;
    }

    .category-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    #order_type {
      margin-top: 0.25em;
      margin-bottom: 0.25em;
    }
</style>
@endsection
