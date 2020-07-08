@extends('mobile.layouts.app')

@section('content')



    <div class="mt-2 mb-3">
        <img src="{{asset('/img/kit_rus.jpg')}}" alt="image" class="imageBlock img-fluid rounded">
    </div>

    <div class="sectionTitle mb-2">
        <div class="title">
            <h1>Fastoran - это...</h1>
        </div>
    </div>

    <div class="contentBox">
        <div class="contentBox-body">
            <p>Fastoran – это удобный сервис для быстрого и выгодного заказа блюд из ресторанов и кафе, продуктов из
                магазинов и аптек, а также любых других товаров вашего города. Fastoran создан для комфорта и удобства
                заказа любимых товаров. Выбирайте и сравнивайте блюда в меню различных заведений, добавляйте их корзину
                и оформляйте доставку за несколько кликов!
            </p>
            <ol>
                <li>Fastoran - это самый удобный сервис!</li>
                <li>Fastoran - это быстрая доставка!</li>
                <li>Fastoran - это Ваш комфорт!</li>
            </ol>
            <p>Наш сервис максимально упрощён и адаптирован для Вашего удобства. Сперва вы делаете заказ на сайте, затем
                он отправляется заведению, после чего курьер доставляет его прямиком к Вам.</p>

            <p><em>* Вы можете оформить доставку только из одного заведения одним заказом. При оформлении нескольких
                    параллельных заказов к вам прибудут несколько курьеров.</em></p>
        </div>
    </div>


    <div class="sectionTitle mb-1">
        <div class="title">
            <h1>Наши контакты</h1>
        </div>
        <div class="lead">
            <iframe
                src="https://yandex.ua/map-widget/v1/?um=constructor%3A5382f9a256f81aa0d9df51f8332ed3476c0e101bd208fe77b67e4bd45547d667&amp;source=constructor"
                style="width:100%;height:400px;" frameborder="0"></iframe>
        </div>
    </div>
    <!-- listview -->
    <div class="listView">
        <a href="#" class="listItem">
            <div class="image">
                <div class="iconBox bg-success">
                    <i class="icon ion-ios-call"></i>
                </div>
            </div>
            <div class="text">
                <div>
                    <strong>
                        +38 (071) 507-17-52</strong>
                </div>
            </div>
        </a>

        <a href="#" class="listItem">
            <div class="image">
                <div class="iconBox bg-primary">
                    <i class="icon ion-ios-mail"></i>
                </div>
            </div>
            <div class="text">
                <div>
                    <strong>
                        admin@fastoran.com</strong>
                </div>
            </div>
        </a>
        <a href="#" class="listItem">
            <div class="image">
                <div class="iconBox bg-success bg-facebook">
                    <i class="icon ion-ios-home"></i>
                </div>
            </div>
            <div class="text">
                <div>
                    <strong>
                        ул. 50-лет СССР, 144/3, Донецк</strong>
                </div>
            </div>
        </a>
       
    </div>
    <!-- * listview -->


@endsection
