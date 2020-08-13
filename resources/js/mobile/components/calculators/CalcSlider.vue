<template>
    <section class="mobile-calc mt-2">
        <div class="container">
            <h4 class="text-center">Твои личные<br>кулинарные фантазии</h4>
            <h6 class="text-center"><em>Собери свою вкусняшку</em></h6>
            <div class="row">
                <div class="col-12">

                    <ul class="slides">
                        <li><img @click="changeCalc(1)" :style="prepareStyle(1)"
                                 src="https://sun9-70.userapi.com/c857036/v857036007/13eea3/5ttvuSSqtOo.jpg"
                                 class="slide-item" alt=""></li>

                      <!--  <li><img @click="changeCalc(2)" :style="prepareStyle(2)"
                                 src="https://sun9-25.userapi.com/c853628/v853628795/20a6b5/TsC0AOrG9B4.jpg"
                                 class="slide-item" alt=""></li>-->
                        <!--                     <li><img @click="changeCalc(3)" src="https://sun9-8.userapi.com/c853628/v853628795/20a69a/a-NFYnkkcFQ.jpg" class="slide-item" alt=""></li>
                                             <li><img @click="changeCalc(4)" src="https://sun9-57.userapi.com/c853628/v853628795/20a6ac/9evk9dyjNRg.jpg" class="slide-item" alt=""></li>

                     -->

                        <li><img @click="changeCalc(3)" :style="prepareStyle(3)"
                                 src="https://sun9-65.userapi.com/c854024/v854024983/244a31/AFKYPzAim-s.jpg"
                                 class="slide-item" alt=""></li>

                        <li><img @click="changeCalc(4)" :style="prepareStyle(4)"
                                 src="https://sun9-60.userapi.com/VQUteM8umQoJlf-iFwhB9pyglhTAvWdV8_t2UA/b2zse5uYzfk.jpg"
                                 class="slide-item" alt=""></li>
                    </ul>

                    <chelentano-calc v-if="slideIndex===1"></chelentano-calc>

                   <!-- <isushi-calc v-if="slideIndex===2"></isushi-calc>-->


                    <m-burger-bar-calc v-if="slideIndex===3"></m-burger-bar-calc>

                    <svinya-calc v-if="slideIndex===4"></svinya-calc>
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
    import IsushiCalc from "./IsushiCalc";
    import MBurgerBarCalc from "./BurgerBarCalc";
    import SvinyaCalc from "./SvinyaCalc";

    export default {
        props: {
            active: {
                type: Number,
                default: 1
            },
        },
        data() {
            return {
                slideIndex: 1
            }
        },
        mounted() {
            this.slideIndex = Math.max(Math.min(this.active, 4), 1);
        },
        methods: {
            changeCalc(number) {
                this.slideIndex = number
            },
            prepareStyle(number) {
                return this.slideIndex === number ? "border-bottom: 2px #fbb51c solid;" : "";
            }
        },
        components: {
            ChelentanoCalc, IsushiCalc, MBurgerBarCalc, SvinyaCalc
        }
    }
</script>
<style lang="scss">


    .mobile-calc {

        background-size: cover;
        background-position: center center;

        & > .container {
            padding: 0px;
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
        list-style: none;


        .slide-item {
            width: 80px;
            height: 80px;
            padding: 2px;
            border-bottom: 2px white solid;


        }
    }

</style>
