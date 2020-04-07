@extends('layouts.app')

@section('content')
    @include("fastoran.partials.header")
    @include("fastoran.partials.ht__bradcaump__area",["title"=>"Оформление заказа"])

    @include("fastoran.partials.htc__checkout")
    @include("fastoran.partials.footer__area")
@endsection
