@extends('frontend.layouts.master')

@section('content')
    <!------   BANNER START ------>
    @include('frontend.customer.components.slider')
    <!------   BANNER END ------>


    <!------    WHY CHOOSE START ------>
    @include('frontend.customer.components.why-choose')
    <!------   WHY CHOOSE END ------>


    <!------===  OFFER ITEM START ===------>
    @include('frontend.customer.components.offer-item')

    <!-- CART POPUT START -->
    @include('frontend.customer.components.cart-popup')
    <!-- CART POPUT END -->

    <!----===  OFFER ITEM END ===---->


    <!---- MENU ITEM START ------>
    @include('frontend.customer.components.menu-item')
    <!------   MENU ITEM END ------>


    <!----  ADD SLIDER START ---->
    @include('frontend.customer.components.add-slider')
    <!---- ADD SLIDER END ---->


    <!----  TEAM START ---->
    @include('frontend.customer.components.team')
    <!---- TEAM END ---->


    <!----  DOWNLOAD APP START ---->
    @include('frontend.customer.components.app-download')
    <!----  DOWNLOAD APP END ---->


    <!---- TESTIMONIAL  START -->
    @include('frontend.customer.components.testimonial')
    <!---- TESTIMONIAL END ---->


    <!----  COUNTER START ---->
    @include('frontend.customer.components.counter')
    <!----  COUNTER END ---->

    <!----   BLOG 2 START ---->
    @include('frontend.customer.components.blog')
    <!----   BLOG 2 END ---->
@endsection
