<a name="kitchens"></a>
<section class="food__category__area bg--white section-padding--lg section-padding--xs">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="section__title service__align--left">
                    <p>Начни с этого шага</p>
                    <h2 class="title__line">Выбери кухню</h2>
                </div>
            </div>
        </div>
        <div class="food__category__wrapper mt-5">
            <div class="row">
            @foreach($header_kitchen_list as $key=>$hkitchen)
                <!-- Start Single Category -->
                <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-6" >
                    <div class="food__item foo" style="; visibility: visible;  -webkit-transform: translateY(0) scale(1); opacity: 1;transform: translateY(0) scale(1); opacity: 1;-webkit-transition: -webkit-transform 0.7s cubic-bezier(0.6, 0.2, 0.1, 1) 0s, opacity 0.7s cubic-bezier(0.6, 0.2, 0.1, 1) 0s; transition: transform 0.7s cubic-bezier(0.6, 0.2, 0.1, 1) 0s, opacity 0.7s cubic-bezier(0.6, 0.2, 0.1, 1) 0s; ">
                        <div class="food__thumb">
                            <a href="{{route("kitchen",$hkitchen->id)}}">
                                <img src="{{$hkitchen->img}}" alt="product images">
                            </a>
                        </div>
                        <div class="food__title">
                            <h2><a href="{{route("kitchen",$hkitchen->id)}}">{{$hkitchen->name}}</a></h2>
                        </div>
                        <div class="food__label">
                            <p>{{$hkitchen->rest_count}} заведений</p>
                        </div>
                    </div>
                </div>
                <!-- End Single Category -->
            @endforeach
            </div>
        </div>
    </div>
</section>
