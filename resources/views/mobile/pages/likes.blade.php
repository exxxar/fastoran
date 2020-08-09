@extends('mobile.layouts.app')

@section('content')
    <div class="mt-2"></div>
    @include("mobile.partials.main.section_title",[ "title"=>"Мне понравилось", "muted"=>"Из заказов"])
    <p><em>
            Каждый ваш товар, который вы заказываете - попадает в список понравившихся и остается до тех пор пока вы не решите убрать его из этого списка!
        </em>
    </p>
    <mobile-likes-product-list></mobile-likes-product-list>
    @include("mobile.partials.bottom_menu",["active"=>-1])
@endsection
