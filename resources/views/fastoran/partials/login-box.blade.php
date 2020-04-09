<div class="accountbox-wrapper">
    <div class="accountbox text-left">
        <ul class="nav accountbox__filters" id="myTab" role="tablist">
            <li>
                <a class="active" id="log-tab" data-toggle="tab" href="#log" role="tab" aria-controls="log"
                   aria-selected="true">Закажи что угодно</a>
            </li>
            <li>
                <a id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                   aria-selected="false">Стать доставщиком</a>
            </li>
        </ul>
        <div class="accountbox__inner tab-content" id="myTabContent">
            <div class="accountbox__login tab-pane fade show active" id="log" role="tabpanel"
                 aria-labelledby="log-tab">
                <form action="#">
                    <div class="single-input">
                        <input class="form-control" type="text" placeholder="Ваше имя">
                    </div>
                    <div class="single-input">
                        <input class="form-control" type="text" placeholder="Ваш номер телефона">
                    </div>
                    <div class="single-input">
                        <textarea class="form-control" placeholder="Ваш заказ"></textarea>
                    </div>
                    <div class="single-input">
                        <button type="submit" class="food__btn"><span>Заказть звонок</span></button>
                    </div>
                    <hr>
                    <div class="single-input">
                        <a href="{{route("terms")}}" target="_blank">Преде началом работы советуем ознакомиться с соглашением на обработку пользовательских данных.</a>
                    </div>
                  {{--  <div class="accountbox-login__others">
                        <h6>Соглашение на обработку пользовательских данных</h6>

                       --}}{{-- <div class="social-icons">
                            <ul>
                                <li class="facebook"><a href="https://www.facebook.com/"><i
                                            class="fa fa-facebook"></i></a></li>
                                <li class="twitter"><a href="https://twitter.com/"><i class="fa fa-twitter"></i></a>
                                </li>
                                <li class="pinterest"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                        </div>--}}{{--
                    </div>--}}
                </form>
            </div>
            <div class="accountbox__register tab-pane fade" id="profile" role="tabpanel"
                 aria-labelledby="profile-tab">
                <form action="#">
                    <div class="single-input">
                        <input class="form-control" type="text" placeholder="Ваше имя">
                    </div>
                    <div class="single-input">
                        <input class="form-control" type="text" placeholder="Ваш номер телефона">
                    </div>
                    <div class="single-input">
                        <select name="" class="form-control">
                            <option value="0">Выберите способ доставки</option>
                            <option value="1">Пеший</option>
                            <option value="2">Велосипед</option>
                            <option value="3">Мотоцикл\Мопед</option>
                            <option value="4">Автомобиль</option>
                        </select>
                    </div>
                    <div class="single-input">
                        <button type="submit" class="food__btn"><span>Отправить</span></button>
                    </div>
                </form>
            </div>
            <span class="accountbox-close-button"><i class="zmdi zmdi-close"></i></span>
        </div>
    </div>
</div><!-- //Login Form -->
