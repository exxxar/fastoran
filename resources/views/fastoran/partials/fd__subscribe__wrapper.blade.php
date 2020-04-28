<section class="fd__subscribe__wrapper bg__cat--6 poss--relative">
    <div class="fd__subscribe__area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="subscribe__inner subscribe--3">
                        <h2>Оставить заявку на перезвон</h2>
                        <div id="mc_embed_signup">
                            <div id="enter__email__address">
                                <form
                                    action="{{route("wish")}}"
                                    method="post"
                                    class="validate" target="_blank" novalidate>
                                    @csrf
                                    <div id="mc_embed_signup_scroll" class="htc__news__inner">
                                        <div class="news__input">
                                            <input type="text" value="" name="phone" class="phone"
                                                   placeholder="Введите ваш номер телефона" required>
                                        </div>
                                        <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                                        <div class="clearfix subscribe__btn"><input type="submit" value="Отправить"
                                                                                    name="subscribe"
                                                                                    id="mc-embedded-subscribe"
                                                                                    class="sign__up food__btn">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="subs__address__content d-flex justify-content-between">
                            <div class="subs__address d-flex">
                                <div class="sbs__address__icon">
                                    <i class="zmdi zmdi-home"></i>
                                </div>
                                <div class="subs__address__details">
                                    <p>г. Донецк<br>пр. Театральный, 28</p>
                                </div>
                            </div>
                            <div class="subs__address d-flex">
                                <div class="sbs__address__icon">
                                    <i class="zmdi zmdi-phone"></i>
                                </div>
                                <div class="subs__address__details">
                                    <p><a href="tel:+380715071752">+380 (71) 507-17-52</a></p>
                                </div>
                            </div>
                            <div class="subs__address d-flex">
                                <div class="sbs__address__icon">
                                    <i class="zmdi zmdi-email"></i>
                                </div>
                                <div class="subs__address__details">
                                    <p><a href="#">admin@fastoran.com</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       {{-- <div class="subscri__shape--1">
            <img src="https://d29u17ylf1ylz9.cloudfront.net/aahar/images/banner/bann-4/1.png" alt="banner images">
        </div>
        <div class="subscri__shape--2">
            <img src="https://d29u17ylf1ylz9.cloudfront.net/aahar/images/banner/bann-4/2.png" alt="banner images">
        </div>--}}
    </div>
</section>
