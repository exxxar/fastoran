@extends('layouts.app')

@section('content')
    @include("fastoran.partials.header")
    @include("fastoran.partials.ht__bradcaump__area",["title"=>$kitchen->name])
    {{--@include("partials.filters")--}}
    @include("partials.rest-list")
    @include("fastoran.partials.food__contact")
    @include("fastoran.partials.footer__area")


@endsection
