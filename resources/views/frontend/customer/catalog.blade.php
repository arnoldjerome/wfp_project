@extends('frontend.layouts.master')

@section('content')
    <!-- MENU PAGE -->
    <section class="menu_kiosk pt-4 pb-5" style="background-color: #f9f9f9;">
        <div class="container">

            <!-- Judul Kategori -->
            <div class="mb-3 text-center">
                <h5 class="fw-bold">What would you like to eat?</h5>
            </div>

            <!-- Categories -->
            <div class="d-flex gap-4 overflow-auto pb-3 mb-4 border-bottom text-center justify-content-center">
                {{-- Appetizer --}}
                <div>
                    <div class="rounded-circle overflow-hidden mx-auto" style="width: 100px; height: 100px;">
                        <img src="{{ asset('frontend/images/m1.jpg') }}" alt="Appetizer"
                            style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <p class="mt-2 fw-semibold mb-0">Appetizer</p>
                </div>

                {{-- Main Course --}}
                <div>
                    <div class="rounded-circle overflow-hidden mx-auto" style="width: 100px; height: 100px;">
                        <img src="{{ asset('frontend/images/menu2.jpg') }}" alt="Main Course"
                            style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <p class="mt-2 fw-semibold mb-0">Main Course</p>
                </div>

                {{-- Dessert --}}
                <div>
                    <div class="rounded-circle overflow-hidden mx-auto" style="width: 100px; height: 100px;">
                        <img src="{{ asset('frontend/images/m3.jpg') }}" alt="Dessert"
                            style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <p class="mt-2 fw-semibold mb-0">Dessert</p>
                </div>
            </div>

            <!-- Menu Grid -->
            <div class="row g-3">
                @php
                    $menus = [
                        ['name' => 'Chicken Biryani', 'price' => 6, 'img' => 'chicken-biryani.jpg', 'btn' => 'Customize', 'color' => 'danger'],
                        ['name' => 'Mutton Biryani', 'price' => 8, 'img' => 'mutton-biryani.jpg', 'btn' => 'Add', 'color' => 'warning'],
                        ['name' => 'Veg Biryani', 'price' => 8, 'img' => 'veg-biryani.jpg', 'btn' => 'Customize', 'color' => 'danger'],
                        ['name' => 'Fish Biryani', 'price' => 9, 'img' => 'fish-biryani.jpg', 'btn' => 'Customize', 'color' => 'danger'],
                        ['name' => 'Plain Veg Biryani', 'price' => 6, 'img' => 'plain-veg.jpg', 'btn' => 'Add', 'color' => 'warning'],
                        ['name' => 'Veg Panner Rice', 'price' => 6.5, 'img' => 'paneer-rice.jpg', 'btn' => 'Customize', 'color' => 'danger'],
                    ];
                @endphp

                @foreach ($menus as $menu)
                    <div class="col-6 col-md-4 col-lg-4">
                        <div class="border rounded shadow-sm bg-white p-2 text-center position-relative h-100">
                            <img src="{{ asset('frontend/images/' . $menu['img']) }}" alt="{{ $menu['name'] }}"
                                class="img-fluid rounded mb-2" style="height: 90px; object-fit: cover;">
                            <h6 class="mb-1 fw-bold">{{ $menu['name'] }}</h6>
                            <p class="mb-2">${{ number_format($menu['price'], 2) }}</p>
                            <button class="btn btn-{{ $menu['color'] }} btn-sm w-100">{{ $menu['btn'] }}</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Bottom Bar -->
            <div class="fixed-bottom bg-white shadow p-3 border-top">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <i class="fas fa-shopping-cart text-danger"></i>
                        <span class="fw-bold ms-2">VIEW ORDERS</span>
                        <span class="badge bg-danger ms-1">3</span>
                    </div>
                    <div class="fw-bold">SUB TOTAL: <span class="text-success">$9.00</span></div>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-danger w-50">Cancel Order</button>
                    <button class="btn btn-danger w-50">Confirm Order</button>
                </div>
            </div>

        </div>
    </section>
@endsection
