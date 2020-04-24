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
                                <ul class="pp__meta d-flex">
                                    <li><a href="#"><i class="zmdi zmdi-comment-outline"></i>{{$rest->comments_count}}
                                        </a></li>
                                    <li><a href="#"><i
                                                class="zmdi zmdi-favorite-outline"></i>{{$rest->rating->like_count}}</a>
                                    </li>
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
