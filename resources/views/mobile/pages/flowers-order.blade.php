@extends('mobile.layouts.app')

@section('content')
    <div class="mt-2"></div>
    @include("mobile.partials.main.section_title",[ "title"=>"Цветочная лавка", "muted"=>"Цветы на выбор"])
    <h6 class="text-center">Теперь каждый пользователь сможет посетить нашу цветочную лавку!</h6>
    <a href="/m/restoran/ona_hochet_dn"  style="display: block" title="Цветочная лавка" >
        <img src="/images/fastoran/restorans/flowers.jpg" alt="Цветы Fastoran" class="img-fluid">
    </a>
    <a href="/m/restoran/ona_hochet_dn" class="mb-2 btn btn-outline-info" title="Цветочная лавка" >
       Цветочная лавка
    </a>
    <h6 class="text-center mb-2">Либо, закажите звонок и наши флористы подберут букет под ваши пожелания!</h6>
    <mobile-flowers-order></mobile-flowers-order>
    @include("mobile.partials.bottom_menu",["active"=>-1])



@endsection
