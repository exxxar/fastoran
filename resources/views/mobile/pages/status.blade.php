@extends('mobile.layouts.app')

@section('content')
    <div class="mt-2"></div>

    @include("mobile.partials.main.section_title",["title"=>"Ваш заказ", "muted"=>"Статус", "link"=>route("mobile.history")])

    <mobile-order-status></mobile-order-status>


    @include("mobile.partials.bottom_menu",["active"=>1])



@endsection
