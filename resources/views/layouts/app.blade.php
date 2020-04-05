<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Fastoran - служба твоей доставки!</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @laravelPWA
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

        @include("fastoran.partials.login-box")
        @include("fastoran.partials.cart-box")
    </div><!-- //Main wrapper -->

<!-- JS Files -->

<script src="{{url('js/app.js')}}"></script>
{{--<script src="{{url('js/vendor/jquery-3.2.1.min.js')}}"></script>
<script src="{{url('js/popper.min.js')}}"></script>
<script src="{{url('js/bootstrap.min.js')}}"></script>--}}
<script src="{{url('js/plugins.js')}}"></script>
<script src="{{url('js/active.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
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
</body>
</html>
