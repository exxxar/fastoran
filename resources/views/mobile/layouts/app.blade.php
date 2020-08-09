<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="description"
          content="Доставка самой вкусной еды из ресторанов и заведений общественного питания города Донецк и города Макеевка. Доставка продуктов, цветов, медикаментов, а также вызов курьера!">
    <title>Fastoran - служба твоей доставки!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=0">
    <meta name="keywords" content="донецк, рестораны, еда, донмак, аркадия, дайнер, джон, пицца"/>
    <!-- Favicons -->
    <link rel="shortcut icon" href="{{asset('img/icons/icon-72x72.png')}}">
    <link rel="apple-touch-icon" href="{{asset('img/icons/icon-72x72.png')}}">

    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('img/icons/icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('img/icons/icon-192x192.png')}}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{asset('img/icons/icon-152x152.png')}}">

    <meta name="apple-mobile-web-app-capable" content="yes" />
    <link href="{{asset('img/icons/splash-2048x2732.png')}}" sizes="2048x2732" rel="apple-touch-startup-image" />
    <link href="{{asset('img/icons/splash-1668x2224.png')}}" sizes="1668x2224" rel="apple-touch-startup-image" />
    <link href="{{asset('img/icons/splash-1536x2048.png')}}" sizes="1536x2048" rel="apple-touch-startup-image" />
    <link href="{{asset('img/icons/splash-1125x2436.png')}}" sizes="1125x2436" rel="apple-touch-startup-image" />
    <link href="{{asset('img/icons/splash-1242x2208.png')}}" sizes="1242x2208" rel="apple-touch-startup-image" />
    <link href="{{asset('img/icons/splash-750x1334.png')}}" sizes="750x1334" rel="apple-touch-startup-image" />
    <link href="{{asset('img/icons/splash-640x1136.png')}}" sizes="640x1136" rel="apple-touch-startup-image" />

    <!-- Stylesheets -->
    @laravelPWA
    <link rel="stylesheet" href="{{url(env("APP_DEBUG")?'css/mobile/app.css':'css/mobile/app.min.css' )}}?ver={{ config('app.version')}}">
</head>

<body>

@include("mobile.partials.loading")
@include("mobile.partials.header")
@include("mobile.partials.main.search_box")

<div id="wrapper">
<!-- App Capsule -->
<div id="appCapsule">
    <div class="appContent" >

        <notifications :position="'top left'" :width="'100%'" :group="'info'" :classes="'my-notify-style'"></notifications>
        @yield("content")

        @include("mobile.partials.footer")
    </div>

</div>
<!-- * appCapsule -->

@include("mobile.partials.main.sidebar_menu")
</div>

<!-- ///////////// Js Files ////////////////////  -->

<script src="{{url(env("APP_DEBUG")?'js/app.js':'js/app.min.js')}}?ver={{ config('app.version')}}"></script>
<script src="{{url('js/owl.carousel.min.js')}}?ver={{ config('app.version')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" async></script>
<script>
    $(document).ready(function () {
        setTimeout(() => $(".loading").css({"display": "none"}), 300);
        $(".toggleSidebar").click(() => {
            if ($("body").hasClass("sidebarActive")) {
                $(".sidebarWrapper").css({"display": "none"})
                $("body").removeClass("sidebarActive");
                $(".sidebar").removeClass("is-passive").removeClass("is-active");
            } else {
                $(".sidebarWrapper").css({"display": "block"})
                $("body").addClass("sidebarActive");
                $(".sidebar").addClass("is-passive").addClass("is-active");
            }
        })

        $(".cardOverlayCarousel").owlCarousel({
            margin: 20,
            items: 2,
            loop: true,
        })

        $(".postCarousel").owlCarousel({
            items: 3,
            margin: 10,
            loop: true
        })

        $(".buttonCarousel").owlCarousel({
            margin: 10,
            items: 5,
            loop: true,
            autoWidth: true
        })

        $('.owl-dots').attr('aria-hidden', 'true');
        $('button.btn.btn-outline-success.product-item__btn').attr('aria-hidden', 'true');

    })
</script>

<!— Yandex.Metrika counter —>
<script type="text/javascript" async>
    (function (m, e, t, r, i, k, a) {
        m[i] = m[i] || function () {
            (m[i].a = m[i].a || []).push(arguments)
        };
        m[i].l = 1 * new Date();
        k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
    })
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(61797661, "init", {
        clickmap: true,
        trackLinks: true,
        accurateTrackBounce: true,
        webvisor: true
    });
</script>
<noscript>
    <div><img src="https://mc.yandex.ru/watch/61797661" style="position:absolute; left:-9999px;" alt=""/></div>
</noscript>
<!— /Yandex.Metrika counter —>

<!— Global site tag (gtag.js) - Google Analytics —>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-163253265-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());

    gtag('config', 'UA-163253265-1');
</script>

</body>

</html>
