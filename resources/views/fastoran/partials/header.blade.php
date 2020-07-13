<header class="htc__header bg--yellow">
    <!-- Start Mainmenu Area -->
    <div id="sticky-header-with-topbar" class="mainmenu__wrap sticky__header is-sticky">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-sm-4 col-md-6 order-1 order-lg-1">
                    <div class="logo">
                        <a href="{{url('/')}}" aria-label="Главная страница">
                            <img src="{{asset('/img/header-logo-2.png')}}" alt="logo images">
                        </a>
                    </div>
                </div>
                <div class="col-lg-9 col-sm-4 col-md-2 order-3 order-lg-2">
                    <div class="main__menu__wrap">
                        <nav class="main__menu__nav d-none d-lg-block">
                            <ul class="mainmenu">
                                <li class="drop"><a href="#restorans" aria-label="Переход к разделу ресторанов">Рестораны</a>
                                    <ul class="dropdown__menu">
                                        @foreach($restorans as $rest)
                                            <li><a href="{{route("rest",$rest->url)}}">{{$rest->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                                {{-- <li class="drop"><a href="#kitchens" aria-label="Переход к разделу кухонь">Кухни</a>
                                     <ul class="dropdown__menu">
                                         @foreach($header_kitchen_list as $hkitchen)
                                             <li><a aria-label="Кухня:{{$hkitchen->name}}" href="{{route("kitchen",$hkitchen->id)}}">{{$hkitchen->name}}</a>
                                             </li>
                                         @endforeach
                                     </ul>
                                 </li>--}}
                                {{--<li class="drop"><a href="{{route("faq")}}">F.A.Q.</a>
                                    <ul class="dropdown__menu">
                                        <li><a href="{{route("cart")}}">Корзина</a></li>
                                        <li><a href="{{route("faq")}}">Руководство пользователя</a></li>
                                        <li><a href="{{route("questions")}}">Вопросы и ответы</a></li>
                                        <li><a href="{{route("agreement")}}">Пользовательское соглашение</a></li>
                                        <li><a href="{{route("terms")}}">Как мы работаем</a></li>
                                        <li><a href="{{route("about")}}">О нас</a></li>
                                    </ul>
                                </li>--}}
                                <li>

                                    <a aria-label="Раздел цветов" href="https://fastoran.com/rest/ona_hochet_dn">Цветы</a>

                                </li>
                                <li>
                                    <div class="d-sm-none">
                                        <a aria-label="Раздел контакты" href="{{route('contacts')}}">Партнерам</a>
                                    </div>

                                    <div class="d-none d-sm-block">
                                        <a aria-label="Раздел контакты" href="#contacts" data-toggle="modal"
                                           data-target="#contactModalBox">Партнерам</a>
                                    </div>
                                </li>

                                <li>
                                    <a aria-label="Раздел контакты" href="{{route('about')}}">О нас</a>

                                </li>
                            </ul>
                        </nav>

                    </div>
                </div>
                <div class="col-lg-1 col-sm-4 col-md-4 order-2 order-lg-3">
                    <div class="header__right d-flex justify-content-end">
                        <div class="log__in">
                            <a data-toggle="modal"
                               data-target="#profileModal"><i
                                    class="zmdi zmdi-account-o"></i></a>
                        </div>
                        {{--    @guest
                                <div class="log__in">
                                    <a href="{{route("login")}}"><i
                                            class="zmdi zmdi-account-o"></i></a>
                                </div>
                            @endguest

                            @auth
                                <div class="main__menu__wrap">
                                    <nav class="main__menu__nav d-none d-lg-block">
                                        <ul class="mainmenu">
                                            <li class="drop"><a href="{{route("faq")}}"><i
                                                        class="zmdi zmdi-account-o"></i></a>
                                                <ul class="dropdown__menu">
                                                    <li><a href="{{route("cart")}}">Корзина</a></li>
                                                    <li><a href="{{route("faq")}}">Руководство пользователя</a></li>
                                                    <li><a href="{{route("questions")}}">Вопросы и ответы</a></li>
                                                    <li><a href="{{route("agreement")}}">Пользовательское соглашение</a>
                                                    </li>
                                                    <li><a href="{{route("terms")}}">Как мы работаем</a></li>
                                                    <li><a href="{{route("about")}}">О нас</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            @endauth--}}

                        <div class="shopping__cart">
                            <a class="minicart-trigger" aria-label="Корзина товаров" href="#"><i
                                    class="zmdi zmdi-shopping-basket"></i></a>
                            <div class="shop__qun">
                                <span> <cart-count-index></cart-count-index> </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu -->
            <div class="mobile-menu d-block d-lg-none"></div>
            <!-- Mobile Menu -->
        </div>
    </div>
    <!-- End Mainmenu Area -->
</header>
