@extends('frontend.layouts.master')

@section('content')

<section class="fp__menu mt_95 xs_mt_65">
    <div class="container">

        {{-- Section Heading --}}
        <div class="row wow fadeInUp" data-wow-duration="1s">
            <div class="col-md-8 col-lg-7 col-xl-6 m-auto text-center">
                <div class="fp__section_heading mb_45">
                    <h4>Food Order KIOSK</h4>
                    <h2>Choose Your Favorite</h2>
                    <span>
                        <img src="{{ asset('images/heading_shapes.png') }}" alt="shapes" class="img-fluid w-100">
                    </span>
                    <p>Select from our most popular meals and appetizers</p>
                </div>
            </div>
        </div>

        {{-- Menu Cards --}}
        <div class="row grid mb-5">
            {{-- Chicken Biryani --}}
            <div class="col-xl-3 col-sm-6 col-lg-4 nonveg">
                <div class="fp__menu_item text-center">
                    <div class="fp__menu_item_img">
                        <img src="{{ asset('images/chicken-biryani.jpg') }}" alt="Chicken Biryani" class="img-fluid w-100">
                        <a class="category" href="#">Main Course</a>
                    </div>
                    <div class="fp__menu_item_text">
                        <h5 class="title">Chicken Biryani</h5>
                        <h5 class="price">$6.00</h5>
                        <button class="btn btn-danger mt-2 px-4 py-1">Customize</button>
                    </div>
                </div>
            </div>

            {{-- Veg Biryani --}}
            <div class="col-xl-3 col-sm-6 col-lg-4 veg">
                <div class="fp__menu_item text-center">
                    <div class="fp__menu_item_img">
                        <img src="{{ asset('images/veg-biryani.jpg') }}" alt="Veg Biryani" class="img-fluid w-100">
                        <a class="category" href="#">Main Course</a>
                    </div>
                    <div class="fp__menu_item_text">
                        <h5 class="title">Veg Biryani</h5>
                        <h5 class="price">$6.00</h5>
                        <button class="btn btn-warning mt-2 px-4 py-1">Add</button>
                    </div>
                </div>
            </div>

            {{-- Appetizer Example: Spring Rolls --}}
            <div class="col-xl-3 col-sm-6 col-lg-4 veg">
                <div class="fp__menu_item text-center">
                    <div class="fp__menu_item_img">
                        <img src="{{ asset('images/spring-rolls.jpg') }}" alt="Spring Rolls" class="img-fluid w-100">
                        <a class="category" href="#">Appetizer</a>
                    </div>
                    <div class="fp__menu_item_text">
                        <h5 class="title">Spring Rolls</h5>
                        <h5 class="price">$3.00</h5>
                        <button class="btn btn-warning mt-2 px-4 py-1">Add</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection
