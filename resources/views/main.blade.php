@extends('layouts.app')

@section('content')
    {{--@include("partials.main-slider")--}}
    @include("partials.filters")
    @include("partials.kitchens")
    @include("partials.restorans")
    @include("partials.discount")
    @include("partials.points")
    @include("partials.delivery")
@endsection
