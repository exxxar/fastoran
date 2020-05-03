@extends('mobile.layouts.app')

@section('content')
    <mobile-cart></mobile-cart>

    @include("mobile.partials.bottom_menu",["active"=>2])
@endsection
