@extends('mobile.layouts.app')

@section('content')
    <div class="mt-2"></div>

    @include("mobile.partials.main.section_title",[ "title"=>"Доступные заведения", "muted"=>"Партнеры"])
    <mobile-restorans :restorans="{{$restorans}}"></mobile-restorans>
    @include("mobile.partials.main.section_title",[ "title"=>"Товары", "muted"=>"Другие направления"])
    <mobile-sections></mobile-sections>
    @include("mobile.partials.bottom_menu",["active"=>3])
@endsection
