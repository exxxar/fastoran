<div class="postCarousel owl-carousel">

    @foreach($restorans as $restoran)
        <div class="item">
            <a href="{{route("mobile.restoran",$restoran->url)}}">
                <img src="{{$restoran->logo}}" alt="{{$restoran->seo_title}}" class="image">
               {{-- <h2 class="title">{{$restoran->name}}</h2>--}}
            </a>
        </div>
    @endforeach
</div>
