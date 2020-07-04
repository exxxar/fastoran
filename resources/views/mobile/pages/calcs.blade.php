@extends('mobile.layouts.app')

@section('content')

    <mobile-calc-slider :active="{{intval($id)}}"></mobile-calc-slider>

    <div class="divider mt-2 mb-2"></div>
    @include("mobile.partials.main.section_title",[ "title"=>"Категории", "muted"=>"Еще больше категорий", "link"=>route('mobile.restorans')])


    @include("mobile.partials.main.button_carousel")

    <div class="divider mb-3"></div>

    @include("mobile.partials.main.section_title",[ "title"=>"Рестораны", "muted"=>"Еще больше еды", "link"=>route('mobile.restorans')])

    @include("mobile.partials.main.post_carousel")

    @include("mobile.partials.bottom_menu",["active"=>0])
@endsection
