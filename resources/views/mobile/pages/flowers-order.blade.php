@extends('mobile.layouts.app')

@section('content')
    <div class="mt-2"></div>
    @include("mobile.partials.main.section_title",[ "title"=>"Цветочная лавка", "muted"=>"Цветы на выбор"])
    <h6>Теперь каждый пользователь сможет посетить нашу цветочную лавку!</h6>
    <a href="/m/restoran/ona_hochet_dn" class="mb-2" style="display: block">
        <img src="/images/fastoran/restorans/flowers.jpg" alt="" class="img-fluid">
    </a>
    <h6>Либо, закажи звонок и наши флористы подберут букет под ваши пожелания!</h6>
    <mobile-flowers-order></mobile-flowers-order>
    @include("mobile.partials.bottom_menu",["active"=>1])



@endsection
