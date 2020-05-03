<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="description"
          content="Доставка самой вкусной еды из ресторанов и заведений общественного питания города Донецк и города Макеевка. Доставка продуктов, цветов, медикаментов, а также вызов курьера!">
    <title>Fastoran - служба твоей доставки!</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="keywords" content="донецк, рестораны, еда, донмак, аркадия, дайнер, джон, пицца"/>
    <!-- Favicons -->
    <link rel="shortcut icon" href="{{asset('img/icons/icon-72x72.png')}}">
    <link rel="apple-touch-icon" href="{{asset('img/icons/icon-72x72.png')}}">
    <!-- Stylesheets -->
    @laravelPWA
    <link rel="stylesheet" href="{{url('../css/mobile/app.min.css')}}?ver={{ config('app.version')}}">
</head>

<body>

@include("mobile.partials.loading")
@include("mobile.partials.header")
@include("mobile.partials.main.search_box")

<div id="wrapper">
<!-- App Capsule -->
<div id="appCapsule">
    <div class="appContent" >

        <notifications :position="'top left'" :width="'100%'" :group="'info'" :classes="'custom-style'"></notifications>
        @yield("content")

        @include("mobile.partials.footer")
    </div>

</div>
<!-- * appCapsule -->

@include("mobile.partials.main.sidebar_menu")
</div>

<!-- ///////////// Js Files ////////////////////  -->

<script src="{{url('js/app.min.js')}}?ver={{ config('app.version')}}"></script>
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
            items: 1,
            loop: true
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


    })
</script>


</body>

</html>
