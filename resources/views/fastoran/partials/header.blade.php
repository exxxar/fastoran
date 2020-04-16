<header class="htc__header bg--yellow">
    <!-- Start Mainmenu Area -->
    <div id="sticky-header-with-topbar" class="mainmenu__wrap sticky__header is-sticky">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-sm-4 col-md-6 order-1 order-lg-1">
                    <div class="logo">
                        <a href="{{url('/')}}">
                            <img src="{{asset('/img/header-logo-2.png')}}" alt="logo images">
                        </a>
                    </div>
                </div>
                <div class="col-lg-9 col-sm-4 col-md-2 order-3 order-lg-2">
                    <div class="main__menu__wrap">
                        <nav class="main__menu__nav d-none d-lg-block">
                            <ul class="mainmenu">
                                <li class="drop"><a href="#restorans">Рестораны</a>
                                    <ul class="dropdown__menu">
                                        @foreach($restorans as $rest)
                                            <li><a href="{{route("rest",$rest->url)}}">{{$rest->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="drop"><a href="#kitchens">Кухни</a>
                                    <ul class="dropdown__menu">
                                        @foreach($header_kitchen_list as $hkitchen)
                                            <li><a href="{{route("kitchen",$hkitchen->id)}}">{{$hkitchen->name}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
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
                                    <div class="d-sm-none">
                                        <a  href="{{route('contacts')}}">Контакты</a>
                                    </div>

                                    <div class="d-none d-sm-block">
                                        <a  href="#contacts" data-toggle="modal"
                                            data-target="#contactModalBox">Контакты</a>
                                    </div>

                                </li>
                            </ul>
                        </nav>

                    </div>
                </div>
                <div class="col-lg-1 col-sm-4 col-md-4 order-2 order-lg-3">
                    <div class="header__right d-flex justify-content-end">
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
                            <a class="minicart-trigger" href="#"><i class="zmdi zmdi-shopping-basket"></i></a>
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
