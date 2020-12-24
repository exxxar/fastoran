<template>
    <div class="container-fluid d-flex align-items-center flex-wrap w-100 m-0 obedygo "
         style="min-height: 100vh;padding:50px 10px 10px 10px;">

        <!--         v-touch:swipe.left="swipeHandler(0)"
         v-touch:swipe.right="swipeHandler(1)"-->

        <!--   <div class="row d-flex justify-content-center w-100">
               <div class="col-4"><img src="/img/logo_obed_go.jpg" class="img-fluid" style="mix-blend-mode: multiply;"
                                       alt=""></div>
           </div>-->

        <div class="row d-flex justify-content-center flex-wrap w-100 m-0" v-if="part===0">
            <div class="col-lg-4 col-md-6 col-sm-6 d-flex justify-content-center mt-2">
                <div class="item" @click="select(1)">
                    <img src="/img/logo_obed_go.jpg" class="img-fluid" alt="">
                    <h3 class="text-center w-100">Стандарт</h3>
                    <!--<vue-custom-scrollbar class="scroll-area-1" :settings="settings">
                        <p>
                            Доставка осуществляется с 12:00 до 14:00 только в будние дни.

                        </p>
                        <p>
                            Блюда из разделов "стандарт" и "премиум" заказываются ЗА ДЕНЬ. Предзаказ на понедельник
                            также доступен и в выходные дни.
                        </p>
                        <p>
                            Блюда из раздела "экспресс" заказываются и доставляются день в день.
                        </p>

                    </vue-custom-scrollbar>-->
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 d-flex justify-content-center mt-2">
                <div class="item" @click="select(2)">
                    <img src="/img/logo_obed_go.jpg" class="img-fluid" alt="">
                    <h3 class="text-center w-100">Экспрес</h3>

                </div>
            </div>
            <div class="w-100"></div>
            <div class="col-lg-4 col-md-6 col-sm-6 d-flex justify-content-center mt-2">
                <div class="item" @click="select(3)">
                    <img src="/img/logo_obed_go.jpg" class="img-fluid" alt="">
                    <h3 class="text-center w-100">Премиум</h3>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 d-flex justify-content-center mt-2">
                <div class="item" @click="select(4)">
                    <img src="/img/logo_obed_go.jpg" class="img-fluid" alt="">
                    <h3 class="text-center w-100">Собери сам</h3>
                </div>
            </div>
        </div>
        <div class="row w-100 m-0 fixed-main-menu d-none d-md-block" v-else>
            <div class="container upper-menu">
                <div class="row d-flex justify-content-between flex-wrap w-100 p-0 m-0">
                    <div class="col-lg-3 col-6 col-md-3 col-sm-6">
                        <div :class="'item-tab '+(part===1?'active':'')" @click="select(1)">
                            <h3><img src="/img/logo_obed_go.jpg" alt="">Стандарт</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 col-md-3 col-sm-6">
                        <div :class="'item-tab '+(part===2?'active':'')" @click="select(2)">
                            <h3><img src="/img/logo_obed_go.jpg" alt="">Экспресс</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6  col-md-3 col-sm-6">
                        <div :class="'item-tab '+(part===3?'active':'')" @click="select(3)">
                            <h3><img src="/img/logo_obed_go.jpg" alt="">Премиум</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 col-md-3 col-sm-6">
                        <div :class="'item-tab '+(part===4?'active':'')" @click="select(4)">
                            <h3><img src="/img/logo_obed_go.jpg" alt="">Собери сам</h3>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row w-100 d-flex justify-content-center mt-5  mb-2 ">
            <h3 class="text-uppercase text-white text-center col-8 col-sm-8">Полное меню на неделю можно глянуть <a
                href="#" class="text-danger font-weight-bold" v-b-modal.menu >ТУТ</a>
            </h3>
        </div>



        <div class="row w-100 m-0" v-if="part>0">

            <obedy :food_category_selected="part"></obedy>


        </div>


        <div class="mb-5 w-100"></div>

        <obedy-cart-template v-if="is_cart_open" v-on:close="is_cart_open = false" :ready="ready_to_order"/>

        <div class="cart-container d-sm-block d-none" v-if="!is_cart_open">
            <div class="cart-icon cart" @click="is_cart_open = true">Корзина <span
                v-if="countInCart>0">{{countInCart}}</span>
            </div>
            <div class="cart-icon about" v-b-modal.about>О нас</div>
            <div class="cart-icon delivery" v-b-modal.delivery>Доставка</div>
            <div class="cart-icon lottery" @click="openLotteryModal()">Акции</div>
        </div>

        <ul class="footer-container d-sm-none d-flex justify-content-center flex-wrap"
            @mouseleave="bottom_menu_show=false">
            <li class="w-100 p-2 text-center" v-if="!bottom_menu_show" @click="bottom_menu_show=true">Показать меню
                <span class="badge badge-danger" v-if="countInCart>0">{{countInCart}}</span></li>
            <li class="w-100 p-2 text-center" v-if="bottom_menu_show" @click="bottom_menu_show=false">Скрыть меню</li>
            <ul class="w-100 bottom_menu" v-if="bottom_menu_show">
                <li @click="select(2)">Экспрес</li>
                <li @click="select(1)">Стандарт</li>
                <li @click="select(3)">Премиум</li>
                <li @click="select(4)">Собери сам</li>
                <li class="hr"></li>
                <li @click="is_cart_open = true">Корзина <span class="badge badge-danger" v-if="countInCart>0">{{countInCart}}</span>
                </li>
                <li v-b-modal.about>О нас</li>
                <li v-b-modal.delivery>Доставка</li>
                <li @click="openLotteryModal()">Акции</li>

            </ul>

        </ul>



        <b-modal id="about" hide-footer title="О Нас">
            <img src="/img/logo_obed_go.jpg" class="img-fluid" alt="О нас">
            <p class="color--black text-justify">
                Обеды GO - это доставка вкуснейших обедов, приготовленных с любовью. Здесь каждый найдет для себя то,
                что ищет - домашние блюда, блюда "премиум", здоровая еда, стритфуд и многое другое. Вы можете выбрать
                для себя сформированное ежедневное комплексное меню или же собрать свой рацион по вкусу.
            </p>
        </b-modal>

        <b-modal id="delivery" hide-footer title="Условия доставки">
            <ul class="about-list">
                <li>
                    Доставка осуществляется с 12:00 до 14:00 только в будние дни.
                </li>
                <li>
                    Блюда из разделов "стандарт" и "премиум" заказываются ЗА ДЕНЬ. Предзаказ на понедельник также
                    доступен и в выходные дни.
                </li>
                <li>
                    Блюда из раздела "экспресс" заказываются и доставляются день в день.
                </li>

            </ul>
        </b-modal>

        <b-modal id="lottery" size="lg" hide-footer title="Розыгрыши и призы">
            <lottery-slider v-on:enter="selectLottery" v-if="!lottery_id"/>
            <lottery-game :lottery_id="lottery_id" v-if="lottery_id"/>
        </b-modal>

        <div class="to-left" @click="prev()">

        </div>
        <div class="to-right" @click="next()">

        </div>


        <b-modal id="menu" hide-footer hide-header size="lg">
            <b-carousel
                id="carousel-fade"
                style=""
                :controls="true"
                fade
                indicators
                img-width="1024"
                img-height="480"
            >
                <b-carousel-slide
                    img-src="/img/go/full_1.jpg"
                ></b-carousel-slide>
                <b-carousel-slide
                    img-src="/img/go/full_2.jpg"
                ></b-carousel-slide>

            </b-carousel>
        </b-modal>
    </div>
