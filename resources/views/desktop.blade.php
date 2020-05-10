<!DOCTYPE html>
<html lang="en" class="hydrated">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Fastoran - твоя доставка вкусной еды!</title>
    <link rel="stylesheet" href="{{asset('css/desktop/desktop.css')}}?ver={{env("APP_VERSION")}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="Bitter Bootstrap 4 Based Mobile Template">
    <meta name="keywords"
          content="Прилиожения, сервис доставки, доставка, донецк, фасторан, еда, рестораны">
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.esm.js"
            data-stencil-namespace="ionicons"></script>
    <script nomodule="" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js"
            data-stencil-namespace="ionicons"></script>
</head>
<style data-styles="">ion-icon {
        visibility: hidden
    }

    .hydrated {
        visibility: inherit
    }</style>
<body>

<div class="pageLoader" style="display: none;">
    <div class="in">
        <div class="imgWrapper">
            <img src="assets/img/logo.png" alt="logo" class="itemlogo">
            <div class="spin">
                <div class="spinner-border text-light" role="status"></div>
            </div>
        </div>
        <p>Загружаем мобильную версию...</p>
    </div>
</div>
<!-- hero -->
<div class="hero">
    <div class="container">

        <!-- content -->
        <div class="textContent" style="margin-top: 60px">

            <div class="hero-header">
                <div class="itemLogo">
                    <img src="{{asset('img/index-logo1.png')}}" alt="logo" class="image">
                </div>
            </div>


            <h1 class="heroTitle">
               Наши<br/>преимущества
            </h1>
            <div class="hero-content">
                <ul class="heroList">
                    <li>
                        <ion-icon name="checkmark-outline" role="img" class="md hydrated"
                                  aria-label="checkmark outline"></ion-icon>
                        Множество ресторанов
                    </li>
                    <li>
                        <ion-icon name="checkmark-outline" role="img" class="md hydrated"
                                  aria-label="checkmark outline"></ion-icon>
                        Быстрая доставка
                    </li>
                    <li>
                        <ion-icon name="checkmark-outline" role="img" class="md hydrated"
                                  aria-label="checkmark outline"></ion-icon>
                        Качественный сервис
                    </li>
                </ul>
            </div>


            <div class="buttonWrapper">
                <a href="#partnerModal" data-toggle="modal" data-target="#partnerModal"
                   class="btn btn-success mr-4" target="_blank">
                    <ion-icon name="cart-outline" role="img" class="md hydrated" aria-label="cart outline"></ion-icon>
                    Стать партнером
                </a>

                <a href="#qr" class="btn btn-secondary" id="hero-qr-button">
                    <ion-icon name="qr-code-outline" role="img" class="md hydrated"
                              aria-label="qr code outline"></ion-icon>
                    Воспользоваться сервисом
                </a>

            </div>

            <div class="qrBlock" style="display: none;">
                <img src="https://sun9-4.userapi.com/c854524/v854524588/22957a/GCEBPBdErgs.jpg" alt="qr" class="qr">
                <div class="text">
                    <strong>Попробовать на<br>мобильном устройстве</strong>
                   Отсканируй QR-код на своём телефоне
                </div>
            </div>


        </div>
        <!-- content -->

        <!-- phone -->
        <div class="phoneContent">
            <div class="phoneWrapper">
                <div class="in">
                    <iframe class="getFrame" src="{{route("mobile.index")}}" frameborder="0"></iframe>
                </div>
            </div>
        </div>
        <!-- phone -->


    </div>

</div>
<!-- * hero -->


<div class="qr-button" style="display: none;">
    <a href="javascript:;" class="close-button">
        <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
    </a>
    <img src="https://sun9-4.userapi.com/c854524/v854524588/22957a/GCEBPBdErgs.jpg" alt="qr" class="qr">
    <div class="text">
        <div class="qr-text">
            Отсканируй QR-код на своём телефоне
        </div>
    </div>
