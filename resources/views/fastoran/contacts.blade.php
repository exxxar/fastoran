@extends('layouts.app')

@section('content')
    @include("fastoran.partials.header")

    @include("fastoran.partials.ht__bradcaump__area",["title"=>"Контакты"])
    {{--   @include("fastoran.partials.food__contact__form")--}}
    <section>
        <div class="container">
            <div class="row">

                <div class="col-sm-12 col-md-6 mt-5 mb-5">
                    <h4>Наши контакты:</h4>
                    <h5 class="mt-2"> Самый удобный сервис доставки</h5>

                    <ul class="mt-2">
                        <li>- быстрая скорость доставки;

                        </li>
                        <li> - низкая цена доставки, самый широкий ассортимент доставки(рестораны, магазины, аптеки,
                            цветы, подарки и многое другое);
                        </li>
                        <li> - удобный в пользовании сервис;</li>
                        <li> - разнообразный штат доставщиков (пешие, велосипедисты, автомобилисты);</li>
                    </ul>
                    <h5 class="mt-2">По вопросам сотрудничества:</h5>
                    <ul class="mt-2">
                        <li><a href="mailto:admin@fastoran.com">admin@fastoran.com</a></li>
                        <li><a href="tel:+380715071752"> +380 (71) 507-17-52</a></li>
                    </ul>
                </div>

                <div class="col-sm-12 col-md-6 mt-5 mb-5">
                    <contact-form></contact-form>
                </div>
            </div>
        </div>
    </section>
    @include("fastoran.partials.footer__area")
@endsection
