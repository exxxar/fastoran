<template>
    <div class="container-fluid d-flex align-items-center flex-wrap w-100 m-0 obedygo "
         style="min-height: 100vh;padding:50px 10px 10px 10px;">
        <!--   <div class="row d-flex justify-content-center w-100">
               <div class="col-4"><img src="/img/logo_obed_go.jpg" class="img-fluid" style="mix-blend-mode: multiply;"
                                       alt=""></div>
           </div>-->

        <div class="row d-flex justify-content-center flex-wrap w-100 m-0" v-if="part===0">
            <div class="col-lg-4 col-md-6 col-sm-6 d-flex justify-content-center mt-2">
                <div class="item">
                    <img src="/img/logo_obed_go.jpg" class="img-fluid" alt="">
                    <h3 class="text-center w-100">Стандарт</h3>
                    <button class="btn btn-outline-danger w-100 p-3" @click="select(1)">Let's GO Обедать!</button>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 d-flex justify-content-center mt-2">
                <div class="item">
                    <img src="/img/logo_obed_go.jpg" class="img-fluid" alt="">
                    <h3 class="text-center w-100">Экспрес</h3>
                    <button class="btn btn-outline-danger w-100 p-3" @click="select(2)">Let's GO Обедать!</button>
                </div>
            </div>
            <div class="w-100"></div>
            <div class="col-lg-4 col-md-6 col-sm-6 d-flex justify-content-center mt-2">
                <div class="item">
                    <img src="/img/logo_obed_go.jpg" class="img-fluid" alt="">
                    <h3 class="text-center w-100">Премиум</h3>
                    <button class="btn btn-outline-danger w-100 p-3" @click="select(3)">Let's GO Обедать!</button>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 d-flex justify-content-center mt-2">
                <div class="item">
                    <img src="/img/logo_obed_go.jpg" class="img-fluid" alt="">
                    <h3 class="text-center w-100">Собери сам</h3>
                    <button class="btn btn-outline-danger w-100 p-3" @click="select(4)">Let's GO Обедать!</button>
                </div>
            </div>
        </div>
        <div class="row w-100 m-0 fixed-main-menu d-none d-md-block" v-else>
            <div class="container upper-menu">
                <div class="row d-flex justify-content-between flex-wrap w-100 p-0 m-0">
                    <div class="col-lg-3 col-6 col-md-3 col-sm-6 mb-2">
                        <div :class="'item-tab '+(part===1?'active':'')" @click="select(1)">
                            <h3>Стандарт</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 col-md-3 col-sm-6 mb-2">
                        <div :class="'item-tab '+(part===2?'active':'')" @click="select(2)">
                            <h3>Экспресс</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6  col-md-3 col-sm-6 mb-2">
                        <div :class="'item-tab '+(part===3?'active':'')" @click="select(3)">
                            <h3>Премиум</h3>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 col-md-3 col-sm-6 mb-2">
                        <div :class="'item-tab '+(part===4?'active':'')" @click="select(4)">
                            <h3>Собери сам</h3>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="row w-100 m-0" v-if="part>0">

            <obedy :food_category_selected="part"></obedy>


        </div>


        <div class="mb-5 w-100"></div>

        <obedy-cart-template v-if="is_cart_open" v-on:close="is_cart_open = false"/>

        <div class="cart-container d-sm-block d-none" v-if="!is_cart_open">
            <div class="cart-icon cart" @click="is_cart_open = true">Корзина <span
                v-if="countInCart>0">{{countInCart}}</span>
            </div>
            <div class="cart-icon about" v-b-modal.about>О нас</div>
            <div class="cart-icon delivery" v-b-modal.delivery>Доставка</div>
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
                <li>Корзина <span class="badge badge-danger" v-if="countInCart>0">{{countInCart}}</span></li>
                <li v-b-modal.about>О нас</li>
                <li v-b-modal.delivery>Доставка</li>

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
    </div>
</template>

<script>
    import Obedy from './obedy/ObedyTemplate';
    import ObedyProduct from './obedy/ObedyProduct'
    import ObedyCartTemplate from './obedy/ObedyCartTemplate'

    import vueCustomScrollbar from 'vue-custom-scrollbar'
    import "vue-custom-scrollbar/dist/vueScrollbar.css"

    export default {
        data() {
            return {
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
        methods: {
            select(index) {
                this.part = index
            },

        },
        components: {
            Obedy, vueCustomScrollbar, ObedyProduct, ObedyCartTemplate
        }
    }
</script>

<style lang="scss">

    .about-list {
        color: black;
        justify-content: center;
        li {
            margin-bottom:10px;
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
        background: url('/img/bg_go.jpg') no-repeat center center;
        background-size: cover;
        background-attachment: fixed;
    }

    .upper-menu {
        padding: 15px;
    }

    .scroll-area {
        position: relative;
        width: 100%;
        height: 100%;
        padding-bottom: 150px;
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

        img {
            width: 200px;
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
        opacity: 0.6;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 15px 10px;
        border-radius: 5px;
        background: #eae9e9;
        box-shadow: 1px 1px 2px 0px #000000;

        h3 {
            text-transform: uppercase;
            font-size: small;
            color: #a6a6a6;
            font-family: "Roboto", sans-serif;


        }


        &:hover,
        &:active,
        &.active {
            background-color: #e3342f;
            cursor: pointer;
            opacity: 1;

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

        & > li {
            font-size: 10px;
        }
    }
</style>
