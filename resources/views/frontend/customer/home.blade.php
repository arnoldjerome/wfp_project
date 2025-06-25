@extends('frontend.layouts.master')

@section('content')
    <!-- HERO SECTION -->
    <section class="home_hero py-4" style="background-color: #fff0d9;">
        <div class="container text-center position-relative">
            <h1 class="fw-bold" style="font-family: 'Brush Script MT', cursive; color: #da8600; font-size: 2rem;">
                Velocity
            </h1>
            <div class="badge bg-danger text-white px-3 py-1 rounded-pill"
                style="position: absolute; right: 15px; top: 10px;">
                BEST OFF
            </div>

            <!-- Carousel -->
            <div id="carouselExampleIndicators" class="carousel slide mt-3 mx-auto" data-bs-ride="carousel"
                style="max-width: 800px;">
                <div class="carousel-inner rounded shadow">
                    <div class="carousel-item active">
                        <img src="{{ asset('frontend/images/m1.jpg') }}" class="d-block w-100 img-fluid rounded"
                            style="height: 200px; object-fit: cover;" alt="Noodle 1">
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('frontend/images/m2.jpg') }}" class="d-block w-100 img-fluid rounded"
                            style="height: 200px; object-fit: cover;" alt="Noodle 2">
                    </div>
                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>

            <!-- Order Now Button -->
            <a href="{{ route('menu') }}" class="btn btn-warning mt-4 px-4 py-2 fw-bold">
                Order Now
            </a>
        </div>
    </section>

    <!-- ORDER ACTIONS -->
    <section class="home_actions py-4" style="background-color: #fff;">
        <div class="container">
            <div class="row g-3 text-center">
                <div class="col-6">
                    <div class="border rounded p-3 h-100 shadow-sm">
                        <img src="{{ asset('frontend/images/start-order.png') }}" alt="Start Order"
                            style="width: 40px;">
                        <p class="mb-0 mt-2 fw-bold">Start Order</p>
                    </div>
                </div>
                <div class="col-6">
                    <div class="border rounded p-3 h-100 shadow-sm">
                        <img src="{{ asset('frontend/images/scan-tap.png') }}" alt="Scan or Tap"
                            style="width: 40px;">
                        <p class="mb-0 mt-2 fw-bold">Scan or Tap</p>
                        <small class="d-block text-muted">Get Rewards & more</small>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
