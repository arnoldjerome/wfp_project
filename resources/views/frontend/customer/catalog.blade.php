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

        <div class="text-center mb-3">
            <span class="badge bg-{{ $orderType === 'dinein' ? 'primary' : 'danger' }} px-3 py-2">
                {{ strtoupper($orderType) }}
            </span>
        </div>

        <div class="d-flex gap-4 overflow-auto pb-3 mb-4 border-bottom text-center justify-content-center">
            @php
                $categories = ['All', 'Appetizer', 'Main Course', 'Dessert'];
            @endphp
            @foreach ($categories as $cat)
                <div onclick="filterMenu('{{ $cat }}')" class="category-card text-center" style="cursor:pointer;">
                    <div class="rounded-circle overflow-hidden mx-auto border border-secondary category-img-wrapper">
                        <img src="{{ asset('frontend/images/' . strtolower(str_replace(' ', '', $cat)) . '.jpg') }}" alt="{{ $cat }}" class="category-img">
                    </div>
                    <p class="mt-2 fw-semibold mb-0">{{ $cat }}</p>
                </div>
            @endforeach
        </div>

        <div class="row row-cols-2 row-cols-md-3 g-3" id="menuContainer">
            @php
                $menus = [
                    ['name' => 'Chicken Biryani', 'price' => 6, 'img' => 'm1.jpg', 'btn' => 'Customize', 'color' => 'danger', 'category' => 'Main Course', 'description' => 'A spicy and flavorful rice dish with chicken.', 'nutrition' => 'Calories: 400, Protein: 20g, Carbs: 60g'],
                    ['name' => 'Mutton Biryani', 'price' => 8, 'img' => 'm2.jpg', 'btn' => 'Add', 'color' => 'warning', 'category' => 'Main Course', 'description' => 'A rich and tender mutton biryani with aromatic spices.', 'nutrition' => 'Calories: 500, Protein: 30g, Carbs: 50g'],
                    ['name' => 'Veg Biryani', 'price' => 8, 'img' => 'm3.jpg', 'btn' => 'Customize', 'color' => 'danger', 'category' => 'Main Course', 'description' => 'A vegetarian rice dish with mixed vegetables and spices.', 'nutrition' => 'Calories: 350, Protein: 10g, Carbs: 70g'],
                    ['name' => 'Fish Biryani', 'price' => 9, 'img' => 'm4.jpg', 'btn' => 'Customize', 'color' => 'danger', 'category' => 'Main Course', 'description' => 'A flavorful fish biryani with aromatic spices.', 'nutrition' => 'Calories: 450, Protein: 25g, Carbs: 55g'],
                    ['name' => 'Spring Rolls', 'price' => 5, 'img' => 'm5.jpg', 'btn' => 'Add', 'color' => 'warning', 'category' => 'Appetizer', 'description' => 'Crispy and savory spring rolls stuffed with vegetables.', 'nutrition' => 'Calories: 200, Protein: 4g, Carbs: 40g'],
                    ['name' => 'Ice Cream', 'price' => 4, 'img' => 'm6.jpg', 'btn' => 'Add', 'color' => 'warning', 'category' => 'Dessert', 'description' => 'A creamy and sweet vanilla ice cream.', 'nutrition' => 'Calories: 150, Protein: 2g, Carbs: 30g'],
                ];
            @endphp

            @foreach ($menus as $menu)
                <div class="col menu-item" data-category="{{ $menu['category'] }}">
                    <div class="card h-100 shadow-sm text-center menu-card">
                        <img src="{{ asset('frontend/images/' . $menu['img']) }}" alt="{{ $menu['name'] }}" class="card-img-top" style="height: 140px; object-fit: cover;">
                        <div class="card-body">
                            <h6 class="card-title fw-bold">{{ $menu['name'] }}</h6>
                            <p class="text-muted mb-1">{{ $menu['category'] }}</p>
                            <p class="card-text mb-2">${{ number_format($menu['price'], 2) }}</p>

                            @if ($menu['btn'] === 'Customize')
                                <a href="{{ route('customize.page', ['name' => $menu['name']]) }}" class="btn btn-{{ $menu['color'] }} btn-sm w-100">Customize</a>
                            @else
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="name" value="{{ $menu['name'] }}">
                                    <input type="hidden" name="price" value="{{ $menu['price'] }}">
                                    <button class="btn btn-{{ $menu['color'] }} btn-sm w-100">{{ $menu['btn'] }}</button>
                                </form>
                            @endif

                            <button class="btn btn-info btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#menuDetailModal{{ $loop->index }}">
                                View Details
                            </button>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="menuDetailModal{{ $loop->index }}" tabindex="-1" aria-labelledby="menuDetailModalLabel{{ $loop->index }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ $menu['name'] }} - Details</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <img src="{{ asset('frontend/images/' . $menu['img']) }}" class="img-fluid mb-3" style="max-height: 200px; object-fit: cover;">
                                <p><strong>Description:</strong> {{ $menu['description'] }}</p>
                                <p><strong>Nutrition:</strong> {{ $menu['nutrition'] }}</p>
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
                    <div class="text-muted small">
                        Order Type: <strong>{{ ucfirst($orderType) }}</strong>
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

<script>
    function filterMenu(category) {
        const items = document.querySelectorAll('.menu-item');
        items.forEach(item => {
            item.style.display = (category === 'All' || item.dataset.category === category) ? 'block' : 'none';
        });
    }

    // Sinkronkan cookie dengan localStorage saat load
    if (localStorage.getItem("order_type")) {
        document.cookie = "order_type=" + localStorage.getItem("order_type") + "; path=/";
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
</style>
@endsection
