<!DOCTYPE html>
<html lang="en" class="hydrated"><head>
    <meta charset="utf-8"><style data-styles="">ion-icon{visibility:hidden}.hydrated{visibility:inherit}</style>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Bitter</title>
    <link rel="stylesheet" href="{{asset('css/desktop/desktop.css')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="Bitter Bootstrap 4 Based Mobile Template">
    <meta name="keywords" content="android, application template, cordova, hybrid, magazine, mobile, mobile template, modern, news, phonegap, responsive, social, web app, web app kit, webview">
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.esm.js" data-stencil-namespace="ionicons"></script><script nomodule="" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js" data-stencil-namespace="ionicons"></script></head>

<body>

<div class="cacheWarning alert alert-danger">
    <h3>Clear your Cache</h3>
    <p>Please <code>CMD + Shift + R</code> or <code>CTRL + Shift + R</code> to clear cache.</p>
    <h3>You are on a Mobile Device?</h3>
    Click for the preview <a href="preview/" target="_blank"><strong>here</strong></a>.
</div>

<div class="pageLoader" style="display: none;">
    <div class="in">
        <div class="imgWrapper">
            <img src="assets/img/logo.png" alt="logo" class="itemlogo">
            <div class="spin">
                <div class="spinner-border text-light" role="status"></div>
            </div>
        </div>
        <p>Live Preview Loading...</p>
    </div>
</div>
<!-- hero -->
<div class="hero">
    <div class="container">

        <!-- content -->
        <div class="textContent" style="margin-top: 60px">

            <div class="hero-header">
                <div class="itemLogo">
                    <img src="assets/img/logo.png" alt="logo" class="image">
                </div>
            </div>


            <h1 class="heroTitle">
                HTML Mobile <br>Template
            </h1>
            <div class="hero-content">
                <ul class="heroList">
                    <li>
                        <ion-icon name="checkmark-outline" role="img" class="md hydrated" aria-label="checkmark outline"></ion-icon>
                        Bootstrap 4 based
                    </li>
                    <li>
                        <ion-icon name="checkmark-outline" role="img" class="md hydrated" aria-label="checkmark outline"></ion-icon>
                        Modern and stylish
                    </li>
                    <li>
                        <ion-icon name="checkmark-outline" role="img" class="md hydrated" aria-label="checkmark outline"></ion-icon>
                        Application look designed
                    </li>
                </ul>
            </div>



            <div class="buttonWrapper">
                <a href="https://themeforest.net/item/bitter-multipurpose-mobile-application-template/25262018" class="btn btn-success mr-4" target="_blank">
                    <ion-icon name="cart-outline" role="img" class="md hydrated" aria-label="cart outline"></ion-icon>
                    Buy Now
                </a>

                <a href="#qr" class="btn btn-secondary" id="hero-qr-button">
                    <ion-icon name="qr-code-outline" role="img" class="md hydrated" aria-label="qr code outline"></ion-icon>
                    Try on Your Phone
                </a>

            </div>

            <div class="qrBlock" style="display: none;">
                <img src="assets/img/qr.jpg" alt="qr" class="qr">
                <div class="text">
                    <strong>View on your <br>Mobile Device</strong>
                    Scan the QR code to <br>view on your mobile device
                </div>
            </div>



        </div>
        <!-- content -->

        <!-- phone -->
        <div class="phoneContent">
            <div class="phoneWrapper">
                <div class="in">
                    <iframe class="getFrame" src="{{route("mobile.index")}}" frameborder="0"></iframe>
                </div>
            </div>
        </div>
        <!-- phone -->



    </div>

</div>
<!-- * hero -->


<div class="qr-button" style="display: none;">
    <a href="javascript:;" class="close-button">
        <ion-icon name="close-circle" role="img" class="md hydrated" aria-label="close circle"></ion-icon>
    </a>
    <img src="assets/img/qr.jpg" alt="qr" class="qr">
    <div class="text">
        <div class="qr-text">
            Scan the QR code to view on your mobile device
        </div>
    </div>
</div>

