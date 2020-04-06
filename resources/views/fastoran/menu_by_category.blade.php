@extends('layouts.app')

@section('content')
    @include("fastoran.partials.header")
    @include("fastoran.partials.ht__bradcaump__area",["title"=>"Корзина"])

    @include("fastoran.partials.food__menu__grid__area")
    @include("fastoran.partials.footer__area")
@endsection
