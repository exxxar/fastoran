<div class="col-md-6 col-lg-3 col-sm-6">
    <div class="banner--2">
        <div class="banner__thumb">
            <a href="#"><img
                    class="lazyload" data-src="{{$product->food_img}}"
                    alt="banner images"></a>


        </div>
        @if ($product->restoran->is_work)
            <add-cart-btn :product_id="{{$product->id}}"
                          :product_data="{{$product}}"></add-cart-btn>
        @else
            <div class="product-btn-box">
                <p class="text-center">
                    <mark class="color--white">Время работы: <strong>{{$product->restoran->work_time}}</strong></mark>
                </p>
            </div>
        @endif
        <h4 class="banner__h4" >
            <mark>{{$product->food_price}}₽</mark>
        </h4>
        <div class="rest-img">
            <a href="{{route("rest",$product->restoran->url)}}">
                <img class="lazyload" data-src="{{$product->restoran->logo}}" alt="">
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
