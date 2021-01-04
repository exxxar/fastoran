@extends('mobile.layouts.app')

@section('content')
    @include("mobile.partials.restorans.restoran-info")
    <div class="divider mt-1 mb-1"></div>
    <mobile-product-list restoran_id="{{$restoran->parent_id}}"></mobile-product-list>

    <div class="divider mt-2 mb-2"></div>
    @include("mobile.partials.main.section_title",[ "title"=>"Категории", "muted"=>"Еще больше категорий", "link"=>route('mobile.tags-cloud')])


    @include("mobile.partials.main.button_carousel")

    <div class="divider mb-3 "></div>

    @include("mobile.partials.main.section_title",[ "title"=>"Рестораны", "muted"=>"Еще больше еды", "link"=>route('mobile.restorans')])

    @include("mobile.partials.main.post_carousel")

    @include("mobile.partials.bottom_menu",["active"=>0])
@endsection
