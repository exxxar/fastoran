<section class="food__feature__area section-padding--lg section-padding--xs bg--white">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="section__title title__style--2 service__align--center">
                    <h2 class="title__line">Широкий выбор кухонь</h2>
                    <p>Возможно, это то что ты ищещь! </p>
                </div>
            </div>
        </div>
        <div class="row mt--40">
            <!-- Start Single Feature -->
            @foreach($kitchens as $kitchen)
            <div class="col-md-6 col-lg-4 col-sm-12 mb-4">
                <div class="square">
                    <div class="feature text-center">
                        <div class="feature__thumb">
                            <a href="#">
                                <img class="lazyload" data-src="{{$kitchen->img}}"
                                     alt="{{$kitchen->alt_description}}">
                            </a>
                        </div>
                        <div class="feature__details">
                            <h4><a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/menu-details.html">{{$kitchen->name}}</a></h4>
                            {{--<h6>All types of Bread Iteam are available</h6>
                            <p>adipisicing elid tempor in dolore magna alua. Ut enim ad minim veniamexercitation
                                llamco laboris nisi ut aliqui</p>--}}
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            <!-- End Single Feature -->
          {{--  <!-- Start Single Feature -->
            <div class="col-md-6 col-lg-4 col-sm-12 sm--mt--40">
                <div class="square">
                    <div class="feature text-center">
                        <div class="feature__thumb">
                            <a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/menu-details.html">
                                <img src="https://d29u17ylf1ylz9.cloudfront.net/aahar/images/service/2.png"
                                     alt="feature images">
                            </a>
                        </div>
                        <div class="feature__details">
                            <h4><a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/menu-details.html">Muffin</a>
                            </h4>
                            <h6>All types of Muffin Iteam are available</h6>
                            <p>adipisicing elid tempor in dolore magna alua. Ut enim ad minim veniamexercitation
                                llamco laboris nisi ut aliqui</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Single Feature -->
            <!-- Start Single Feature -->
            <div class="col-md-6 col-lg-4 col-sm-12 sm--mt--40 md--mt--40">
                <div class="square">
                    <div class="feature text-center">
                        <div class="feature__thumb">
                            <a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/menu-details.html">
                                <img src="https://d29u17ylf1ylz9.cloudfront.net/aahar/images/service/3.png"
                                     alt="feature images">
                            </a>
                        </div>
                        <div class="feature__details">
                            <h4><a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/menu-details.html">Pastry &
                                    Roll</a></h4>
                            <h6>All types of Pastry Iteam are available</h6>
                            <p>adipisicing elid tempor in dolore magna alua. Ut enim ad minim veniamexercitation
                                llamco laboris nisi ut aliqui</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Single Feature -->
            <!-- End Single Feature -->--}}
        </div>
    </div>
</section>
