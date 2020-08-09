@extends('mobile.layouts.app')

@section('content')
    <div class="mt-2"></div>

    @include("mobile.partials.main.section_title",[ "title"=>$section->name, "muted"=>"Секция"])

    <mobile-restorans :restorans="{{$section->restorans}}"></mobile-restorans>

    @include("mobile.partials.main.section_title",[ "title"=>"Товары", "muted"=>"Наши направления"])
    <mobile-sections></mobile-sections>
    @include("mobile.partials.bottom_menu",["active"=>-1])
@endsection
