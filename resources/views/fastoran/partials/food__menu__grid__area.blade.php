<section class="fd__special__menu__area bg-image--3">
    <div class="special__food__menu">
        <div class="food__menu__prl bg-image--4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="food__nav nav nav-tabs" role="tablist">
                            <a class="active mt-2" id="nav-all-tab" data-toggle="tab" href="#nav-all" role="tab"
                               aria-selected="true">Все товары</a>
                            @foreach($restoran->categories->all() as $cat)
                                <a class="mt-2" id="nav-{{$cat->alias}}-tab" data-toggle="tab"
                                   href="#nav-{{$cat->alias}}" role="tab" aria-selected="false">{{$cat->name}}</a>
                            @endforeach

                        </div>
                        <div class="fd__tab__content tab-content" id="nav-tabContent">
                            <!-- Start Single tab -->
                            <div class="single__tab__panel tab-pane fade active show" id="nav-all" role="tabpanel">
                                <div class="tab__content__wrap">
                                    <!-- Start Single Tab Content -->
                                    <div class=" fd__tab__content">

                                        <div class="row">
                                        @foreach($products as $product)
                                            <!-- Start Single Banner -->
                                                <div class="col-md-6 col-lg-3 col-sm-6">
                                                    <div class="banner--2 foo">
                                                        <div class="banner__thumb">
                                                            <a href="#"><img
                                                                    src="{{$product->food_img}}"
                                                                    alt="banner images"></a>


                                                        </div>
                                                        <add-cart-btn :product_id="{{$product->id}}"
                                                                      :product_data="{{$product}}"></add-cart-btn>
                                                        <h4 class="banner__h4">
                                                            <mark>{{$product->food_price}}₽</mark>
                                                        </h4>
                                                        <div class="rest-img">
                                                            <a href="{{route("rest",$product->restoran->url)}}">
                                                                <img src="{{$product->restoran->logo}}" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="banner__hover__action banner__left__bottom">
                                                            <div class="banner__hover__inner">

                                                                <h2 class="pink-text">
                                                                    <mark>{{$product->food_name}}</mark>
                                                                </h2>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Single Banner -->
                                            @endforeach

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- End Single tab -->

                        @foreach($restoran->categories->all() as $cat)
                            <!-- Start Single tab -->
                                <div class="single__tab__panel tab-pane fade" id="nav-{{$cat->alias}}" role="tabpanel">
                                    <div class="row">
                                    @foreach($cat->getFilteredMenu($restoran->id) as $product)
                                        <!-- Start Single Banner -->
                                            <div class="col-md-6 col-lg-3 col-sm-12">
                                                <div class="banner--2">
                                                    <div class="banner__thumb">
                                                        <a href="#"><img
                                                                src="{{$product->food_img}}"
                                                                alt="banner images"></a>


                                                    </div>
                                                    <add-cart-btn :product_id="{{$product->id}}"
                                                                  :product_data="{{$product}}"></add-cart-btn>
                                                    <h4 class="banner__h4">
                                                        <mark>{{$product->food_price}}₽</mark>
                                                    </h4>
                                                    <div class="rest-img">
                                                        <a href="{{route("rest",$product->restoran->url)}}">
                                                            <img src="{{$product->restoran->logo}}" alt="">
                                                        </a>
                                                    </div>
                                                    <div class="banner__hover__action banner__left__bottom">
                                                        <div class="banner__hover__inner">

                                                            <h2 class="pink-text">
                                                                <mark>{{$product->food_name}}</mark>
                                                            </h2>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Single Banner -->
                                        @endforeach

                                    </div>
                                </div>
                                <!-- End Single tab -->

                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
