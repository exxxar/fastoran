@extends('layouts.app')

@section('content')
    {{--@include("partials.main-slider")--}}
    {{--  @include("partials.filters")
      @include("partials.kitchens")
      @include("partials.restorans")
      @include("partials.discount")
      @include("partials.points")
      @include("partials.delivery")--}}



    @include("fastoran.partials.header")

    @include("fastoran.partials.food_slider_area_one")

    @include("fastoran.partials.fb__service__area")

    @include("fastoran.partials.popular__food__area")

 {{--   @switch($sliderIndex)
        @case(1)
        @include("fastoran.partials.food_slider_area_one")
        @break

        @case(2)
        @include("fastoran.partials.food_slider_area_two")
        @break

        @default
        @include("fastoran.partials.slider")
    @endswitch--}}
    @include("fastoran.partials.food__category__area")
    @include("fastoran.partials.food_choose_us")
    @include("fastoran.partials.food__stuff__area")
    @include("fastoran.partials.food__special__offer")

    {{--@include("fastoran.partials.food__team__area")--}}

    {{--@include("fastoran.partials.fb__blog__area")--}}

    @include("fastoran.partials.food__testimonial__area")
    @include("fastoran.partials.fd__counterup__area")

{{--    @include("fastoran.partials.food__brand__area")--}}

    {{--@include("fastoran.partials.htc__google__map")--}}
    @include("fastoran.partials.fd__subscribe__wrapper")
    {{--  @include("fastoran.partials.food__contact")--}}
    @include("fastoran.partials.food__contact__form")
    @include("fastoran.partials.footer__area")

    @include("fastoran.partials.login-box")

    @include("fastoran.partials.cart-box")

    @include("fastoran.partials.custom-order-box")
@endsection
