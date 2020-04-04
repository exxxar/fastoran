<a name="restorans"></a>
<section class="popular__food__area section-padding--lg bg-image--12">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="section__title title__style--2 service__align--center section__bg__black">
                    <h2 class="title__line">Наши партнеры</h2>
                    <p>Выбери любимое заведение</p>
                </div>
            </div>
        </div>
        <div class="row mt--30">

            @foreach($restorans as $rest)
            <!-- Start Single Popular Food -->
            <div class="col-lg-4 col-md-6 col-sm-12 foo">
                <div class="popular__food">
                    <div class="pp_food__thumb">
                        <a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/menu-details.html">
                            <img src="{{$rest->logo}}"
                                 alt="popular food">
                        </a>
                        {{--<div class="pp__food__prize active offer">
                            <span class="new">new</span>
                            <span>$50</span>
                        </div>--}}
                    </div>
                    <div class="pp__food__inner">
                        {{--<div class="pp__fd__icon">
                            <img src="https://d29u17ylf1ylz9.cloudfront.net/aahar/images/popular/icon/1.png"
                                 alt="icon images">
                        </div>--}}
                        <div class="pp__food__details">
                            <h4><a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/menu-details.html">
                                    {{$rest->name}}</a></h4>
                            <ul class="rating">
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li class="rating__opasity"><i class="zmdi zmdi-star"></i></li>
                            </ul>
                            <p>Время доставки : 20-30 мин.</p>
                            <p>Цена доставки : 20₽+15₽\км</p>
                            <div class="pp__food__bottom d-flex justify-content-between align-items-center">
                                <div class="pp__btn">
                                    <a class="food__btn btn--transparent btn__hover--theme btn__hover--theme"
                                       href="#">Меню ресторана</a>
                                </div>
                                <ul class="pp__meta d-flex">
                                    <li><a href="#"><i class="zmdi zmdi-comment-outline"></i>{{$rest->comments_count}}</a></li>
                                    <li><a href="#"><i class="zmdi zmdi-favorite-outline"></i>{{$rest->rating->like_count}}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach
            <!-- End Single Popular Food -->
          {{--  <!-- Start Single Popular Food -->
            <div class="col-lg-4 col-md-6 col-sm-12 foo">
                <div class="popular__food">
                    <div class="pp_food__thumb">
                        <a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/menu-details.html">
                            <img src="https://d29u17ylf1ylz9.cloudfront.net/aahar/images/popular/2.jpg"
                                 alt="popular food">
                        </a>
                        <div class="pp__food__prize offer">
                            <span class="new">off</span>
                            <span>$50</span>
                        </div>
                    </div>
                    <div class="pp__food__inner">
                        <div class="pp__fd__icon">
                            <img src="https://d29u17ylf1ylz9.cloudfront.net/aahar/images/popular/icon/2.png"
                                 alt="icon images">
                        </div>
                        <div class="pp__food__details">
                            <h4><a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/menu-details.html">Food Type :
                                    Muffin</a></h4>
                            <ul class="rating">
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li class="rating__opasity"><i class="zmdi zmdi-star"></i></li>
                            </ul>
                            <p>Delivery Time : 60 min, Free Delivery</p>
                            <div class="pp__food__bottom d-flex justify-content-between align-items-center">
                                <div class="pp__btn">
                                    <a class="food__btn btn--transparent btn__hover--theme" href="#">Order
                                        Online</a>
                                </div>
                                <ul class="pp__meta d-flex">
                                    <li><a href="#"><i class="zmdi zmdi-comment-outline"></i>03</a></li>
                                    <li><a href="#"><i class="zmdi zmdi-favorite-outline"></i>04</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Single Popular Food -->
            <!-- Start Single Popular Food -->
            <div class="col-lg-4 col-md-6 col-sm-12 foo">
                <div class="popular__food">
                    <div class="pp_food__thumb">
                        <a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/menu-details.html">
                            <img src="https://d29u17ylf1ylz9.cloudfront.net/aahar/images/popular/3.jpg"
                                 alt="popular food">
                        </a>
                        <div class="pp__food__prize offer">
                            <span class="new">hot</span>
                            <span>$50</span>
                        </div>
                    </div>
                    <div class="pp__food__inner">
                        <div class="pp__fd__icon">
                            <img src="https://d29u17ylf1ylz9.cloudfront.net/aahar/images/popular/icon/3.png"
                                 alt="icon images">
                        </div>
                        <div class="pp__food__details">
                            <h4><a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/menu-details.html">Food Type :
                                    Bun</a></h4>
                            <ul class="rating">
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li class="rating__opasity"><i class="zmdi zmdi-star"></i></li>
                            </ul>
                            <p>Delivery Time : 60 min, Free Delivery</p>
                            <div class="pp__food__bottom d-flex justify-content-between align-items-center">
                                <div class="pp__btn">
                                    <a class="food__btn btn--transparent btn__hover--theme" href="#">Order
                                        Online</a>
                                </div>
                                <ul class="pp__meta d-flex">
                                    <li><a href="#"><i class="zmdi zmdi-comment-outline"></i>03</a></li>
                                    <li><a href="#"><i class="zmdi zmdi-favorite-outline"></i>04</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Single Popular Food -->
            <!-- Start Single Popular Food -->
            <div class="col-lg-4 col-md-6 col-sm-12 foo">
                <div class="popular__food">
                    <div class="pp_food__thumb">
                        <a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/menu-details.html">
                            <img src="https://d29u17ylf1ylz9.cloudfront.net/aahar/images/popular/4.jpg"
                                 alt="popular food">
                        </a>
                        <div class="pp__food__prize active">
                            <span>$40</span>
                        </div>
                    </div>
                    <div class="pp__food__inner">
                        <div class="pp__fd__icon">
                            <img src="https://d29u17ylf1ylz9.cloudfront.net/aahar/images/popular/icon/4.png"
                                 alt="icon images">
                        </div>
                        <div class="pp__food__details">
                            <h4><a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/menu-details.html">Food Type :
                                    Cup Cake</a></h4>
                            <ul class="rating">
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li class="rating__opasity"><i class="zmdi zmdi-star"></i></li>
                            </ul>
                            <p>Delivery Time : 60 min, Free Delivery</p>
                            <div class="pp__food__bottom d-flex justify-content-between align-items-center">
                                <div class="pp__btn">
                                    <a class="food__btn btn--transparent btn__hover--theme" href="#">Order
                                        Online</a>
                                </div>
                                <ul class="pp__meta d-flex">
                                    <li><a href="#"><i class="zmdi zmdi-comment-outline"></i>03</a></li>
                                    <li><a href="#"><i class="zmdi zmdi-favorite-outline"></i>04</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Single Popular Food -->
            <!-- Start Single Popular Food -->
            <div class="col-lg-4 col-md-6 col-sm-12 foo">
                <div class="popular__food">
                    <div class="pp_food__thumb">
                        <a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/menu-details.html">
                            <img src="https://d29u17ylf1ylz9.cloudfront.net/aahar/images/popular/5.jpg"
                                 alt="popular food">
                        </a>
                        <div class="pp__food__prize">
                            <span>$40</span>
                        </div>
                    </div>
                    <div class="pp__food__inner">
                        <div class="pp__fd__icon">
                            <img src="https://d29u17ylf1ylz9.cloudfront.net/aahar/images/popular/icon/5.png"
                                 alt="icon images">
                        </div>
                        <div class="pp__food__details">
                            <h4><a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/menu-details.html">Food Type :
                                    Donuts</a></h4>
                            <ul class="rating">
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li class="rating__opasity"><i class="zmdi zmdi-star"></i></li>
                            </ul>
                            <p>Delivery Time : 60 min, Free Delivery</p>
                            <div class="pp__food__bottom d-flex justify-content-between align-items-center">
                                <div class="pp__btn">
                                    <a class="food__btn btn--transparent btn__hover--theme" href="#">Order
                                        Online</a>
                                </div>
                                <ul class="pp__meta d-flex">
                                    <li><a href="#"><i class="zmdi zmdi-comment-outline"></i>03</a></li>
                                    <li><a href="#"><i class="zmdi zmdi-favorite-outline"></i>04</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Single Popular Food -->
            <!-- Start Single Popular Food -->
            <div class="col-lg-4 col-md-6 col-sm-12 foo">
                <div class="popular__food">
                    <div class="pp_food__thumb">
                        <a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/menu-details.html">
                            <img src="https://d29u17ylf1ylz9.cloudfront.net/aahar/images/popular/6.jpg"
                                 alt="popular food">
                        </a>
                        <div class="pp__food__prize active">
                            <span>$40</span>
                        </div>
                    </div>
                    <div class="pp__food__inner">
                        <div class="pp__fd__icon">
                            <img src="https://d29u17ylf1ylz9.cloudfront.net/aahar/images/popular/icon/6.png"
                                 alt="icon images">
                        </div>
                        <div class="pp__food__details">
                            <h4><a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/menu-details.html">Food Type :
                                    Bread</a></h4>
                            <ul class="rating">
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li><i class="zmdi zmdi-star"></i></li>
                                <li class="rating__opasity"><i class="zmdi zmdi-star"></i></li>
                            </ul>
                            <p>Delivery Time : 60 min, Free Delivery</p>
                            <div class="pp__food__bottom d-flex justify-content-between align-items-center">
                                <div class="pp__btn">
                                    <a class="food__btn btn--transparent btn__hover--theme" href="#">Order
                                        Online</a>
                                </div>
                                <ul class="pp__meta d-flex">
                                    <li><a href="#"><i class="zmdi zmdi-comment-outline"></i>03</a></li>
                                    <li><a href="#"><i class="zmdi zmdi-favorite-outline"></i>04</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Single Popular Food -->--}}
        </div>


    </div>
</section>
