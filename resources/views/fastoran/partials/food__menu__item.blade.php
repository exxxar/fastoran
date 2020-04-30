<div class="col-md-6 col-lg-3 col-sm-6 col-6 banner-item">
    <div class="banner--2" {{$product->food_status->value==\App\Enums\FoodStatusEnum::Promotion?'data-promo="Акция"':""}}>
        <div class="banner__thumb">
            <a href="#" aria-label="{{$product->food_name}}"><img
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
           {{$product->food_price}}₽
        </h4>
        <div class="rest-img">
            <a href="{{route("rest",$product->restoran->url)}}" aria-label="{{$product->restoran->name}}">
                <img class="lazyload"  data-src="{{$product->restoran->logo}}" alt="{{$product->restoran->name}}">
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
