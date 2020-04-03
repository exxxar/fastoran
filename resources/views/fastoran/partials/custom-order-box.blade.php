<div class="accountbox-wrapper">
    <div class="accountbox text-left">
        <ul class="nav accountbox__filters" id="myTab" role="tablist">
            <li>
                <a class="active" id="log-tab" data-toggle="tab" href="#log" role="tab" aria-controls="log"
                   aria-selected="true">Login</a>
            </li>
            <li>
                <a id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                   aria-selected="false">Register</a>
            </li>
        </ul>
        <div class="accountbox__inner tab-content" id="myTabContent">
            <div class="accountbox__login tab-pane fade show active" id="log" role="tabpanel"
                 aria-labelledby="log-tab">
                <form action="#">
                    <div class="single-input">
                        <input class="cr-round--lg" type="text" placeholder="User name or email">
                    </div>
                    <div class="single-input">
                        <input class="cr-round--lg" type="password" placeholder="Password">
                    </div>
                    <div class="single-input">
                        <button type="submit" class="food__btn"><span>Go</span></button>
                    </div>
                    <div class="accountbox-login__others">
                        <h6>Or login with</h6>
                        <div class="social-icons">
                            <ul>
                                <li class="facebook"><a href="https://www.facebook.com/"><i
                                            class="fa fa-facebook"></i></a></li>
                                <li class="twitter"><a href="https://twitter.com/"><i class="fa fa-twitter"></i></a>
                                </li>
                                <li class="pinterest"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
            <div class="accountbox__register tab-pane fade" id="profile" role="tabpanel"
                 aria-labelledby="profile-tab">
                <form action="#">
                    <div class="single-input">
                        <input class="cr-round--lg" type="text" placeholder="User name">
                    </div>
                    <div class="single-input">
                        <input class="cr-round--lg" type="email" placeholder="Email address">
                    </div>
                    <div class="single-input">
                        <input class="cr-round--lg" type="password" placeholder="Password">
                    </div>
                    <div class="single-input">
                        <input class="cr-round--lg" type="password" placeholder="Confirm password">
                    </div>
                    <div class="single-input">
                        <button type="submit" class="food__btn"><span>Sign Up</span></button>
                    </div>
                </form>
            </div>
            <span class="accountbox-close-button"><i class="zmdi zmdi-close"></i></span>
        </div>
    </div>
</div><!-- //Login Form -->
