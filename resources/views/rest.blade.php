@extends('layouts.app')

@section('content')


    @include("fastoran.partials.header")
    @include("fastoran.partials.ht__bradcaump__area",["title"=>$restoran->name])
    @include("partials.rest-info")
  {{--  @include("partials.rest-list")--}}
    @include("fastoran.partials.food__menu__grid__area")
{{--    @include("fastoran.partials.food__contact")--}}
    @include("fastoran.partials.footer__area")

@endsection
