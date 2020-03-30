<section class="register my-hidden">
    <div class="register-wrap-overflou">
        <a href="#" class="register-close hidden-sm hidden-md hidden-lg"><img
                src="img/register-close-xs.png" alt=""></a>
        <div class="container">
            <div class="register-wrap">
                <div class="row">
                    <div class="col-md-5 col-sm-6 col-xs-12">
                        <div class="register-preview sm hidden-xs">
                            <h3 class="register-title text-uppercase">регистрация</h3>
                            <p>Быстрая регистрация позволит вам зарабатывать <br/>бонусные баллы и получать приятные
                                подарки.</p>
                            <button type="button" class="btn btn-warning show-form sm">зарегистрироваться</button>
                        </div>
                        <div class="l-register-form">
                            <div class="register-xs-title hidden-sm hidden-md hidden-lg">
                                <h3 class="text-uppercase hidden-sm hidden-md hidden-lg">аккаунт</h3>
                                <a href="#" class="reset-password hidden">Забыли пароль?</a>
                            </div>
                            <h3 class="register-title text-uppercase hidden-xs">регистрация</h3>
                            <form action="" id="register-form">
                                <div class="row">
                                    <div class="col-md-5 col-sm-5 col-xs-5">
                                        <input type="text" class="form-control" placeholder="Имя*" required="true"
                                               name="user_name" id="user_name">
                                    </div>
                                    <div class="col-md-7 col-sm-7 col-xs-7">
                                        <input type="text" class="form-control" placeholder="Фамилия"
                                               name="user_second_name" id="user_second_name">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Номер телефона*"
                                               required="true" name="user_phone" id="user_phone">
                                        <input type="password" class="form-control" placeholder="Пароль*"
                                               required="true" name="user_pass" id="user_pass">
                                        <input type="password" class="form-control" placeholder="Повторите пароль*"
                                               required="true" name="user_pass2" id="user_pass2">
                                        <button type="button" class="btn btn-warning btn-register hidden-xs">
                                            регистрация
                                        </button>
                                        <button type="button"
                                                class="btn btn-warning btn-register hidden-sm hidden-md hidden-lg">
                                            зарегистрироваться
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-4 col-md-offset-3 col-sm-5 col-sm-offset-1 col-xs-12">
                        <div class="register-enter">
                            <div class="register-xs-title">
                                <h3 class="text-uppercase hidden-sm hidden-md hidden-lg">аккаунт</h3>
                                <a href="#" class="reset-password hidden-sm hidden-md hidden-lg">Забыли пароль?</a>
                            </div>
                            <h3 class="register-title text-uppercase hidden-xs">вход</h3>
                            <form action="" id="enter-form">
                                <div class="my-hr hidden-sm hidden-md hidden-lg">
                                    <div></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Номер телефона*"
                                               name="enter_phone" id="enter_mail">
                                        <input type="password" class="form-control" placeholder="Пароль*"
                                               name="enter_pass" id="enter_pass">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                        <button type="button" class="btn btn-warning btn-enter">Войти</button>
                                    </div>
                                    <div class="col-xs-6 hidden-sm hidden-md hidden-lg">
                                        <button type="button" class="btn btn-warning show-form xs">регистрация</button>
                                    </div>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <a href="#" class="reset-password hidden-xs">Забыли пароль?</a>
                                    </div>
                                </div>

                                <script src="ulogin.ru/js/ulogin.js"></script>
                                <!-- <div id="uLogin" data-ulogin="callback=preview;verify=1;display=small;theme=classic;fields=first_name,last_name,email;providers=vkontakte,facebook;hidden=;redirect_uri=;mobilebuttons=0;"></div> -->
                                <div id="uLogin"
                                     data-ulogin="display=buttons;callback=preview;verify=1;fields=first_name,last_name,email;">
                                    <!--    <img src="vkontakte.png" data-uloginbutton="vkontakte"/>
                                       <img src="facebook.png" data-uloginbutton="facebook"/> -->
                                    <div data-uloginbutton="facebook" class="login-fb enter-soc">
                                        <img src="/img/svg/fb-icon.svg" alt="">
                                        <span>Facebook</span>
                                    </div>
                                    <div data-uloginbutton="vkontakte" class="login-vk enter-soc">
                                        <img src="/img/svg/vk-icon.svg" alt="">
                                        <span>Вконтакте</span>
                                    </div>
                                </div>

                                <a href="#" class="register-close hidden-xs">Х <span>Скрыть</span></a>
                            </form>
                        </div>
                    </div>
                    <div class="col-xs-12 hidden-sm hidden-md hidden-lg">
                        <ul class="link-list">
                            <li><a href="#">Список ресторанов</a></li>
                            <li><a href="#">Акционные предложения</a></li>
                            <li><a href="#">Бонусы</a></li>
                        </ul>


                    </div>
                </div>
            </div>
            <div class="profile-wrap hidden hidden-sm hidden-md hidden-lg">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="register-xs-title">
                            <div>
                                <h3 class="text-uppercase hidden-sm hidden-md hidden-lg">аккаунт</h3>
                            </div>
                            <div>
                                <a href="#" class="reset-password edit-profile hidden-sm hidden-md hidden-lg">Редактировать</a>
                                <a href="#"
                                   class="reset-password mobile-log-out hidden-sm hidden-md hidden-lg">Выход</a>
                            </div>
                        </div>
                        <form action="" class="form-user-data">
                            <ul class="modal-user-data">
                                <li>
                                    <div><p>Ваше имя</p></div>
                                    <div>
                                        <p class="default-data" id="prof_name_val"></p>
                                        <input type="text" class="new-data hidden" name="prof_name" id="prof_name">
                                    </div>
                                </li>
                                <li>
                                    <div><p>E-mail</p></div>
                                    <div>
                                        <p class="default-data" id="prof_mail_val"></p>
                                        <input type="text" class="new-data hidden" name="prof_mail" id="prof_mail">
                                    </div>
                                </li>
                                <li>
                                    <div><p>Пароль</p></div>
                                    <div>
                                        <p class="default-data">**********</p>
                                        <input type="password" class="new-data hidden small">
                                        <input type="password" class="new-data hidden small">
                                    </div>
                                </li>
                                <li>
                                    <div><p>Телефон</p></div>
                                    <div>
                                        <p class="default-data" id="prof_phone_val"></p>
                                        <input type="text" class="new-data hidden" name="prof_phone" id="prof_phone">
                                    </div>
                                </li>
                                <li>
                                    <div><p>Дата рождения</p></div>
                                    <div>
                                        <p class="default-data" id="prof_birthday_val"></p>
                                        <input type="date" class="new-data hidden" name="prof_birthday"
                                               id="prof_birthday_mobile">
                                    </div>
                                </li>
                            </ul>
                            <ul class="modal-user-data">
                                <li>
                                    <div><p>Улица</p></div>
                                    <div>
                                        <p class="default-data" id="prof_street_val">Донецк, Куйбышевский р-н, ул.
                                            Лебединского, 3/7</p>
                                        <!--
