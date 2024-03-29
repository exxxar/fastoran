<div class="slider__area slider--one">
    <div class="slider__activation--1">
        <!-- Start Single Slide -->
        <div class="slide custom-slider-one bg-image--1" data-bg="https://fastoran.com/images/bg/1.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="slider__content">
                            <div class="slider__inner">
                                <h2>“FASTORAN”</h2>
                                <h3 class="delivery-time">Доставка работает с <span>11:00</span> до <span>21:00</span>
                                </h3>

                                <div class="d-sm-none">
                                    <div class="circle-button-group">
                                        <a href="{{route("custom-order")}}"
                                           class="custom-btn c-btn-1 ">Продукты</a>
                                        
                                     {{--   <a href="{{route("custom-order")}}"
                                           class="custom-btn c-btn-2 ">Медикаменты</a>--}}
                                        
                                        <a href="#restorans" class="custom-btn c-btn-3">Рестораны</a>
                                        <a href="{{route("phone-order")}}"
                                           class="custom-btn c-btn-2 ">Заказать по телефону</a>


                                       {{-- <a href="{{route("deliveryman-quest")}}"
                                           class="custom-btn c-btn-2 ">Доставщик</a>--}}
                                    </div>
                                </div>
                                <div class="d-none d-sm-block">
                                    <div class="circle-button-group">
                                        <a data-toggle="modal" data-target="#customCartModal" data-whatever="@mdo"
                                           class="custom-btn c-btn-1 ">Продукты</a>


                                        <a href="#restorans" class="custom-btn c-btn-3">Рестораны</a>
                                        <a data-toggle="modal" data-target="#customPhoneModal" data-whatever="@mdo"
                                           class="custom-btn c-btn-1 ">Заказать по телефону</a>
                                      {{--  <a data-toggle="modal" data-target="#deliverymanQuestOrderModal" data-whatever="@mdo"
                                           class="custom-btn c-btn-1 ">Доставщик</a>--}}

                                    </div>
                                </div>
                                <h3 class="text-center mb-5"><a href="/desktop"><mark class=" text-white ">Fastoran 2.0 (для телефонов) Попробовать!</mark></a>
                                </h3>
                                <h1>Доставка еды &amp; сервис</h1>
                                <div class="slider__input custom__slider__input">
                                    <order-status></order-status>
                                </div>
                                {{--   <form class="slider__input custom__slider__input" action="{{route('search')}}" method="post">
                                       @csrf
                                       <input type="text" name="food_name" placeholder="Введите название блюда">
                                       <span>или</span>
                                       <input class="res__search" name="rest_name" type="text" placeholder="Введите название ресторана">
                                       <div class="src__btn">
                                           <button class="btn btn-primary btn-primary-custom" type="submit">Найти</button>
                                       </div>
                                   </form>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Single Slide -->
    </div>
</div>
