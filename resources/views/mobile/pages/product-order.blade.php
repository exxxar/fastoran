@extends('mobile.layouts.app')

@section('content')
    <div class="mt-2"></div>
    <h6 class="text-center">Теперь каждый пользователь сможет посетить нашу продуктовую лавку!</h6>
    <a href="/m/sections/2"  style="display: block" title="Цветочная лавка" >
        <img src="/images/fastoran/sections/products.jpg" alt="Продукты Fastoran" class="img-fluid">
    </a>
    <a href="/m/sections/2"  class="mb-2 btn btn-outline-success w-100" title="Продуктове лавки" >
        Продуктовые лавки
    </a>
    <h6 class="text-center mb-2">Либо, закажите продукты из любых магазинов города!</h6>
    @include("mobile.partials.main.section_title",[ "title"=>"Заказ продуктов", "muted"=>"На ваш выбор"])
    <mobile-custom-order></mobile-custom-order>

    @include("mobile.partials.bottom_menu",["active"=>-1])



@endsection
