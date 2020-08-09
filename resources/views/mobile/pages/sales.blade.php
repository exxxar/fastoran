@extends('mobile.layouts.app')

@section('content')
    <div class="mt-2"></div>
    @include("mobile.partials.main.section_title",[ "title"=>"СкидкоМания", "muted"=>"Найди скидку"])
    <mobile-discount-product-list></mobile-discount-product-list>
    @include("mobile.partials.bottom_menu",["active"=>-1])
@endsection
