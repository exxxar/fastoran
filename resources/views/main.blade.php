@extends('layouts.app')

@section('content')
    @include("fastoran.partials.header")
    @include("fastoran.partials.food_slider_area_one")

    @include("fastoran.partials.food__category__area")

    <calc-slider></calc-slider>
    @include("fastoran.partials.fb__service__area")
    @include("fastoran.partials.popular__food__area")

    <tags-cloud-list></tags-cloud-list>
    {{--   @include("fastoran.partials.food__all_categories")--}}
    @include("fastoran.partials.food_choose_us")
    @include("fastoran.partials.food__stuff__area")
    @include("fastoran.partials.food__special__offer")
    {{--   @include("fastoran.partials.food__testimonial__area")--}}
    {{--   @include("fastoran.partials.fd__counterup__area")--}}
    {{--       @include("fastoran.partials.fd__subscribe__wrapper")--}}

    @include("fastoran.partials.food__contact")
    @include("fastoran.partials.food__contact__form")
    @include("fastoran.partials.footer__area")
@endsection
