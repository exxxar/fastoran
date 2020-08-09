<!-- App Bottom Menu -->
<div class="appBottomMenu">
    <div class="item {{$active==0?"active":""}}">
        <a href="{{route("mobile.index")}}">
            <p>
                <i class="icon ion-md-apps"></i>
                <span>Главная</span>
            </p>
        </a>
    </div>
    <div class="item {{$active==1?"active":""}}">
        <a href="{{route("mobile.status")}}">
            <p>
                <i class="icon ion-ios-stats"></i>
                <span>Статус</span>
            </p>
        </a>
    </div>
    <div class="item item-with-badge {{$active==2?"active":""}}">
        <a href="{{route("mobile.cart")}}">
            <p>
                <i class="icon ion-ios-cart"></i>
               <span>Корзина</span>
                <mobile-cart-counter></mobile-cart-counter>
            </p>

        </a>
    </div>
    <div class="item {{$active==3?"active":""}}">
        <a href="{{route("mobile.restorans")}}">
            <p>
                <i class="icon ion-md-beer"></i>
                <span>Заведения</span>
            </p>
        </a>
    </div>


    <div class="item">
        <a href="#menu" class="icon toggleSidebar">
            <p>
                <i class="icon ion-ios-menu"></i>
                <span>Menu</span>
            </p>
        </a>
    </div>
</div>
<!-- * App Bottom Menu -->
