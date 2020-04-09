@extends('layouts.admin')

@section("content")
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h1>Стоп лист ресторана {{$restoran->name}}</h1>
                <stop-list :restoran="{{json_encode($restoran)}}"></stop-list>
            </div>
        </div>
    </div>
@endsection