</template>

<script>
    import Obedy from './obedy/ObedyTemplate';
    import ObedyProduct from './obedy/ObedyProduct'
    import ObedyCartTemplate from './obedy/ObedyCartTemplate'
    import LotterySlider from './obedy/lottery/LotterySlider'
    import LotteryGame from './obedy/lottery/LotteryMain'
    import {EventBus} from '../app.js';

    import vueCustomScrollbar from 'vue-custom-scrollbar'
    import "vue-custom-scrollbar/dist/vueScrollbar.css"

    export default {
        data() {
            return {
                lottery_id: null,
                bottom_menu_show: false,
                part: 0,
                is_cart_open: false,
                ready_to_order: false,
                settings: {
                    suppressScrollX: true,
                },

            }
        },
        computed: {
            countInCart() {
                return this.$store.getters.goCartTotalCount;
            },
        },
        mounted() {

            EventBus.$on('open-cart', () => {
                this.is_cart_open = true
                this.ready_to_order = true
            });

            window.addEventListener("keyup", function (e) {

                switch (e.keyCode) {
                    case 27:
                        this.part = 0
                        break;
                    case 37:
                        this.prev();
                        break;
                    case 39:

                        this.next();
                        break;
                }
            }.bind(this));
        },
        methods: {
            swipeHandler(direction) {
                if (direction === 0)
                    this.prev();
                else
                    this.next();
            },
            next() {

                window.scrollTo(0, 0);

                if (this.part === 0) {
                    this.part = 1
                    return
                }

                if (this.part === 4)
                    this.part = 1
                else
                    this.part++;

            },
            prev() {

                window.scrollTo(0, 0);

                if (this.part === 0) {
                    this.part = 1
                    return
                }

                if (this.part === 1)
                    this.part = 4
                else
                    this.part--;


            },
            select(index) {
                this.part = index
            },
            selectLottery(id) {
                console.log("select=>" + id)

                this.lottery_id = id

            },
            openLotteryModal() {
                this.lottery_id = null;
                this.$bvModal.show('lottery')
            }

        },
        components: {
            Obedy, vueCustomScrollbar, ObedyProduct, ObedyCartTemplate, LotterySlider, LotteryGame
        }
    }
