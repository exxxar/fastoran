@extends('mobile.layouts.app')

@section('content')
    <div class="mt-2"></div>
    @include("mobile.partials.main.section_title",[ "title"=>"История ваших заказов", "muted"=>"Статистика"])

    <mobile-order-history></mobile-order-history>


    @include("mobile.partials.bottom_menu",["active"=>-1])



@endsection
