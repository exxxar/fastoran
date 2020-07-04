@extends('mobile.layouts.app')

@section('content')
    <mobile-tags-cloud></mobile-tags-cloud>
    @include("mobile.partials.bottom_menu",["active"=>0])
@endsection