<textarea name="prof_adr" id="prof_adr" cols="30" rows="10" value="" class="new-data hidden small"></textarea>
-->
                                        <input type="text" class="new-data hidden" name="prof_street" id="prof_street"/>

                                    </div>
                                <li>
                                    <div><p>Дом</p></div>
                                    <div>
                                        <p class="default-data" id="prof_home_val">Донецк, Куйбышевский р-н, ул.
                                            Лебединского, 3/7</p>
                                        <!--
<textarea name="prof_adr" id="prof_adr" cols="30" rows="10" value="" class="new-data hidden small"></textarea>
-->
                                        <input type="text" class="new-data hidden" name="prof_home" id="prof_home"/>

                                    </div>
                                </li>
                                <li>
                                    <div><p>Квартира</p></div>
                                    <div>
                                        <p class="default-data" id="prof_flat_val">Донецк, Куйбышевский р-н, ул.
                                            Лебединского, 3/7</p>
                                        <!--
<textarea name="prof_adr" id="prof_adr" cols="30" rows="10" value="" class="new-data hidden small"></textarea>
-->
                                        <input type="text" class="new-data hidden" name="prof_flat" id="prof_flat"/>

                                    </div>
                                </li>
                                </li>
                            </ul>
                            <button type="button" class="btn btn-warning new-data-save hidden">Сохранить изменения
                            </button>
                        </form>
                        <div class="modal-bonuses">
                            <p>На Вашем счету <span id="bonus_val"></span>.</p>
                            <p>Обменивайте накопленные баллы на <a href="#">бонусы</a>.</p>
                        </div>
                        <h5 class="regulator-title">Правила начисления и получения баллов:</h5>
                        <ul class="modal-regulator">
                            <li>- бонусные баллы получают только зарегистрированные пользователи. Регистрируясь Вы
                                получаете 100 баллов;
                            </li>
                            <li>- за каждые 100 рублей начисляется 10 бонусных баллов;</li>
                            <li>- баллы начисляются в течение 24 часов после оформления заказа;</li>
                            <li>- оставляйте отзыв после заказа в ресторане и получайте 50 баллов за каждый отзыв;</li>
                            <li>- если в течение 6 месяцев не сделано ни одного заказа, все начисленные баллы сгорают.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
