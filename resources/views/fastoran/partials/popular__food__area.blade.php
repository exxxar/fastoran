<a name="restorans"></a>
<section class="popular__food__area section-padding--lg section-padding--xs bg-image--12">
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

            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-6 foo">
                <div class="popular__food">
                    <div class="pp_food__thumb">
                        <a href="/obedygo#standart">
                            <img class="lazyload" data-src="/img/logo_obed_go.jpg"
                                 alt="popular food">
                        </a>

                    </div>
                    <div class="pp__food__inner">
                        <div class="pp__food__details">
                            <h4><a href="/obedygo#standart">
                                    ОбедыGO</a></h4>
                            <ul class="pp__meta d-flex flex-wrap">
                                <li>Доставка от 0 ₽</li>
                                <li>Заказ от 3х позций</li>
                                <li>Только по будням!</li>


                            </ul>
                            <div class="pp__food__bottom d-flex justify-content-between align-items-center">
                                <div class="pp__btn">
                                    <a class="food__btn btn--transparent btn__hover--theme btn__hover--theme"
                                       href="/obedygo#standart">Меню ресторана</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @foreach($restorans as $rest)
            <!-- Start Single Popular Food -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-6 foo">
                    <div class="popular__food">
                        <div class="pp_food__thumb">
                            <a href="{{route("rest",$rest->url)}}">
                                <img class="lazyload" data-src="{{$rest->logo}}"
                                     alt="popular food">
                            </a>

                        </div>
                        <div class="pp__food__inner">
                            <div class="pp__food__details">
                                <h4><a href="{{route("rest",$rest->url)}}">
                                        {{$rest->name}}</a></h4>
                                <ul class="pp__meta d-flex flex-wrap">
                                    {{-- <li><a href="#"><i class="zmdi zmdi-comment-outline"></i>{{$rest->comments_count}}
                                         </a></li>
                                     <li><a href="#"><i
                                                 class="zmdi zmdi-favorite-outline"></i>{{$rest->rating->like_count}}</a>
                                     </li>--}}
                                    <li>Доставка от {{$rest->price_delivery}} ₽</li>
                                    <li>Заказ от {{$rest->min_sum}} ₽</li>
                                    <li>{{$rest->work_time}}</li>


                                </ul>
                                <div class="pp__food__bottom d-flex justify-content-between align-items-center">
                                    <div class="pp__btn">
                                        <a class="food__btn btn--transparent btn__hover--theme btn__hover--theme"
                                           href="{{route("rest",$rest->url)}}">Меню ресторана</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>


    </div>
</section>
