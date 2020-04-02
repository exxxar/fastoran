@extends('layouts.app')

@section('content')
    {{--@include("partials.main-slider")--}}
    {{--  @include("partials.filters")
      @include("partials.kitchens")
      @include("partials.restorans")
      @include("partials.discount")
      @include("partials.points")
      @include("partials.delivery")--}}

    <!-- Start Header Area -->
    @include("fastoran.partials.header")
    <!-- End Header Area -->
    <!-- Start Slider Area -->
    @include("fastoran.partials.slider")
    <!-- End Slider Area -->
    <!-- Start Feature Area -->
    @include("fastoran.partials.food_feature")
    <!-- End Feature Area -->
    <!-- Start Choose us Area -->
    @include("fastoran.partials.food_choose_us")
    <!-- End Choose us Area -->
    <!-- Start Special Offer -->
    @include("fastoran.partials.food__special__offer")
    <!-- End Special Offer -->
    <!-- Start Popular Food Area -->
    @include("fastoran.partials.popular__food__area")
    <!-- End Popular Food Area -->
    <!-- Start Our Team Area -->
    {{--@include("fastoran.partials.food__team__area")--}}
    <!-- End Our Team Area -->
    <!-- Start Food Staf Area -->
    {{--  @include("fastoran.partials.food__stuff__area")--}}
    <!-- End Food Staf Area -->
    <!-- Start Blog Area -->
    {{--@include("fastoran.partials.fb__blog__area")--}}
    <!-- End Blog Area -->
    <!-- Start Testimonial Area -->
    @include("fastoran.partials.food__testimonial__area")
    <!-- End Testimonial Area -->

    <!-- Start Counter Up Area -->
    @include("fastoran.partials.fd__counterup__area")
    <!-- End Counter Up Area -->
    <!-- Start Our Brand Area -->
    @include("fastoran.partials.food__brand__area")
    <!-- End Our Brand Area -->

    <!-- Start Google Map -->
    {{--@include("fastoran.partials.htc__google__map")--}}
    <!-- End Google Map -->

    <!-- Start Subscribe Area -->
    @include("fastoran.partials.fd__subscribe__wrapper")
    <!-- End Subscribe Area -->

    <!-- Start Footer Area -->
    @include("fastoran.partials.food__contact")
    @include("fastoran.partials.food__contact__form")
    @include("fastoran.partials.footer__area")

    <!-- End Footer Area -->
    <!-- Login Form -->
    @include("fastoran.partials.login-box")
    <!-- Cartbox -->
    @include("fastoran.partials.cart-box")
@endsection
