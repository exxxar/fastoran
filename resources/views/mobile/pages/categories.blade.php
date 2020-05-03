@extends('mobile.layouts.app')

@section('content')
    <div class="mt-2"></div>
    @include("mobile.partials.main.section_title",[ "title"=>$category->name, "muted"=>"Продукты в категории"])
    @include("mobile.partials.categories.product-list")
    <div class="divider mt-2 mb-2"></div>
    @include("mobile.partials.main.button_carousel")
    <div class="divider mb-2"></div>
    <!-- Post Carousel -->
    @include("mobile.partials.main.section_title",[ "title"=>"Рестораны", "muted"=>"Больше вкусностей", "link"=>route('mobile.restorans')])
    @include("mobile.partials.main.post_carousel")
    <!-- * Post Carousel -->

    @include("mobile.partials.bottom_menu",["active"=>0])
@endsection
