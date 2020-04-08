<section class="food__special__offer bg-image--25 section-padding--lg section-padding--xs">

    <div class="banner__area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="section__title title__style--2 service__align--center">
                        <h2 class="title__line">Все товары<br>наших партнеров</h2>
                        <p>Возможно, это то что ты ищещь! </p>
                    </div>
                </div>
            </div>
            <div class="row">
            @foreach($products as $product)
                <!-- Start Single Banner -->
                @include("fastoran.partials.food__menu__item",["product"=>$product])
                <!-- End Single Banner -->
                @endforeach

            </div>

            <div class="row">
                <div class="col-lg-12">
                    {{$products->links()}}
                </div>
            </div>
        </div>
    </div>
</section>
