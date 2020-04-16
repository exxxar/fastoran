@isset($restorans)
    <div class="l-restorans">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h2 class="title">выберите <span>ресторан</span></h2>
                </div>
            </div>

            <div class="row">
                @foreach($restorans as $restoran)
                <div class="col-md-2 col-sm-3 col-xs-4">
                    <div class="l-restorans-item">
                        <img src="{{$restoran->logo}}" alt="">
                        <a href="{{route("rest",$restoran->url)}}" class="l-restorans-item-link">
                            <p>Перейти<br/>в<br/>меню</p>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    <a href="{{route("rest-list")}}" class="more-restorans">Показать все заведения</a>
                </div>
            </div>
        </div>
    </div>
@endisset
