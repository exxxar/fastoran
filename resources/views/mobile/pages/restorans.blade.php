@extends('mobile.layouts.app')

@section('content')
    <mobile-restorans :restorans="{{$restorans}}"></mobile-restorans>
    @include("mobile.partials.bottom_menu",["active"=>0])
@endsection
