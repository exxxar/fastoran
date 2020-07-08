@extends('mobile.layouts.app')

@section('content')
    <div class="splashBlock">
        <div class="mb-3 mt-3">
            <img src="{{asset('/img/index-logo1.png')}}" alt="Fastoran" class="img-thumbnail" style="border:none">
        </div>

        <div class="sectionTitle text-center">
            <div class="title">
                <h1>Спасибо за проявленный <br>интерес к нашему сервису!</h1>
            </div>
            <div class="lead">
               В ближайшее время в данном разделе будет размещено пользовательское соглашение
            </div>
        </div>

    </div>

    @include("mobile.partials.bottom_menu",["active"=>-1])
@endsection
