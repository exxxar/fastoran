<div class="slider__area slider--one">
    <div class="slider__activation--1">
        <!-- Start Single Slide -->
        <div class="slide custom-slider-one bg-image--1">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="slider__content">
                            <div class="slider__inner">
                                <h2>“FASTORAN”</h2>
                                <h1>Доставка еды &amp; сервис</h1>
                                <form class="slider__input custom__slider__input" action="{{route('search')}}" method="post">
                                    @csrf
                                    <input type="text" name="food_name" placeholder="Введите название блюда">
                                    <span>или</span>
                                    <input class="res__search" name="rest_name" type="text" placeholder="Введите название ресторана">
                                    <div class="src__btn">
                                        <button class="btn btn-primary btn-primary-custom" type="submit">Найти</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Single Slide -->
    </div>
</div>
