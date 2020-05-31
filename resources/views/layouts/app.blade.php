<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="yandex-verification" content="dc164e606696b6b2"/>
    <meta name="description" content="Доставка самой вкусной еды из ресторанов и заведений общественного питания города Донецк и города Макеевка. Доставка продуктов, цветов, медикаментов, а также вызов курьера!">
    <title>Fastoran - служба твоей доставки!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{asset('img/icons/icon-72x72.png')}}">
    <link rel="apple-touch-icon" href="{{asset('img/icons/icon-72x72.png')}}">
    <!-- Stylesheets -->

    <link rel="stylesheet" href="{{url(env("APP_DEBUG")?'css/app.css':'css/app.min.css')}}?ver={{ config('app.version')}}">
</head>

<body>

<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a
    href="https://vk.com/fastoran">upgrade
    your browser</a> to improve your experience and security.</p>
<![endif]-->

<!-- Main wrapper -->
<div class="wrapper" id="wrapper">
    <notifications :position="'top left'" :group="'info'"></notifications>

    @yield("content")
    @include("fastoran.partials.cart-box")
    {{--@include("fastoran.partials.login-box")--}}
    @include("fastoran.partials.contact-modal-box")
    @include("fastoran.partials.custom-cart-modal-box")
    @include("fastoran.partials.custom-phone-modal-box")
    @include("fastoran.partials.deliveryman-quest-order-modal-box")
    @include("fastoran.partials.profile-box")



</div><!-- //Main wrapper -->

<!-- JS Files -->

<!-- Modernizer js -->
<script src="{{url(env("APP_DEBUG")?'js/vendor/modernizr-3.5.0.min.js':'js/vendor/modernizr-3.5.0.min.min.js')}}?ver={{ config('app.version')}}"></script>
<script src="{{url(env("APP_DEBUG")?'js/app.js':'js/app.min.js')}}?ver={{ config('app.version')}}"></script>
<script src="{{url(env("APP_DEBUG")?'js/plugins.js':'js/plugins.min.js')}}?ver={{ config('app.version')}}"></script>
<script src="{{url(env("APP_DEBUG")?'js/active.js':'js/active.min.js')}}?ver={{ config('app.version')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" async></script>
<script>
    document.addEventListener('lazybeforeunveil', function(e){
        var bg = e.target.getAttribute('data-bg');
        if(bg){
            e.target.style.backgroundImage = 'url(' + bg + ')';
        }
    });
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