</script>

<style lang="scss">

    .about-list {
        color: black;
        justify-content: center;

        li {
            margin-bottom: 10px;
        }
    }

    .fixed-main-menu {
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        width: 100%;
        justify-content: center;
        z-index: 100;
    }

    .bottom_menu {
        text-align: center;
        color: black;
        font-size: 14px;
        transition: .3s;
        z-index: 10;

        li {
            width: 100%;
            padding: 5px;
            cursor: pointer;
            transition: background .3s;

            &:first-child {
                border-top: 1px #c31200 solid;
            }

            &:first-letter {
                color: #c31200;
            }

            &:hover {
                background: #c31200;
                color: white;

                &:first-letter {
                    color: white;
                }

            }


            &.hr {
                width: 100%;
                height: 1px;
                background: #c31200;
                padding: 0;
            }
        }
    }

    .obedygo {
        background: url('/images/12.jpg') no-repeat center center;
        background-size: cover;
        background-attachment: fixed;
    }

    .upper-menu {
        //box-shadow: 1px 1px 2px 0px #000000;
        /* background: url(https://lh3.googleusercontent.com/proxy/S5O2OiLffwro9xyy_sc_j2_SHOTaryH6hXhAVgopPYkW9ECSnH-nH6rtKXjJWW6P5KpY_ewgS3CJSC6k1p7WFNCNaIQszpO8v7pVUhMT0iYZmKgE4DEOtg) center no-repeat; */
        border-radius: 0px 0px 5px 5px;
        background-size: cover;
        background-blend-mode: darken;
        //background-color: #ddd;
    }

    .scroll-area-1 {
        position: relative;
        width: 100%;
        max-height: 200px;
        height: 100%;
        padding: 5px;

        p {
            color: black;
            font-size: 14px;
            margin-top: 10px;
            text-align: justify;

            span {
                font-weight: 800;
                color: #c31200;
            }

            &:first-letter {
                color: #c31200;
                margin-left: 10px;
                font-weight: 700;
            }
        }
    }

    .scroll-area {
        position: relative;
        width: 100%;
        height: 100%;;

    }

    .item {
        background-color: white;
        width: 100%;
        min-height: 275px;
        box-sizing: border-box;
        padding: 10px;
        border: 1px #e9e9e9 solid;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        box-shadow: 0px 0px 5px 3px #000000;
        border-radius: 20px 0px;
        cursor: pointer;
        position: relative;

        &:after {
            content: '';
            position: absolute;
            right: 5px;
            top: 5px;
            border-top: 5px #c92919 solid;
            border-right: 5px #c92919 solid;
            width: 50px;
            height: 50px;
        }

        &:before {
            content: "";
            position: absolute;
            left: 5px;
            top: 5px;
            border-top: 5px #c92919 solid;
            border-left: 5px #c92919 solid;
            width: 50px;
            height: 50px;
            border-radius: 20px 0px 0px 0px;
        }

        img {
            width: 200px;
            opacity: 0.1;
            position: absolute;
        }

        & > p {
            color: black;
            font-size: 12px;

        }

        h3 {
            text-transform: uppercase;
            font-size: xxx-large;
            color: #010101;
            font-family: fantasy;

            &:first-letter {
                color: #c31200;
            }
        }

    }

    .item-tab {
        width: 100%;
        height: 70px;
        margin-top: -5px;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 15px 10px;
        border-radius: 0px 0px 5px 5px;
        background: #ffffff;
        box-shadow: 1px 1px 2px 0px #000000;
        transition: .3s;

        &:hover {
            transition: .3s;
            margin-top: -5px;
        }

        h3 {
            text-transform: uppercase;
            font-size: small;
            color: #a6a6a6;
            font-family: "Roboto", sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;

            img {
                width: 50px;
                height: 50px;
                mix-blend-mode: multiply;
                display: block;
            }

        }


        &:hover,
        &:active,
        &.active {
            background-color: #e3342f;
            cursor: pointer;
            opacity: 1;
            margin-top: 0px;

            h3 {
                color: white;
            }
        }
    }

    .cart-container {
        position: fixed;
        z-index: 100;
        top: 150px;
        width: 110px;
        right: -6px;
        padding: 0;
        margin: 0;


        .cart-icon {
            position: relative;
            z-index: 100;
            /* right: -50px; */
            width: 110px;
            /* padding-right: 50px; */
            height: 80px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-left: 5px #c31200 solid;
            background: white;
            box-shadow: 1px 1px 2px 0px #000000;
            border-radius: 10px 0px 0px 10px;
            color: #c31402;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            cursor: pointer;
            transition: 0.3s;
            flex-wrap: wrap;

            &.cart {
                padding-top: 15px;
                padding-bottom: 15px;

                span {
                    width: 50px;
                    height: 25px;
                    background: #c31301;
                    text-align: center;
                    color: white;
                    border-radius: 10px;
                }
            }

            &.about {
                top: -15px;
                z-index: 99;
                border-left: 5px #ff4000 solid;
            }

            &.delivery {
                top: -30px;
                z-index: 98;
                border-left: 5px #ffa819 solid;
            }

            &.lottery {
                top: -42px;
                z-index: 97;
                border-left: 5px #a5cc44 solid;
                color: #678816;
            }

            &:hover {
                transform: translateX(-5px);
                transition: .3s;
            }
        }
    }


    .footer-container {
        background: white;
        border-top: 3px #9b0f06 solid;
        position: fixed;
        bottom: 0;
        width: 100%;
        left: 0;
        padding: 10px;
        border-radius: 5px 5px 0px 0px;
        text-transform: uppercase;
        font-weight: 800;
        z-index: 10;

        & > li {
            font-size: 10px;
        }
    }

    .to-left {
        position: fixed;
        top: 0;
        left: 0;
        width: 100px;
        height: 100vh;
        z-index: 1;
    }

    .to-right {
        position: fixed;
        top: 0;
        right: 0;
        width: 100px;
        height: 100vh;
        z-index: 1;
    }

    .to-right:hover,
    .to-left:hover {
        background: rgba(255, 255, 255, 0.3);
    }
</style>
