<template>
    <section class="calc">
        <div class="container">
            <h1 class="text-center mt-5">Твои личные<br>кулинарные фантазии</h1>
            <h4 class="text-center"><em>Собери свою вкусняшку</em></h4>
            <div class="row">
                <div class="col-12">

                    <ul class="slides">
                        <li><img @click="changeCalc(1)"
                                 src="https://sun9-70.userapi.com/c857036/v857036007/13eea3/5ttvuSSqtOo.jpg"
                                 class="slide-item" alt=""></li>

                        <li><img @click="changeCalc(2)"
                                 src="https://sun9-25.userapi.com/c853628/v853628795/20a6b5/TsC0AOrG9B4.jpg"
                                 class="slide-item" alt=""></li>
                        <!--                     <li><img @click="changeCalc(3)" src="https://sun9-8.userapi.com/c853628/v853628795/20a69a/a-NFYnkkcFQ.jpg" class="slide-item" alt=""></li>
                                             <li><img @click="changeCalc(4)" src="https://sun9-57.userapi.com/c853628/v853628795/20a6ac/9evk9dyjNRg.jpg" class="slide-item" alt=""></li>

                     -->

                        <li><img @click="changeCalc(3)"
                                 src="https://sun9-65.userapi.com/c854024/v854024983/244a31/AFKYPzAim-s.jpg"
                                 class="slide-item" alt=""></li>
                    </ul>

                    <chelentano-calc v-if="slideIndex===1"></chelentano-calc>

                    <isushi-calc v-if="slideIndex===2"></isushi-calc>


                    <burger-bar-calc v-if="slideIndex===3"></burger-bar-calc>
                </div>
            </div>
        </div>

    </section>
</template>
<script>
    /*   import VueSlickCarousel from 'vue-slick-carousel'
       import 'vue-slick-carousel/dist/vue-slick-carousel.css'
       // optional style for arrows & dots
       import 'vue-slick-carousel/dist/vue-slick-carousel-theme.css'*/
    import ChelentanoCalc from "./ChelentanoCalc";

    export default {

        data() {
            return {
                slideIndex: 1
            }
        },
        methods: {
            changeCalc(number) {
                this.slideIndex = number
            }
        },
        components: {
            ChelentanoCalc
        }
    }
</script>
<style lang="scss">
    .calc {
        background-image: url('https://fastoran.com/images/bg/8.jpg');
        background-size: cover;
        background-position: center center;

        & > .container {
            padding: 20px;
        }

    }

    .carousel-caption {
        bottom: auto;
        top: 20px;

    }

    .slides {
        width: 100%;
        display: flex;
        justify-content: center;
        padding: 20px 0px;

        .slide-item {
            width: 100px;
            height: 100px;
            padding: 10px;
        }
    }

</style>