</div>

<div class="container">


    <!-- Features -->
    <div class="features">
        <div class="section-heading">
            <h2 class="title">Опробуй<br>качество услуг</h2>
        </div>


        <div class="feature-list">
            <div class="row">

                <div class="col-4">
                    <div class="item">
                        <div class="iconWrapper">
                            <img src="{{asset('img/icons/icon-96x96.png')}}" alt="cordova" style="margin-right: -2px;">
                        </div>
                        <div class="text">
                            <strong>Единая платформа доставки</strong>
                           Множество ресторанов-партнеров объединены под одним брендом.
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="item">
                        <div class="iconWrapper">
                            <ion-icon name="share" role="img" class="md hydrated"
                                      aria-label="share"></ion-icon>
                        </div>
                        <div class="text">
                            <strong>Открыты к сотруднчиеству</strong>
                            Приглашаем к сотрудничеству рестораторов и доставщиков!
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="item">
                        <div class="iconWrapper">
                            <ion-icon name="people" role="img" class="md hydrated"
                                      aria-label="people"></ion-icon>
                        </div>
                        <div class="text">
                            <strong>Ориентир на клиента</strong>
                            Постоянная поддержка и обновление системы.
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="item">
                        <div class="iconWrapper">
                            <ion-icon name="cart" role="img" class="md hydrated"
                                      aria-label="cart"></ion-icon>
                        </div>
                        <div class="text">
                            <strong>Удобство использования</strong>
                           Используем современные технологии для удобства наших пользователей.
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="item">
                        <div class="iconWrapper">
                            <ion-icon name="flash" role="img" class="md hydrated" aria-label="flash">
                            </ion-icon>
                        </div>
                        <div class="text">
                            <strong>Реклама</strong>
                            Ракламируем и продвигаем заведения наших партнеров.
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="item">
                        <div class="iconWrapper">
                            <ion-icon name="git-compare" role="img" class="md hydrated" aria-label="git compare">
                            </ion-icon>
                        </div>
                        <div class="text">
                            <strong>Уникальные сервисы</strong>
                            Наличие уникальных возможностей по доставке для наших клиентов!
                        </div>
                    </div>
                </div>


            </div>
        </div>


    </div>
    <!-- * Features -->


    <!-- qrWidget -->
    <div class="qrWidget" id="qr">
        <div class="section-heading">
            <h2 class="title">
                Попробуй <br>на своём <br>мобильном!
            </h2>
            <div class="text">
                Отсканируй QR, чтоб открыть приложение.
            </div>
        </div>
        <div class="qrCodeImg">
            <img src="https://sun9-4.userapi.com/c854524/v854524588/22957a/GCEBPBdErgs.jpg" alt="qr" class="img">
        </div>
    </div>
    <!-- * qrWidget -->


</div>


<div class="footer">
    <div class="container">
        Copyright © <a href="https://fastoran.com" target="_blank">Fastoran</a> 2020. All
        Rights Reserved.
        <a href="#" class="gotopButton">
            <ion-icon name="arrow-up" role="img" class="md hydrated" aria-label="arrow up"></ion-icon>
        </a>
    </div>
</div>


