@extends('mobile.layouts.app')

@section('content')
    <div class="mt-2"></div>

    @include("mobile.partials.main.section_title",[ "title"=>"Доступные города", "muted"=>"Наша локация"])
    <mobile-cities :cities="{{$cities}}"></mobile-cities>
    <div class="mt-2"></div>
    @include("mobile.partials.main.section_title",[ "title"=>"Товары", "muted"=>"Другие направления"])
    <mobile-sections></mobile-sections>
    @include("mobile.partials.bottom_menu",["active"=>3])
@endsection
