@extends('layouts.app')

@section('content')
    @include("fastoran.partials.header")
    @include("fastoran.partials.ht__bradcaump__area",["title"=>$kitchen->name??'Выбор ресторана в городе'])

    @include("fastoran.partials.popular__food__area")

    @include("fastoran.partials.food__contact__form")
    @include("fastoran.partials.footer__area")


@endsection