<div class="sidebar">
    <a href="#" class="toggleButton sidebarTrigger">
        <ion-icon name="arrow-forward-outline" role="img" class="md hydrated"
                  aria-label="arrow forward outline"></ion-icon>
    </a>
    <div class="sidebarTitle">
        Наши сервисы доставки
    </div>
    <div class="sidebarFooter">
        <a href="https://fastoran.com/contacts" class="btn btn-success" target="_blank">
            Хочу себе такой сервис
        </a>
    </div>
    <div class="sidebarProducts">
        <div class="row">
            <a href="https://fastoran.com/contacts" class="item col-6" data-name="Mobilekit"
               target="_blank"><img src="{{asset('img/icons/icon-96x96.png')}}" alt="Mobilekit"
                                    class="productlogo"><strong>Доставка из ресторана</strong>
                <div class="text">Организация сервиса заказ еды из ресторана для вашего сайта</div>
            </a>

            <a href="https://fastoran.com/contacts" class="item col-6" data-name="Mobilekit"
               target="_blank"><img src="{{asset('img/icons/icon-96x96.png')}}" alt="Mobilekit"
                                    class="productlogo"><strong>Доставка из магазина</strong>
                <div class="text">Организация сервиса заказ продуктов из торговых точек на вашем сайте</div>
            </a>

            <a href="https://fastoran.com/contacts" class="item col-6" data-name="Mobilekit"
               target="_blank"><img src="{{asset('img/icons/icon-96x96.png')}}" alt="Mobilekit"
                                    class="productlogo"><strong>Доставка из аптек</strong>
                <div class="text">Организация сервиса заказ лекарственных препаратов из аптечных пунктов через ваш сайт</div>
            </a>

            <a href="https://fastoran.com/contacts" class="item col-6" data-name="Mobilekit"
               target="_blank"><img src="{{asset('img/icons/icon-96x96.png')}}" alt="Mobilekit"
                                    class="productlogo"><strong>Доставка цветов</strong>
                <div class="text">Организация сервиса заказ цветов для мероприятий через ваш сайт</div>
            </a>

            <a href="https://fastoran.com/contacts" class="item col-6" data-name="Mobilekit"
               target="_blank"><img src="{{asset('img/icons/icon-96x96.png')}}" alt="Mobilekit"
                                    class="productlogo"><strong>Доставка предметов</strong>
                <div class="text">Организация сервиса вызова и работы курьера из точки А в точку Б для доставки прозвольного типа заказа</div>
            </a>
        </div>
    </div>
</div>

<div class="mobileDetected">
    <div class="in">
        <div><img src="{{asset('img/index-logo1.png')}}" alt="logo" class="logo"></div>
        Попробуй прямо сейчас!
        <div class="mt-5">
            <a href="{{route("mobile.index")}}" class="btn btn-success" target="_blank">Попробовать</a>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="partnerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script
    src="https://code.jquery.com/jquery-3.5.0.slim.min.js"
    integrity="sha256-MlusDLJIP1GRgLrOflUQtshyP0TwT/RHXsI1wWGnQhs="
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="{{asset('js/desktop/desktop.js')}}"></script>
<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>


<div id="fatkun-drop-panel">
    <a id="fatkun-drop-panel-close-btn">×</a>
    <div id="fatkun-drop-panel-inner">
        <div class="fatkun-content">
            <svg class="fatkun-icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg"
                 p-id="5892">
                <path
                    d="M494.933333 782.933333c2.133333 2.133333 4.266667 4.266667 8.533334 6.4h8.533333c6.4 0 10.666667-2.133333 14.933333-6.4l2.133334-2.133333 275.2-275.2c8.533333-8.533333 8.533333-21.333333 0-29.866667-8.533333-8.533333-21.333333-8.533333-29.866667 0L533.333333 716.8V128c0-12.8-8.533333-21.333333-21.333333-21.333333s-21.333333 8.533333-21.333333 21.333333v588.8L249.6 475.733333c-8.533333-8.533333-21.333333-8.533333-29.866667 0-8.533333 8.533333-8.533333 21.333333 0 29.866667l275.2 277.333333zM853.333333 874.666667H172.8c-12.8 0-21.333333 8.533333-21.333333 21.333333s8.533333 21.333333 21.333333 21.333333H853.333333c12.8 0 21.333333-8.533333 21.333334-21.333333s-10.666667-21.333333-21.333334-21.333333z"
                    p-id="5893"></path>
            </svg>
            <div class="fatkun-title">Drag and Drop</div>
            <div class="fatkun-desc">The image will be downloaded</div>
        </div>
    </div>
</div>
</body>
</html>
