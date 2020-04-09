@extends('layouts.app')

@section('content')
 @include("fastoran.partials.header")

 @include("fastoran.partials.ht__bradcaump__area",["title"=>"Спасибо за заказ"])
 @include("fastoran.partials.food_success")
 @include("fastoran.partials.food__contact__form")
 @include("fastoran.partials.footer__area")
@endsection
