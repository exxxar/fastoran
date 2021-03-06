<section class="fd__special__menu__area bg-image--3">
    <div class="special__food__menu">
        <div class="food__menu__prl bg-image--4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="food__nav nav nav-tabs" role="tablist">
                      {{--      <a class="active mt-2" id="nav-all-tab" data-toggle="tab" href="#nav-all" role="tab"
                               aria-selected="true">Все товары</a>--}}
                            @foreach($restoran->categories->all() as $key=>$cat)
                                <a class="mt-2 {{$key==0?"active":""}}" id="nav-{{$cat->alias}}-tab" data-toggle="tab"
                                   href="#{{$cat->alias}}" role="tab" aria-selected="false">{{$cat->name}}</a>
                            @endforeach

                        </div>
                        <div class="fd__tab__content tab-content" id="nav-tabContent">
                            <!-- Start Single tab -->
                        {{--    <div class="single__tab__panel tab-pane fade active show" id="nav-all" role="tabpanel">
                                <div class="tab__content__wrap">
                                    <!-- Start Single Tab Content -->
                                    <div class=" fd__tab__content">

                                        <div class="row">
                                        @foreach($products as $product)
                                            <!-- Start Single Banner -->
                                            @include("fastoran.partials.food__menu__item",["product"=>$product])
                                            <!-- End Single Banner -->
                                            @endforeach

                                        </div>
                                    </div>

                                </div>
                            </div>--}}
                            <!-- End Single tab -->

                        @foreach($restoran->categories->all() as $key=>$cat)
                            <!-- Start Single tab -->
                                <div class="single__tab__panel tab-pane fade {{$key==0?"active show":""}}" id="{{$cat->alias}}" role="tabpanel">
                                    <div class="row">
                                        <a name="{{$cat->alias}}"></a>
                                    @foreach($cat->getFilteredMenu($restoran->id) as $product)
                                        <!-- Start Single Banner -->

                                        @include("fastoran.partials.food__menu__item",["product"=>$product])
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
