<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="text/html" charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fastoran - доставка блюд из любимых ресторанов в Донецке</title>
    <meta name="description"
          content="Быстрый и удобный сервис доставки еды со всех ресторанов города, суши, пицца, бургеры и много другое прямо к Вам домой"/>
    <link href='http://fastoran.com/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
    <link href='http://fastoran.com/css/style.css' rel='stylesheet' type='text/css'>
    <link href='http://fastoran.com/css/easydropdown.css' rel='stylesheet' type='text/css'>
    <link href='http://fastoran.com/css/owl.carousel.css' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>


</head>
<body>
<div id="app">
    <div class="register-overplay hidden hidden-sm hidden-md hidden-lg"></div>
    @include("partials.register")
    <section class="content">
        @include("partials.header")
        @yield("content")
    </section>
@include("partials.footer")

<!-- modal -->

    <div class="modal fade" tabindex="-1" role="dialog" id="basket">
        <div class="modal-dialog" role="document">
            <button type="button" class="close hidden-sm hidden-md hidden-lg" data-dismiss="modal" aria-label="Close">
                <img
                    src="http://fastoran.com/img/register-close-xs.png" alt=""></button>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close hidden-xs" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <div>
                        <div>
                            <h4 class="modal-title text-uppercase">корзина</h4>
                        </div>
                        <div>
                            <a href="#" class="clear-basket">Очистить корзину</a>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <!-- <p class="isempty hidden-sm hidden-md hidden-lg">К сожалению, в Вашей корзине ничего нет, <br/>попробуйте добавить блюда из <a href="#">каталога.</a></p> 	 -->
                    <ul class="basket-list">
                        <cart></cart>
                    </ul>
                    <div class="total-info">
                        <div><p>Сумма заказа <span><span class="total-price-order">0</span> руб</span></p></div>
                        <!-- <div><p>Стоимость доставки <span><span class="price-delivery">100</span> руб</span></p></div>
                        <div><p class="text-right">ИТОГО <span><span class="total-all">0</span> руб</span></p></div> -->
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <p class="hidden-xs">Минимальная сумма заказа составляет <span>1000</span> руб</p> -->
                    <button type="button" class="btn btn-warning formalization text-uppercase">оформить заказ</button>
                    <!-- <a href="#" class="history-order hidden-sm hidden-md hidden-lg">история заказов</a> -->
                    <!-- <div class="modal-order-history hidden-sm hidden-md hidden-lg">
                        <div class="modal-order-history-title">
                            <h4>история заказов</h4>
                        </div>
                        <div class="modal-order-history-body">
                            <div class="panel-group" id="history-accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title ">
                                            <a role="button" data-toggle="collapse" class="collapsed" data-parent="#history-accordion" href="#hostory-collapse-1" aria-expanded="true" aria-controls="hostory-collapse-1">
                                                Заказ № <span class="order-id">012 |</span> <span class="rest-name">Аркадия</span> <span class="date">2.09.2016, <span class="time">14:20</span></span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="hostory-collapse-1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <ul class="history-order">
                                                <li class="history-order-item">
                                                    <div><p>Бургер с курицей и солёным огурцом</p></div>
                                                    <div><p>2 шт</p></div>
                                                    <div><p>370 руб</p></div>
                                                </li>
                                                <li class="history-order-item">
                                                    <div><p>Бургер с курицей и солёным огурцом</p></div>
                                                    <div><p>2 шт</p></div>
                                                    <div><p>370 руб</p></div>
                                                </li>
                                                <li class="history-order-item system">
                                                    <div><p>Сумма заказа</p></div>
                                                    <div><p>370 руб</p></div>
                                                </li>
                                                <li class="history-order-item system">
                                                    <div><p>Сумма доставки</p></div>
                                                    <div><p>100 руб</p></div>
                                                </li>
                                                <li class="history-order-item system">
                                                    <div><p class="total">Итого</p></div>
                                                    <div><p class="total">470 руб</p></div>
                                                </li>
                                            </ul>
                                            <button type="button" class="btn btn-warning text-uppercase">повторить заказ</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title ">
                                            <a role="button" data-toggle="collapse" class="collapsed" data-parent="#history-accordion" href="#hostory-collapse-2" aria-expanded="true" aria-controls="hostory-collapse-2">
                                                Заказ № <span class="order-id">012 |</span> <span class="rest-name">Аркадия</span> <span class="date">2.09.2016, <span class="time">14:20</span></span>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="hostory-collapse-2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <ul class="history-order">
                                                <li class="history-order-item">
                                                    <div><p>Бургер с курицей и солёным огурцом</p></div>
                                                    <div><p>2 шт</p></div>
                                                    <div><p>370 руб</p></div>
                                                </li>
                                                <li class="history-order-item">
                                                    <div><p>Бургер с курицей и солёным огурцом</p></div>
                                                    <div><p>2 шт</p></div>
                                                    <div><p>370 руб</p></div>
                                                </li>
                                                <li class="history-order-item system">
                                                    <div><p>Сумма заказа</p></div>
                                                    <div><p>370 руб</p></div>
                                                </li>
                                                <li class="history-order-item system">
                                                    <div><p>Сумма доставки</p></div>
                                                    <div><p>100 руб</p></div>
                                                </li>
                                                <li class="history-order-item system">
                                                    <div><p class="total">Итого</p></div>
                                                    <div><p class="total">470 руб</p></div>
                                                </li>
                                            </ul>
                                            <button type="button" class="btn btn-warning text-uppercase">повторить заказ</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!--END modal basket-->
    <!-- modal basket-->
    <div class="modal fade" tabindex="-1" role="dialog" id="order">
        <div class="modal-dialog" role="document">
            <button type="button" class="close hidden-sm hidden-md hidden-lg" data-dismiss="modal" aria-label="Close">
                <img
                    src="http://fastoran.com/img/register-close-xs.png" alt=""></button>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close hidden-xs" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <div>
                        <div>
                            <h4 class="modal-title text-uppercase">корзина</h4>
                        </div>
                        <div>
                            <a href="#" class="edit-basket">&lt; редактировать заказ</a>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="" class="modal-form" id="zakaz_form">
                        <ul class="data-list">
                            <li class="form-group-3">
                                <div class="hidden-xs"><p>Ваше имя</p></div>
                                <div>
                                    <input class="" type="text" name="basket_name_desktop" id="basket_name_desktop"
                                           placeholder="Иванов Иван Иванович"/>
                                    <!-- <input class="hidden-sm hidden-md hidden-lg" name="basket_name_mobile" id="basket_name_mobile" type="text" placeholder="Иванов Иван Иванович"/> -->
                                </div>
                            </li>
                            <li>
                                <div class="hidden-xs"><p>Адрес доставки</p></div>
                                <div class="form-group-1">
                                    <div>
                                        <input type="text" class="form-control" name="basket_adress" id="basket_adress"
                                               placeholder="Город">
                                    </div>
                                    <!-- <div>
                                                                                <select class="dropdown user-region" name="basket_region" id="basket_region">
                                            <option value="0" class="label">Выберите район</option>
                                                                                            <option value=""></option>
                                                                                        </select>
                                    </div> -->
                                    <div>
                                        <input type="text" class="streets form-control" name="basket_street"
                                               id="basket_street" placeholder="Улица" AUTOCOMPLETE="off"/>
                                        <div class="streets-list">
                                            <div></div>
                                        </div>
                                    </div>
                                    <div>
                                        <input type="text" class="form-control" placeholder="Дом" name="basket_house"
                                               id="basket_house"/>
                                    </div>
                                    <div>
                                        <input type="text" class="form-control" placeholder="Кв." name="basket_flat"
                                               id="basket_flat"/>
                                    </div>
                                </div>
                            </li>
                            <li class="reset-flex-xs">
                                <div class=""><p>Мобильный телефон</p></div>
                                <div class="form-group-2">
                                    <div>
                                        <p class="has-phone hidden">+38 (050) 000-00-00</p>
                                        <a href="#" class="edit-phone hidden">изменить</a>
                                        <input type="text" class="full-width modal-phone" name="basket_phone_desktop"
                                               id="basket_phone_desktop" placeholder="(050) 000-00-00"/>
                                        <!-- <input type="text" class="modal-phone hidden-sm hidden-md hidden-lg" placeholder=" (050) 000-00-00" name="basket_phone_mobile" id="basket_phone_mobile"/> -->
                                    </div>
                                    <div>
                                        <div>
                                            <label class="hidden-xs" for="">Количество персон</label>
                                            <input class="" type="text" name="basket_pers_desktop"
                                                   id="basket_pers_desktop"
                                                   placeholder="Количество персон"/>
                                            <!-- <input type="text" class="hidden-sm hidden-md hidden-lg" placeholder="Количество персон" name="basket_pers_mobile" id="basket_pers_mobile" /> -->
                                        </div>
                                        <div>
                                            <label class="hidden-xs" for="">Сдача с</label>
                                            <input class="" type="text" name="basket_sdacha_desktop"
                                                   id="basket_sdacha_desktop" placeholder="Сдача с"/>
                                            <!-- <input type="text" class="hidden-sm hidden-md hidden-lg" placeholder="Сдача с" name="basket_sdacha_mobile" id="basket_sdacha_mobile" /> -->
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="form-group-3">
                                <div class="hidden-xs"><p>Комментарий к заказу</p></div>
                                <div>
                                <textarea class="" type="text" name="basket_remark_desktop" id="basket_remark_desktop"
                                          placeholder="Комментарий к заказу"/></textarea>
                                    <!-- <textarea class="hidden-sm hidden-md hidden-lg" placeholder="Комментарий к заказу" name="basket_remark_mobile" id="basket_remark_mobile"></textarea> -->
                                </div>
                            </li>
                        </ul>
                    </form>
                    <div class="total-info">
                        <div><p>Сумма заказа <span><span class="total-price-order">0</span> руб</span></p></div>
                        <div class="delivery-ok"><p>Стоимость доставки <span><span
                                        class="price-delivery">0</span> руб</span></p></div>
                        <div class="delivery-err hidden"><p>Доставка невозможна</span></p></div>
                        <div><p class="text-right">ИТОГО <span><span class="total-summ">0</span> руб</span></p></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <p class="hidden-xs">Минимальная сумма заказа составляет <span>1000</span> руб</p> -->
                    <input type="hidden" class="distance">
                    <button type="button" class="btn btn-warning text-uppercase send_basket">заказать</button>
                </div>
                <div class="pull-right"><a class="btn btn-primary hidden" href="#getDirections"
                                           id="getDirections">Поехали!</a></div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="thx">
        <div class="modal-dialog" role="document">
            <button type="button" class="close hidden-sm hidden-md hidden-lg" data-dismiss="modal" aria-label="Close">
                <img
                    src="http://fastoran.com/img/register-close-xs.png" alt=""></button>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close hidden-xs" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <div class="flex-center">
                        <h4 class="modal-title text-uppercase text-center hidden-xs">спасибо за ваш заказ!</h4>
                        <h4 class="modal-title text-uppercase hidden-sm hidden-md hidden-lg">корзина</h4>
                    </div>
                </div>
                <div class="modal-body text-center">
                    <!-- <p class="xs-flex">Номер заказа: <span>00000001</span></p> -->
                    <p class="xs-flex">Сумма заказа: <span class="thx-summ">1220 руб.</span></p>
                    <p class="xs-flex">Стоимость доставки: <span class="thx-delivery">1220 руб.</span></p>
                    <p class="xs-orange xs-flex">Вы заработали: <span><span class="cnt-bonus">122</span> балла.</span>
                    </p>
                    <p>Ваш заказ успешно оформлен, ожидайте смс или звонок от оператора.</p>
                    <p>Если у вас возникли вопросы относительно заказа или нашей работы, <br/>пожалуйста, позвоните или
                        напишите нам: <span class="phone">+38 095 41 47 095</span><span
                            class="mail">mailbox@fastoran.com</span></p>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-warning text-uppercase">закрыть</button>
                </div>

            </div><!-- .modal-content -->
        </div><!-- .modal-dialog -->
    </div>
</div>
<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCQFFj02ZGKEZFW8J_Eq2MQV9DxWJLatl0"></script>
<script type="text/javascript" src="http://fastoran.com/js/gmap.routes.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>

<script type="text/javascript" src="http://fastoran.com/js/jquery.cookie.js"></script>
<script type="text/javascript" src="http://fastoran.com/js/jquery.easydropdown.js"></script>
<script type="text/javascript" src="http://fastoran.com/js/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="http://fastoran.com/js/scripts.js"></script>
<script type="text/javascript" src="http://fastoran.com/js/owl.carousel.js"></script>
<script type="text/javascript" src="http://fastoran.com/js/bootstrap.min.js"></script>

<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
