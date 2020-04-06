<section class="food__special__offer bg-image--25 section-padding--lg section-padding--xs">

    <div class="banner__area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="section__title title__style--2 service__align--center">
                        <h2 class="title__line">Все товары<br>наших партнеров</h2>
                        <p>Возможно, это то что ты ищещь! </p>
                    </div>
                </div>
            </div>
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
                            <add-cart-btn :product_id="{{$product->id}}" :product_data="{{$product}}"></add-cart-btn>
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

                <div class="row">
                    <div class="col-lg-12">
                        {{$products->links()}}
                    </div>
                </div>
        </div>
    </div>
</section>
