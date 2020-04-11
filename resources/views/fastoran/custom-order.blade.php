@extends('layouts.app')

@section('content')
 @include("fastoran.partials.header")

 @include("fastoran.partials.ht__bradcaump__area",["title"=>"Пользовательский заказ"])
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="custom-order">
                    <h2 class="text-center mb-5">Закажи любой товар</h2>
                    <custom-order></custom-order>
                </div>

            </div>
        </div>
    </div>
</section>
 @include("fastoran.partials.footer__area")
@endsection
