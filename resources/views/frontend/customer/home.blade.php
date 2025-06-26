@extends('frontend.layouts.master')

@section('content')

<section class="hero-carousel">
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('frontend/images/ban1.jpg') }}" class="d-block w-100 hero-img" alt="Slide 1">
                <div class="carousel-caption d-flex flex-column justify-content-center align-items-center text-center">
                    <h1 class="hero-title">Velocity</h1>
                    <h5 class="hero-subtitle">Fast. Fresh. Flavorful.</h5>
                    <a href="#" class="btn btn-danger btn-lg px-4 py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#orderTypeModal">
                        ORDER NOW
                    </a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('frontend/images/ban2.jpg') }}" class="d-block w-100 hero-img" alt="Slide 2">
                <div class="carousel-caption d-flex flex-column justify-content-center align-items-center text-center">
                    <h1 class="hero-title">Velocity</h1>
                    <h5 class="hero-subtitle">Fast. Fresh. Flavorful.</h5>
                    <a href="#" class="btn btn-danger btn-lg px-4 py-2 fw-bold" data-bs-toggle="modal" data-bs-target="#orderTypeModal">
                        ORDER NOW
                    </a>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

<!-- Modal Order Type -->
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
            <button class="btn btn-outline-success px-4 py-2" onclick="selectOrderType('dinein')">Dine In</button>
            <button class="btn btn-outline-danger px-4 py-2" onclick="selectOrderType('takeaway')">Take Away</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Hidden form to send order_type to server -->
<form id="orderTypeForm" action="{{ route('order.type.set') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="order_type" id="order_type_input">
</form>

<script>
    function selectOrderType(type) {
        document.getElementById("order_type_input").value = type;
        document.getElementById("orderTypeForm").submit();
    }
</script>

<style>
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow-x: hidden;
    }

    .hero-carousel {
        position: relative;
        height: 100vh;
    }

    .hero-img {
        height: 100vh;
        object-fit: cover;
    }

    .carousel-caption {
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .hero-title {
        font-size: 4rem;
        font-weight: 700;
        color: #fff;
        text-shadow: 2px 2px 10px rgba(0,0,0,0.7);
    }

    .hero-subtitle {
        font-size: 1.5rem;
        color: #fff;
        margin-bottom: 1.5rem;
        text-shadow: 1px 1px 6px rgba(0,0,0,0.5);
    }

    .carousel-control-prev,
    .carousel-control-next {
        z-index: 15;
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }

        .hero-subtitle {
            font-size: 1rem;
        }
    }
</style>

@endsection
