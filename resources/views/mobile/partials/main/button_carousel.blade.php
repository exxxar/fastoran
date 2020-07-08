<!-- Button Carousel -->
<div class="buttonCarousel owl-carousel">

    @foreach($menu_categories as $category)
        <div class="item">
            <a href="{{route("mobile.category",$category->id)}}" aria-label="{{$category->name}}" title="{{$category->name}}">
                <strong>{{$category->name}}</strong>
            </a>
        </div>
    @endforeach

</div>

<!-- Button Carousel -->
