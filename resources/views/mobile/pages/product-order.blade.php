@extends('mobile.layouts.app')

@section('content')
    <div class="mt-2"></div>
    @include("mobile.partials.main.section_title",[ "title"=>"Заказ по телефону", "muted"=>"На ваш выбор"])
    <mobile-custom-order></mobile-custom-order>
    @include("mobile.partials.bottom_menu",["active"=>1])



@endsection
