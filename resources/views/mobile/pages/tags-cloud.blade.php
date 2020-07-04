@extends('mobile.layouts.app')

@section('content')
    <div class="mt-2"></div>
    @include("mobile.partials.main.section_title",[ "title"=>"Доступные категории", "muted"=>"Товары"])
    <mobile-tags-cloud></mobile-tags-cloud>
    @include("mobile.partials.bottom_menu",["active"=>0])
@endsection
