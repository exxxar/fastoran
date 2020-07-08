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

    <div class="divider mt-4 mb-4"></div>

    <!-- Iconed Box -->
    <div class="row">
        <!-- item -->
        <div class="col-6">
            <div class="iconedBox">
                <div class="iconWrap bg-primary">
                    <i class="icon ion-ios-apps"></i>
                </div>
                <h4 class="title">Components</h4>
                Use the lastest easy to use components.
            </div>
        </div>
        <!-- item -->
        <!-- item -->
        <div class="col-6">
            <div class="iconedBox">
                <div class="iconWrap bg-danger">
                    <i class="icon ion-ios-cut"></i>
                </div>
                <h4 class="title">UX Based</h4>
                We designed Bitter UX based, simple and clean.
            </div>
        </div>
        <!-- item -->
        <!-- item -->
        <div class="col-6">
            <div class="iconedBox">
                <div class="iconWrap bg-success">
                    <i class="icon ion-ios-folder-open"></i>
                </div>
                <h4 class="title">Well Documented</h4>
                With Bitter you can easily build and edit the theme.
            </div>
        </div>
        <!-- item -->
        <!-- item -->
        <div class="col-6">
            <div class="iconedBox">
                <div class="iconWrap bg-info">
                    <i class="icon ion-ios-thumbs-up"></i>
                </div>
                <h4 class="title">Ready to build</h4>
                Does not require long installation.
            </div>
        </div>
        <!-- item -->
    </div>
    <!-- * Iconed Boxes -->

    <div class="divider mt-2 mb-4"></div>

    <div class="sectionTitle mb-2">
        <div class="title">
            <h1>Our Office</h1>
        </div>
        <div class="lead">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
        </div>
    </div>

    <!-- Gallery Carousel -->
    <div class="basicCarousel owl-carousel owl-loaded owl-drag">


        <div class="owl-stage-outer">
            <div class="owl-stage"
                 style="transform: translate3d(-603px, 0px, 0px); transition: all 0s ease 0s; width: 2493px; padding-left: 40px; padding-right: 40px;">
                <div class="owl-item cloned" style="width: 281.6px; margin-right: 20px;">
                    <div class="item">
                        <img src="assets/img/sample/photo3.jpg" alt="image" class="imageBlock img-fluid rounded">
                    </div>
                </div>
                <div class="owl-item cloned" style="width: 281.6px; margin-right: 20px;">
                    <div class="item">
                        <img src="assets/img/sample/photo4.jpg" alt="image" class="imageBlock img-fluid rounded">
                    </div>
                </div>
                <div class="owl-item active" style="width: 281.6px; margin-right: 20px;">
                    <div class="item">
                        <img src="assets/img/sample/photo1.jpg" alt="image" class="imageBlock img-fluid rounded">
                    </div>
                </div>
                <div class="owl-item" style="width: 281.6px; margin-right: 20px;">
                    <div class="item">
                        <img src="assets/img/sample/photo2.jpg" alt="image" class="imageBlock img-fluid rounded">
                    </div>
                </div>
                <div class="owl-item" style="width: 281.6px; margin-right: 20px;">
                    <div class="item">
                        <img src="assets/img/sample/photo3.jpg" alt="image" class="imageBlock img-fluid rounded">
                    </div>
                </div>
                <div class="owl-item" style="width: 281.6px; margin-right: 20px;">
                    <div class="item">
                        <img src="assets/img/sample/photo4.jpg" alt="image" class="imageBlock img-fluid rounded">
                    </div>
                </div>
                <div class="owl-item cloned" style="width: 281.6px; margin-right: 20px;">
                    <div class="item">
                        <img src="assets/img/sample/photo1.jpg" alt="image" class="imageBlock img-fluid rounded">
                    </div>
                </div>
                <div class="owl-item cloned" style="width: 281.6px; margin-right: 20px;">
                    <div class="item">
                        <img src="assets/img/sample/photo2.jpg" alt="image" class="imageBlock img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>
        <div class="owl-nav disabled">
            <button type="button" role="presentation" class="owl-prev"><span aria-label="Previous">‹</span></button>
            <button type="button" role="presentation" class="owl-next"><span aria-label="Next">›</span></button>
        </div>
        <div class="owl-dots disabled"></div>
    </div>
    <!-- * Gallery Carousel -->

    <div class="divider mt-4 mb-4"></div>

    <div class="sectionTitle mb-1">
        <div class="title">
            <h1>Meet the Team</h1>
        </div>
        <div class="lead">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit.
        </div>
    </div>

    <!-- listview -->
    <div class="listView detailed">
        <a href="#" class="listItem">
            <div class="image">
                <img src="assets/img/sample/avatar.jpg" alt="avatar">
            </div>
            <div class="text">
                <div>
                    <strong>Carmen Beltrán</strong>
                    <div class="text-muted">
                        Founder
                    </div>
                </div>
            </div>
        </a>
        <a href="#" class="listItem">
            <div class="image">
                <img src="assets/img/sample/avatar2.jpg" alt="avatar">
            </div>
            <div class="text">
                <div>
                    <strong>Furmaan Bharyar</strong>
                    <div class="text-muted">
                        Product Designer
                    </div>
                </div>
            </div>
        </a>
        <a href="#" class="listItem">
            <div class="image">
                <img src="assets/img/sample/avatar3.jpg" alt="avatar">
            </div>
            <div class="text">
                <div>
                    <strong>Kari Granleese</strong>
                    <div class="text-muted">
                        Front-end Developer
                    </div>
                </div>
            </div>
        </a>
        <a href="#" class="listItem">
            <div class="image">
                <img src="assets/img/sample/avatar4.jpg" alt="avatar">
            </div>
            <div class="text">
                <div>
                    <strong>Jurriaan van der Broek</strong>
                    <div class="text-muted">
                        Front-end Developer
                    </div>
                </div>
            </div>
        </a>

    </div>
    <!-- * listview -->


    <div class="divider mt-3 mb-4"></div>


    <div class="sectionTitle mb-1">
        <div class="title">
            <h1>Наши контакты</h1>
        </div>
        <div class="lead">
            <iframe src="https://yandex.ua/map-widget/v1/?um=constructor%3A5382f9a256f81aa0d9df51f8332ed3476c0e101bd208fe77b67e4bd45547d667&amp;source=constructor" style="width:100%;height:400px;" frameborder="0"></iframe>
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
                    <strong>+1 984 225 00 00</strong>
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
                    <strong>hello@domain.com</strong>
                </div>
            </div>
        </a>
        <a href="#" class="listItem">
            <div class="image">
                <div class="iconBox bg-success bg-facebook">
                    <i class="icon ion-logo-facebook"></i>
                </div>
            </div>
            <div class="text">
                <div>
                    <strong>Bitter</strong>
                </div>
            </div>
        </a>
        <a href="#" class="listItem">
            <div class="image">
                <div class="iconBox bg-success bg-twitter">
                    <i class="icon ion-logo-twitter"></i>
                </div>
            </div>
            <div class="text">
                <div>
                    <strong>BitterUI</strong>
                </div>
            </div>
        </a>
        <a href="#" class="listItem">
            <div class="image">
                <div class="iconBox bg-success bg-instagram">
                    <i class="icon ion-logo-instagram"></i>
                </div>
            </div>
            <div class="text">
                <div>
                    <strong>Bitter</strong>
                </div>
            </div>
        </a>
        <a href="#" class="listItem">
            <div class="image">
                <div class="iconBox bg-success bg-linkedin">
                    <i class="icon ion-logo-linkedin"></i>
                </div>
            </div>
            <div class="text">
                <div>
                    <strong>Bitter</strong>
                </div>
            </div>
        </a>
        <a href="#" class="listItem">
            <div class="image">
                <div class="iconBox bg-success bg-twitch">
                    <i class="icon ion-logo-twitch"></i>
                </div>
            </div>
            <div class="text">
                <div>
                    <strong>Bitter</strong>
                </div>
            </div>
        </a>
        <a href="#" class="listItem">
            <div class="image">
                <div class="iconBox bg-success bg-whatsapp">
                    <i class="icon ion-logo-whatsapp"></i>
                </div>
            </div>
            <div class="text">
                <div>
                    <strong>Send us a message</strong>
                </div>
            </div>
        </a>
    </div>
    <!-- * listview -->


@endsection
