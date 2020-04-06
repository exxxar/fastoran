@extends('layouts.app')

@section('content')
    @include("fastoran.partials.header")

    @include("fastoran.partials.ht__bradcaump__area",["title"=>"Пользовательское соглашение"])

    @include("fastoran.partials.footer__area")
@endsection
