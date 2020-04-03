<section class="food__special__offer bg-image--25 section-padding--lg">
   {{-- <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="section__title title__style--2 service__align--center">
                    <h2 class="title__line">Случайные товары<br>наших партнеров</h2>
                    <p>Возможно, это то что ты ищещь! </p>
                </div>
            </div>
        </div>
        <div class="row mt--40">
            @foreach($random_menu as $product)
            <!-- Start Single Offer -->
            <div class="col-md-6 col-sm-12 col-lg-3">
                <div class="food__offer text-center foo">
                    <div class="offer__thumb poss--relative">
                        <img src="{{$product->food_img}}"
                             alt="offer images">
                        <div class="offer__product__prize">
                            <span>{{$product->food_price}}₽</span>
                        </div>
                    </div>
                    <div class="offer__details">
                        <h2><a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/menu-details.html">{{$product->food_name}}</a></h2>
                        <p>{{$product->food_remark}}</p>
                        <div class="offer__btn">
                            <a class="food__btn grey--btn mid-height" href="menu-details.html">Заказать сейчас</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start Single Offer -->

            @endforeach
      --}}{{--      <!-- Start Single Offer -->
            <div class="col-md-6 col-sm-12 col-lg-3">
                <div class="food__offer text-center foo">
                    <div class="offer__thumb poss--relative">
                        <img src="https://d29u17ylf1ylz9.cloudfront.net/aahar/images/product/offer-product/2.jpg"
                             alt="offer images">
                        <div class="offer__product__prize">
                            <span>$25</span>
                        </div>
                    </div>
                    <div class="offer__details">
                        <h2><a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/menu-details.html">Mixed Fruits
                                Pie</a></h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
                        <div class="offer__btn">
                            <a class="food__btn grey--btn mid-height" href="menu-details.html">Order Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start Single Offer -->
            <!-- Start Single Offer -->
            <div class="col-md-6 col-sm-12 col-lg-3">
                <div class="food__offer text-center foo">
                    <div class="offer__thumb poss--relative">
                        <img src="https://d29u17ylf1ylz9.cloudfront.net/aahar/images/product/offer-product/3.jpg"
                             alt="offer images">
                        <div class="offer__product__prize">
                            <span>$25</span>
                        </div>
                    </div>
                    <div class="offer__details">
                        <h2><a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/menu-details.html">Wheat Bread</a>
                        </h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
                        <div class="offer__btn">
                            <a class="food__btn grey--btn mid-height"
                               href="https://d29u17ylf1ylz9.cloudfront.net/aahar/menu-details.html">Order Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start Single Offer -->
            <!-- Start Single Offer -->
            <div class="col-md-6 col-sm-12 col-lg-3">
                <div class="food__offer text-center foo">
                    <div class="offer__thumb poss--relative">
                        <img src="https://d29u17ylf1ylz9.cloudfront.net/aahar/images/product/offer-product/4.jpg"
                             alt="offer images">
                        <div class="offer__product__prize">
                            <span>$25</span>
                        </div>
                    </div>
                    <div class="offer__details">
                        <h2><a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/menu-details.html">Wheat Bread</a>
                        </h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor.</p>
                        <div class="offer__btn">
                            <a class="food__btn grey--btn mid-height"
                               href="https://d29u17ylf1ylz9.cloudfront.net/aahar/menu-details.html">Order Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start Single Offer -->--}}{{--
        </div>
    </div>--}}
    <!-- Start Banner Area -->
    <div class="banner__area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="section__title title__style--2 service__align--center">
                        <h2 class="title__line">Случайные товары<br>наших партнеров</h2>
                        <p>Возможно, это то что ты ищещь! </p>
                    </div>
                </div>
            </div>
            <div class="row">
            @foreach($random_menu as $product)
                <!-- Start Single Banner -->
                <div class="col-md-6 col-lg-3 col-sm-6">
                    <div class="banner--2 foo">
                        <div class="banner__thumb">
                            <a href="#"><img
                                    src="{{$product->food_img}}"
                                    alt="banner images"></a>
                        </div>
                        <div class="banner__hover__action banner__left__bottom">
                            <div class="banner__hover__inner">
                                <h4><mark>{{$product->food_price}}₽</mark></h4>
                                <h2 class="pink-text">{{$product->food_name}}</h2>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Single Banner -->
                @endforeach
                {{--  <!-- Start Single Banner -->
                  <div class="col-md-6 col-lg-3 col-sm-12">
                      <div class="banner--2 foo">
                          <div class="banner__thumb">
                              <a href="#"><img
                                      src="https://d29u17ylf1ylz9.cloudfront.net/aahar/images/banner/bann-2/2.jpg"
                                      alt="banner images"></a>
                          </div>
                          <div class="banner__hover__action banner__left__top">
                              <div class="banner__hover__inner">
                                  <h4>colorful</h4>
                                  <h2 class="pink-text">donut’s</h2>
                                  <p>get it till the stock full</p>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- End Single Banner -->
                  <!-- Start Single Banner -->
                  <div class="col-md-12 col-lg-6 col-sm-12">
                      <div class="banner--2 foo">
                          <div class="banner__thumb">
                              <a href="#"><img
                                      src="https://d29u17ylf1ylz9.cloudfront.net/aahar/images/banner/bann-2/3.jpg"
                                      alt="banner images"></a>
                          </div>
                          <div class="banner__hover__action banner__right__bottom">
                              <div class="banner__hover__inner">
                                  <h4 class="vanilla">vanilla</h4>
                                  <h2 class="pink-text">MAFFIN</h2>
                                  <p>Lovely Food for Food lover</p>
                              </div>
                          </div>
                      </div>
                  </div>
                  <!-- End Single Banner -->--}}
            </div>
        </div>
    </div>
    <!-- End Banner Area -->
       <div class="order-now-area">
           <div class="container">
               <div class="row">
                   <div class="col-lg-12 col-md-12">
                       <div class="fd__order__now text-center">
                           <div class="order__now__inner">
                               <h6>У нас есть доставка ЛЮБЫХ товаров!</h6>
                               <h2>Закажи сейчас:<br><a href="tel:+380715071752">+38(071) 507-17-52</a></h2>
                               <p>Продукты из магазина, цветы, медикаменты и многое другое!</p>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
</section>
