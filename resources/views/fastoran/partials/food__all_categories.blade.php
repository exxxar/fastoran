<section class="fd__special__menu__area bg-image--3">
    <div class="special__food__menu">
        <div class="food__menu__prl bg-image--4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="food__nav nav nav-tabs" role="tablist">
                            @foreach($categories as $cat)
                                <a class="mt-2" id="nav-{{$cat->alias}}-tab" data-toggle="tab"
                                   href="#nav-{{$cat->alias}}" role="tab" aria-selected="false">{{$cat->name}}</a>
                            @endforeach

                        </div>
                        <div class="fd__tab__content tab-content" id="nav-tabContent">

                        @foreach($categories as $cat)
                            <!-- Start Single tab -->
                                <div class="single__tab__panel tab-pane fade" id="nav-{{$cat->alias}}"
                                     role="tabpanel">
                                    <div class="row">
                                    @foreach($cat->menus as $product)
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