<div class="container">




    <!-- Features -->
    <div class="features">
        <div class="section-heading">
            <h2 class="title">Discover<br>Some Features.</h2>
        </div>


        <div class="feature-list">
            <div class="row">

                <div class="col-4">
                    <div class="item">
                        <div class="iconWrapper">
                            <img src="assets/img/item/bootstrap.png" alt="cordova" style="margin-right: -2px;">
                        </div>
                        <div class="text">
                            <strong>Bootstrap 4 Based</strong>
                            Developed on bootstrap, the most popular css framework.
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="item">
                        <div class="iconWrapper">
                            <ion-icon name="checkbox-outline" role="img" class="md hydrated" aria-label="checkbox outline"></ion-icon>
                        </div>
                        <div class="text">
                            <strong>UI Components</strong>
                            Ready to use many components. They are great for the mobile interface.
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="item">
                        <div class="iconWrapper">
                            <ion-icon name="color-fill-outline" role="img" class="md hydrated" aria-label="color fill outline"></ion-icon>
                        </div>
                        <div class="text">
                            <strong>User Friendly Design</strong>
                            Designed with the popular design lines for the best user experience. .
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="item">
                        <div class="iconWrapper">
                            <ion-icon name="cloud-upload-outline" role="img" class="md hydrated" aria-label="cloud upload outline"></ion-icon>
                        </div>
                        <div class="text">
                            <strong>Life-time Free Updates</strong>
                            Purchase once &amp; get life-time free updates.
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="item">
                        <div class="iconWrapper">
                            <ion-icon name="logo-html5" role="img" class="md hydrated" aria-label="logo html5">
                            </ion-icon>
                        </div>
                        <div class="text">
                            <strong>Clean Markup</strong>
                            Clean and readable code structure and validated by W3C.
                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="item">
                        <div class="iconWrapper">
                            <ion-icon name="logo-sass" role="img" class="md hydrated" aria-label="logo sass">
                            </ion-icon>
                        </div>
                        <div class="text">
                            <strong>Sass Css Files</strong>
                            Most powerful professional grade CSS extension language.
                        </div>
                    </div>
                </div>



            </div>
        </div>





    </div>
    <!-- * Features -->



    <!-- qrWidget -->
    <div class="qrWidget" id="qr">
        <div class="section-heading">
            <h2 class="title">
                Try it <br>on Your <br>Mobile Device
            </h2>
            <div class="text">
                Scan to view on your mobile device
            </div>
        </div>
        <div class="qrCodeImg">
            <img src="assets/img/qr.jpg" alt="qr" class="img">
        </div>
    </div>
    <!-- * qrWidget -->



</div>


<div class="footer">
    <div class="container">
        Copyright © <a href="https://themeforest.net/user/bragher/portfolio" target="_blank">Bragher</a> 2020. All
        Rights Reserved.
        <a href="#" class="gotopButton">
            <ion-icon name="arrow-up" role="img" class="md hydrated" aria-label="arrow up"></ion-icon>
        </a>
    </div>
</div>


<div class="sidebar">
    <a href="#" class="toggleButton sidebarTrigger">
        <ion-icon name="arrow-forward-outline" role="img" class="md hydrated" aria-label="arrow forward outline"></ion-icon>
    </a>
    <div class="sidebarTitle">
        Our Products
    </div>
    <div class="sidebarFooter">
        <a href="https://themeforest.net/user/bragher/portfolio" class="btn btn-success" target="_blank">
            View Our Portfolio
        </a>
    </div>
    <div class="sidebarProducts">
        <div class="row">
            <a href="https://finapp.bragherstudio.com" class="item col-6" data-name="Finapp" target="_blank"><img src="https://www.bragherstudio.com/data/logo/finapp.png" alt="Finapp" class="productlogo"><strong>Finapp</strong><div class="text">Wallet &amp; Banking Mobile HTML Template</div></a><a href="https://mobilekit.bragherstudio.com" class="item col-6" data-name="Mobilekit" target="_blank"><img src="https://www.bragherstudio.com/data/logo/mobilekit.png" alt="Mobilekit" class="productlogo"><strong>Mobilekit</strong><div class="text">Mobile UI Kit HTML Template</div></a><a href="https://bitter.bragherstudio.com" class="item col-6" data-name="Bitter" target="_blank"><img src="https://www.bragherstudio.com/data/logo/bitter.png" alt="Bitter" class="productlogo"><strong>Bitter</strong><div class="text">Mobile HTML Template</div></a></div>
    </div>
</div>

<div class="mobileDetected">
    <div class="in">
        <div><img src="assets/img/logo.png" alt="logo" class="logo"></div>
        Tap button to live preview.
        <div class="mt-5">
            <a href="/preview" class="btn btn-success" target="_blank">Live Preview</a>
        </div>
    </div>
</div>

<script
    src="https://code.jquery.com/jquery-3.5.0.slim.min.js"
    integrity="sha256-MlusDLJIP1GRgLrOflUQtshyP0TwT/RHXsI1wWGnQhs="
    crossorigin="anonymous"></script>
<script src="https://bragherstudio.com/data/data.js"></script>
<script src="{{asset('js/desktop/desktop.js')}}"></script>
<script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>



<div id="fatkun-drop-panel">
    <a id="fatkun-drop-panel-close-btn">×</a>
    <div id="fatkun-drop-panel-inner">
        <div class="fatkun-content">
            <svg class="fatkun-icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="5892"><path d="M494.933333 782.933333c2.133333 2.133333 4.266667 4.266667 8.533334 6.4h8.533333c6.4 0 10.666667-2.133333 14.933333-6.4l2.133334-2.133333 275.2-275.2c8.533333-8.533333 8.533333-21.333333 0-29.866667-8.533333-8.533333-21.333333-8.533333-29.866667 0L533.333333 716.8V128c0-12.8-8.533333-21.333333-21.333333-21.333333s-21.333333 8.533333-21.333333 21.333333v588.8L249.6 475.733333c-8.533333-8.533333-21.333333-8.533333-29.866667 0-8.533333 8.533333-8.533333 21.333333 0 29.866667l275.2 277.333333zM853.333333 874.666667H172.8c-12.8 0-21.333333 8.533333-21.333333 21.333333s8.533333 21.333333 21.333333 21.333333H853.333333c12.8 0 21.333333-8.533333 21.333334-21.333333s-10.666667-21.333333-21.333334-21.333333z" p-id="5893"></path></svg>
            <div class="fatkun-title">Drag and Drop</div>
            <div class="fatkun-desc">The image will be downloaded</div>
        </div>
    </div>
</div></body></html>
