@extends('frontend.layouts.master')

@section('content')
    <!-- HERO SECTION -->
<section class="home_hero" style="padding-top: 10px; padding-bottom: 10px;">
   
        <!-- Carousel -->
        <div id="carouselExampleIndicators" class="carousel slide mt-3" data-bs-ride="carousel"
             style="height: 400px;">
            <div class="carousel-inner rounded shadow" style="height: 100%; width: 100%;">
                <div class="carousel-item active">
                    <img src="{{ asset('frontend/images/ban1.jpg') }}" class="d-block w-100 img-fluid rounded"
                         style="height: 100%; object-fit: cover;" alt="Noodle 1">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('frontend/images/ban2.jpg') }}" class="d-block w-100 img-fluid rounded"
                         style="height: 100%; object-fit: cover;" alt="Noodle 2">
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

    </div>
</section>

<section class="home_actions py-4" style="background-color: #fff;">
    <div class="container">
        <div class="row g-0 text-center"> <!-- Mengurangi jarak antar kolom dengan g-0 -->
            <!-- Start Order Card (Clickable) -->
            <div class="col-md-6 mb-3"> <!-- Menambahkan margin bawah -->
                <a href="{{ route('menu') }}" class="card-link">
                    <div class="border rounded p-5 h-100 shadow-sm d-flex flex-column align-items-center justify-content-center" style="height: 300px;">
                        <p class="mb-0 mt-2 fw-bold">Start Order</p>
                        <img src="{{ asset('frontend/images/or.png') }}" alt="Start Order" class="img-fluid" style="max-height: 180px; object-fit: contain;">
                    </div>
                </a>
            </div>
            <!-- Scan or Tap Card (Clickable) -->
            <div class="col-md-6 mb-3"> <!-- Menambahkan margin bawah -->
                <a href="{{ route('home') }}" class="card-link">
                    <div class="border rounded p-5 h-100 shadow-sm d-flex flex-column align-items-center justify-content-center" style="height: 300px;">
                        <p class="mb-0 mt-2 fw-bold">Scan or Tap</p>
                        <img src="{{ asset('frontend/images/scan.png') }}" alt="Scan or Tap" class="img-fluid" style="max-height: 180px; object-fit: contain;">
                        <small class="d-block text-muted">Get Rewards & more</small>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection
