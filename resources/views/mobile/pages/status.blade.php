@extends('mobile.layouts.app')

@section('content')
    <div class="mt-2"></div>
    @include("mobile.partials.main.section_title",[ "title"=>"Проверь свой заказ", "muted"=>"Продукт"])

    <mobile-order-status></mobile-order-status>


    @include("mobile.partials.bottom_menu",["active"=>1])



@endsection
