@extends('mobile.layouts.app')

@section('content')
    @include("mobile.partials.restorans.restorans-list")

    @include("mobile.partials.bottom_menu",["active"=>0])
@endsection
