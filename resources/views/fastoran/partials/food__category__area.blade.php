<a name="kitchens"></a>
<section class="food__category__area bg--white section-padding--lg">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="section__title service__align--left">
                    <p>Начни с этого шага</p>
                    <h2 class="title__line">Выбери кухню</h2>
                </div>
            </div>
        </div>
        <div class="food__category__wrapper mt--40">
            <div class="row">
            @foreach($kitchens as $key=>$kitchen)
                <!-- Start Single Category -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="food__item foo" style="; visibility: visible;  -webkit-transform: translateY(0) scale(1); opacity: 1;transform: translateY(0) scale(1); opacity: 1;-webkit-transition: -webkit-transform 0.7s cubic-bezier(0.6, 0.2, 0.1, 1) 0s, opacity 0.7s cubic-bezier(0.6, 0.2, 0.1, 1) 0s; transition: transform 0.7s cubic-bezier(0.6, 0.2, 0.1, 1) 0s, opacity 0.7s cubic-bezier(0.6, 0.2, 0.1, 1) 0s; ">
                        <div class="food__thumb">
                            <a href="menu-details.html">
                                <img src="{{$kitchen->img}}" alt="product images">
                            </a>
                        </div>
                        <div class="food__title">
                            <h2><a href="menu-details.html">{{$kitchen->name}}</a></h2>
                        </div>
                        <div class="food__label">
                            <p>{{$kitchen->rest_count}} заведений</p>
                        </div>
                    </div>
                </div>
                <!-- End Single Category -->
            @endforeach
             {{--   <!-- Start Single Category -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="food__item foo" data-sr-id="2" style="; visibility: visible;  -webkit-transform: translateY(0) scale(1); opacity: 1;transform: translateY(0) scale(1); opacity: 1;-webkit-transition: -webkit-transform 0.7s cubic-bezier(0.6, 0.2, 0.1, 1) 0s, opacity 0.7s cubic-bezier(0.6, 0.2, 0.1, 1) 0s; transition: transform 0.7s cubic-bezier(0.6, 0.2, 0.1, 1) 0s, opacity 0.7s cubic-bezier(0.6, 0.2, 0.1, 1) 0s; ">
                        <div class="food__thumb">
                            <a href="menu-details.html">
                                <img src="images/product/md-product/2.jpg" alt="product images">
                            </a>
                        </div>
                        <div class="food__title">
                            <h2><a href="menu-details.html">Lunch Iteam</a></h2>
                        </div>
                    </div>
                </div>
                <!-- End Single Category -->
                <!-- Start Single Category -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="food__item foo" data-sr-id="3" style="; visibility: visible;  -webkit-transform: translateY(0) scale(1); opacity: 1;transform: translateY(0) scale(1); opacity: 1;-webkit-transition: -webkit-transform 0.7s cubic-bezier(0.6, 0.2, 0.1, 1) 0s, opacity 0.7s cubic-bezier(0.6, 0.2, 0.1, 1) 0s; transition: transform 0.7s cubic-bezier(0.6, 0.2, 0.1, 1) 0s, opacity 0.7s cubic-bezier(0.6, 0.2, 0.1, 1) 0s; ">
                        <div class="food__thumb">
                            <a href="menu-details.html">
                                <img src="images/product/md-product/3.jpg" alt="product images">
                            </a>
                        </div>
                        <div class="food__title">
                            <h2><a href="menu-details.html">Dinner Iteam</a></h2>
                        </div>
                    </div>
                </div>
                <!-- End Single Category -->--}}
            </div>
        </div>
    </div>
</section>
