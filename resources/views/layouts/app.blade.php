<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="yandex-verification" content="dc164e606696b6b2" />
    <title>Fastoran - служба твоей доставки!</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- Favicons -->
    <link rel="shortcut icon" href="{{asset('img/icons/icon-72x72.png')}}">
    <link rel="apple-touch-icon" href="{{asset('img/icons/icon-72x72.png')}}">
    <!-- Stylesheets -->

    <link rel="stylesheet" href="{{url('css/app.css')}}">


    <!-- Modernizer js -->
    <script src="{{url('js/vendor/modernizr-3.5.0.min.js')}}"></script>

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
        @include("fastoran.partials.login-box")
    </div><!-- //Main wrapper -->

<!-- JS Files -->

<script src="{{url('js/app.js')}}"></script>
<script src="{{url('js/plugins.js')}}"></script>
<script src="{{url('js/active.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" async></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js"></script>
<script>
    $(document).ready(function () {
        $('#clock').countdown('2020/4/06').on('update.countdown', function (event) {
            var $this = $(this).html(event.strftime(''
                + '<span class="h1 font-weight-bold">%D</span> Дней%!d'
                + '<span class="h1 font-weight-bold">%H</span> Часов'
                + '<span class="h1 font-weight-bold">%M</span> Минут'
                + '<span class="h1 font-weight-bold">%S</span> Секунд'));
        });
    });


</script>

    <!— Yandex.Metrika counter —>
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(61797661, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/61797661" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!— /Yandex.Metrika counter —>

    <!— Global site tag (gtag.js) - Google Analytics —>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-163253265-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-163253265-1');
    </script>
</body>
</html>
