{{dd($kitchens)}}
@isset($kitchens)
    <div class="l-kitchen">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h2 class="title">выберите <span>кухню</span></h2>
                </div>
            </div>

            <div class="row">
                @foreach($kitchens as $kitchen)
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="l-kitchen-item">
                            <div class="l-kitchen-item__media">
                                <img src="{{$kitchen->url}}" alt="{{$kitchen->alt_description}}">
                                <a href="{{route("kitchen",$kitchen->id)}}" class="l-kitchen-item__link">
                                    <p class="hidden-sm hidden-xs">{{$kitchen->rest_count}} заведений</p>
                                    <p class="text-uppercase text-center hidden-md hidden-lg">{{$kitchen->name}}</p>
                                </a>
                            </div>
                            <div class="l-kitchen-item__description hidden-sm hidden-xs">
                                <a href="{{route("kitchen",$kitchen->id)}}">{{$kitchen->name}}</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endisset
