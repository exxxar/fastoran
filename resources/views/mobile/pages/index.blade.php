@extends('mobile.layouts.app')

@section('content')
    @include("mobile.partials.main.card_carousel")
    <!-- Post Carousel -->
    @include("mobile.partials.main.section_title",[ "title"=>"Рестораны", "muted"=>"Доставка еды", "link"=>route('mobile.restorans')])

    @include("mobile.partials.main.post_carousel")
    <!-- * Post Carousel -->
    <div class="divider mt-1 mb-2"></div>


    @include("mobile.partials.main.button_carousel")

    <div class="divider mb-2"></div>


    @include("mobile.partials.main.section_title",["title"=>"Меню", "muted"=>"Случайные товары", "link"=>route("mobile.restorans"),
     "lead"=>"Возможно, именно это ты и искал сегодня! Попробуй что-то новое."
    ])


    @include("mobile.partials.main.item_list")

    <div class="divider mt-4 mb-4"></div>

    @include("mobile.partials.main.section_title",["title"=>"Партнеры", "muted"=>"Телеграм-боты" ])


    @include("mobile.partials.main.partners_carousel")

{{--    @include("mobile.partials.main.post_list")--}}

    {{--<div class="divider mt-2 mb-4"></div>

    @include("mobile.partials.main.iconed_box")

    <div class="divider mt-2 mb-4"></div>




    @include("mobile.partials.main.listview")--}}

    @include("mobile.partials.main.section_title",["title"=>"Недавние заказы", "muted"=>"Что заказывают"])

    <mobile-latest-order></mobile-latest-order>

    @include("mobile.partials.bottom_menu",["active"=>0])
@endsection
