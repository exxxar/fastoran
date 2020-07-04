<!-- Sidebar Menu -->
<div class="sidebarWrapper">
    <div class="overlay toggleSidebar"></div>
    <nav class="sidebar">
        <div class="profilebox">
            <img src="https://sun9-55.userapi.com/c638621/v638621489/19a5a/oPJ6fWyDhmk.jpg" alt="avatar" class="avatar">
            <h2 class="title">Fastoran</h2>
            <h5 class="lead">
                <i class="icon ion-ios-pin mr-1"></i>
                Донецк
            </h5>
            <div class="button">
                <a href="#">
                    <i class="icon ion-ios-settings"></i>
                </a>
            </div>
        </div>
        <div class="sidebarGroup ">
            <ul class="sidebarMenu upperSidebar">
                <li>
                    <a href="{{route("mobile.phone-order")}}">
                        <i class="fas fa-phone-volume"></i>
                        Заказать по телефону
                    </a>
                </li>
                <li>
                    <a href="{{route("mobile.product-order")}}">
                        <i class="fab fa-shopify"></i>
                        Продукты из магазина
                    </a>
                </li>
                <li>
                    <a href="{{route("mobile.flowers-order")}}">
                        <i class="fas fa-spa"></i>
                        Цветы и букеты
                    </a>
                </li>
                <li>
                    <a href="{{route("mobile.restorans")}}">
                        <i class="fas fa-utensils"></i>
                        Рестораны
                    </a>
                </li>
                <li>
                    <a href="{{route("mobile.tags-cloud")}}">
                        <i class="fas fa-pizza-slice"></i>
                        Категории продуктов
                    </a>
                </li>
                <li>
                    <a href="{{route('mobile.status')}}">
                        <i class="fas fa-info-circle"></i>
                        Статус заказ
                    </a>
                </li>
                <li>
                    <a href="blog-home.html">
                        <i class="far fa-question-circle"></i>
                        Обратная связь
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidebarGroup">
            <ul class="sidebarMenu">
                <li class="title">Собери вкусняшки</li>
                <li>
                    <a href="{{route('calcs',1)}}">
                        <img src="{{asset('images/fastoran/chelentano-calc.jpg')}}" alt="avatar" class="avatar">
                        Пицца \ Блинчики
                    </a>
                </li>
                <li>
                    <a href="{{route('calcs',2)}}">
                        <img src="{{asset('images/fastoran/isushi-calc.jpg')}}" alt="avatar" class="avatar">
                        Роллы
                    </a>
                </li>
                <li>
                    <a href="{{route('calcs',3)}}">
                        <img src="{{asset('images/fastoran/burger-bar-calc.jpg')}}" alt="avatar" class="avatar">
                        Хот-доги \ Гонконгские вафли
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebarGroup">
            <ul class="sidebarMenu">
                <li class="title">Мы в соц. сетях</li>
                <li>
                    <a href="https://vk.com/fastorancom">
                        <i class="icon ion-logo-vk"></i>
                        Мы Вконтакте
                    </a>
                </li>
                <li>
                    <a href="https://www.instagram.com/fastoran_dn/">
                        <i class="icon ion-logo-instagram"></i>
                        Instagram
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebarGroup">
            <ul class="sidebarMenu">
                <li class="title">Telegram боты партнеров</li>
                <li>
                    <a href="https://t.me/diner_dn_bot" target="_blank">
                        <img src="{{asset('images/fastoran/diner-bot.jpg')}}" alt="avatar" class="avatar">
                        Ресторан "Diner"
                    </a>
                </li>
                <li>
                    <a href="https://t.me/isushibot" target="_blank">
                        <img src="{{asset('images/fastoran/isushi-bot.jpg')}}" alt="avatar" class="avatar">
                        Ресторан "Isushi"
                    </a>
                </li>
                <li>
                    <a href="https://t.me/svinya_dn_bot" target="_blank">
                        <img src="{{asset('images/fastoran/svinya-bot.jpg')}}" alt="avatar" class="avatar">
                        Гастропаб "Свинья"
                    </a>
                </li>
                <li>
                    <a href="https://t.me/arkadia_donetsk_bot" target="_blank">
                        <img src="{{asset('images/fastoran/arcadia-bot.jpg')}}" alt="avatar" class="avatar">
                        Ресторан "Аркадия"
                    </a>
                </li>
                <li>
                    <a href="https://t.me/pirogi_dn_bot" target="_blank">
                        <img src="{{asset('images/fastoran/pirogi-bot.jpg')}}" alt="avatar" class="avatar">
                        Осетинские пироги
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</div>
<!-- * Sidebar Menu -->
