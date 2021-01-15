<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="yandex-verification" content="dc164e606696b6b2"/>
    <meta name="description" content="Доставка самых вкусных обедов из ресторанов для любителей вкусной еды для Донецка и города Макеевки.">
    <title>Обеды GO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=0">

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{asset('img/icons/icon-72x72.png')}}">
    <link rel="apple-touch-icon" href="{{asset('img/icons/icon-72x72.png')}}">
    <!-- Stylesheets -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{url(env("APP_DEBUG")?'css/app.css':'css/app.min.css')}}?ver={{ config('app.version')}}">
</head>

<body>

<style>
    body {
        font-family: 'Roboto', sans-serif;
    }
</style>
<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a
    href="https://vk.com/fastoran">upgrade
    your browser</a> to improve your experience and security.</p>
<![endif]-->

<!-- Main wrapper -->
<div class="wrapper" id="wrapper">
    <notifications :position="'top left'" :group="'info'"></notifications>

    @yield("content")


</div><!-- //Main wrapper -->

<!-- JS Files -->


<script src="{{url(env("APP_DEBUG")?'js/app.js':'js/app.min.js')}}?ver={{ config('app.version')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" async></script>

</body>
</html>
