<template>
    <div class="cart-modal">
        <div class="cart-modal-inner">
            <div class="custom-modal-header">
                <button class="btn btn-link" @click="closeCart()">Закрыть</button>
            </div>

            <vue-custom-scrollbar class="scroll-area" :settings="settings" :tagname="'ul'">
                <li v-for="item in itemsInCart" class="day-item-wrapper" v-if="countInCart>0">
                    <obedy-product :product="item.product"/>

                </li>
                <li v-if="countInCart===0">

                    <img src="/img/logo_obed_go.jpg" class="img-fluid" alt="">
                    <h3 class="text-uppercase text-center">В корзине пусто...</h3>
                </li>


            </vue-custom-scrollbar>

            <div class="custom-modal-footer" v-if="countInCart>0">

                <button class="btn btn-danger w-100 p-3 text-uppercase font-weight-bold" v-if="!ready_to_order"
                        :disabled="!hasMainProductInCart()"
                        @click="ready_to_order = true">Оформить
                    <strong>{{goCartTotalPrice}} руб</strong>
                </button>
                <button class="btn btn-outline-danger mt-2 w-100 p-3 text-uppercase font-weight-bold"
                        v-if="!ready_to_order"
                        @click="clearCart">Очистить
                </button>

                <form v-on:submit.prevent="sendOrder" class="order-form w-100" v-if="ready_to_order">
                    <button class="hider" @click="ready_to_order = false">Скрыть</button>
                    <input type="text" placeholder="Ваше имя" v-model="form.name" required>
                    <input type="text" placeholder="Номер телефона" v-model="form.phone"
                           pattern="[\+]\d{2} [\(]\d{3}[\)] \d{3}[\-]\d{2}[\-]\d{2}"
                           maxlength="19"
                           v-mask="['+38 (071) ###-##-##']"
                           required>
                    <input type="text" placeholder="Адрес доставки" v-model="form.address" required>
                    <textarea placeholder="Текстовое сообщение" v-model="form.message"></textarea>
                    <ul class="summary">
                        <li>
                            <p>Цена заказа: <span>{{goCartTotalPrice}} руб</span></p>
                        </li>
                        <li>
                            <p>Масса заказа: <span>{{goCartTotalWeight}} гр</span></p>
                        </li>
                    </ul>
                    <button class="btn btn-success w-100 p-3 text-uppercase font-weight-bold">Отправить заявку
                    </button>
                    <p class="end-info">После оформления заявки вам будет предложен для скачивания чек с подробным описанием заказа, его номером и
                        промокодом для лотереии</p>
                </form>
            </div>


        </div>
        <div class="cart-shadow" @click="closeCart()"></div>
    </div>
</template>

<script>
    import vueCustomScrollbar from 'vue-custom-scrollbar'
    import ObedyProduct from '../obedy/ObedyProduct'
    import "vue-custom-scrollbar/dist/vueScrollbar.css"
    import {mask} from "vue-the-mask";
    import ObedyControls from '../obedy/ObedyControls'

    export default {
        props:['ready_to_order'],
        data() {
            return {
                form: {
                    name: '',
                    address: '',
                    phone: '',
                    message: ''
                },
                settings: {
                    suppressScrollX: true,
                    suppressScrollY: false,
                },
            }
        },
        computed: {
            goCartTotalPrice() {
                return this.$store.getters.goCartTotalPrice;
            },
            goCartTotalWeight() {
                return this.$store.getters.goCartTotalWeight;
            },
            countInCart() {
                return this.$store.getters.goCartTotalCount;
            },
            itemsInCart() {
                return this.$store.getters.goCartProducts;
            }
        },
        directives: {mask},
        methods:
            {
                hasMainProductInCart() {
                    let tmp = this.itemsInCart.filter(item => item.product.addition === 0);

                    return tmp.length > 0
                },
                clearCart() {
                    this.$store.dispatch("clearGoCart");
                },
                closeCart() {
                    this.$emit("close")
                },
                sendOrder() {
                    this.$store.dispatch("sendGoOrder", this.form)
                    this.sendMessage("Ваш заказ успешно отправлен! Ожидайте звонка оператора!")

                    this.$emit("close")
                },
                sendMessage(message, type = 'success') {
                    this.$notify({
                        group: 'info',
                        type: type,
                        title: 'Оповещение ОбедыGO',
                        text: message
                    });
                }
                ,
            }
        ,
        components: {
            vueCustomScrollbar, ObedyProduct, ObedyControls
        }

    }
</script>

<style lang="scss">

    .end-info {
        font-style: italic;
        line-height: 100%;
        margin-top: 10px;
        color: #c31200;
        font-weight: 800;
        text-align: justify;
    }

    .summary {
        width: 100%;
        padding: 10px;
        border: 1px #e8e8e8 solid;
        margin: 5px 0px;
        border-radius: 5px;
        color: black;

        li {
            p {
                span {
                    font-weight: bold;
                }
            }
        }
    }

    .cart-shadow {
        position: absolute;
        z-index: 1001;
        top: inherit;
        left: inherit;
        width: inherit;
        height: inherit;
        background: rgba(0, 0, 0, 0.3);
    }

    .cart-modal {
        position: fixed;
        z-index: 100;
        right: 0;
        top: 0;
        height: 100vh;
        width: 100%;

        box-sizing: border-box;
        /* border-left: 5px #c31200 solid; */
        display: flex;
        justify-content: flex-end;

        .cart-modal-inner {
            width: 350px;
            height: 100vh;
            position: relative;
            background: white;
            transition: 0.3s;
            box-sizing: border-box;
            /* border-left: 5px #c31200 solid; */
            z-index: 10002;
            /* box-shadow: 0px 0px 3px 1px #3c3c3c; */
            border: 1px #e9e9e9 solid;
        }


        .custom-modal-header {
            width: 100%;
            height: 30px;
            display: flex;
            justify-content: flex-end;
            align-items: center;

            button {
                text-transform: uppercase;
                color: #af2112;
                font-weight: 800;
                font-size: 12px;

                &:focus {
                    outline: none;
                }

            }
        }

        .custom-modal-footer {
            width: inherit;
            height: auto;
            /* background: red; */
            position: fixed;
            bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            background: white;
            /* border-top: 5px #c31200 solid; */
            padding: 10px;
            box-sizing: border-box;
            /* box-shadow: 0px 0px 3px 1px #8b8b8b; */
            border: 1px #e9e9e9 solid;
            z-index: 2;

            form.order-form {
                padding: 10px 0px;
                box-sizing: border-box;
                width: 100%;
                transition: 0.3s;
                /* border-top: 2px red solid; */
                position: relative;
                display: flex;
                justify-content: center;
                align-items: center;
                flex-wrap: wrap;

                .hider {
                    position: absolute;
                    top: -25px;
                    width: 100px;
                    height: 30px;
                    /* right: 0; */
                    background: #c31200;
                    color: white;
                    font-weight: 800;
                    text-transform: uppercase;
                    font-size: 10px;
                    border-radius: 5px;
                    border: 1px #c31200 solid;
                    box-shadow: 0px 0px 3px 0px #464646;

                    &:hover {
                        background-color: #ad1200;
                        transition: .3s;
                    }

                    &:focus {
                        outline: none;
                    }
                }

                textarea,
                input {
                    width: 100%;
                    padding: 15px;
                    border: 1px #d50c0d solid;
                    margin-bottom: 5px;
                    border-radius: 5px;
                }
            }
        }

        .day-item-wrapper {
            padding: 20px;
            border-bottom: 1px #efefef solid;

            &:last-child {
                border-bottom: none;
            }

            .day-item {

                box-sizing: border-box;
                border-radius: 5px;
                position: relative;


                img {
                    border-radius: 5px;
                }

                h3 {
                    color: black;
                    font-size: 24px;
                    /* background: #c31200; */
                    /* color: white; */
                    padding: 10px;
                    /* width: 100%; */
                    text-transform: uppercase;
                    border-radius: 5px 5px 0px 0px;
                    font-family: 'Roboto', sans-serif;
                    text-align: center;

                    &:first-letter {
                        color: #c31200;
                    }
                }

                .shadow {
                    position: absolute;
                    width: 100%;
                    z-index: 10;
                    background: rgba(0, 0, 0, 0.5) url('/img/logo_obed_go.jpg') center center no-repeat;
                    background-size: cover;
                    height: 100%;
                    top: 0;
                    left: 0;
                    border-radius: inherit;

                    display: flex;
                    justify-content: center;
                    align-items: flex-end;

                    p {
                        font-size: 24px;
                        background: #c31200;
                        color: white;
                        padding: 10px;
                        /* width: 100%; */
                        text-transform: uppercase;
                        border-radius: 5px 5px 0px 0px;
                        font-family: fantasy;
                    }
                }

            }

            .addition-item {

                padding: 5px 10px 10px 10px;
                box-sizing: border-box;
                border-radius: 5px;
                position: relative;

                h4 {
                    font-size: 12px;
                    color: #c31200;
                    text-transform: uppercase;
                    font-family: monospace;
                    border-bottom: 1px black dashed;
                    display: inline-block;
                    padding: 0px 5px;
                }

                h3 {
                    border-bottom: 2px transparent solid;
                    padding: 10px;
                    text-transform: uppercase;
                    text-align: center;
                    font-weight: 800;
                    color: #0f0f0f;

                    &:first-letter {
                        color: #c31200;
                    }
                }
            }
        }
    }

    .tab-content {

        width: 100%;
        min-height: 500px;
        padding: 15px;


    }

    .ingredients {
        p {
            border-bottom: 2px transparent solid;
            padding: 10px;
            text-transform: uppercase;
            text-align: center;
            font-weight: 800;
            color: gray;
            cursor: pointer;

            &.active {
                border-bottom: 2px #c31200 solid;
                text-transform: uppercase;
                text-align: center;
                font-weight: 800;
                color: black;

                &:first-letter {
                    color: #c31200;
                }

            }

        }
    }


    [data-glide-el="controls"] {
        justify-content: space-between;
        display: flex;

        button {
            position: absolute;
            top: -21px;
            background: #678816;
            border: none;
            width: 40px;
            height: 40px;
            color: white;
            border-radius: 5px;
        }

        .prev {
            left: 0;
        }

        .next {
            right: 0;
        }
    }


    .additions {
        overflow-x: auto;
        position: relative;
        width: 100%;
        height: 100%;

    }

    .simple-item {
        width: 100%;
        /* max-width: 200px; */
        height: auto;
        min-width: 175px;
        /* max-height: 200px; */
        min-height: 175px;
        padding: 5px;

        img {
            height: 100%;
            width: 100%;
            object-fit: cover;

            border-radius: 5px;
            box-shadow: 1px 1px 2px 0px #000000;
        }
    }

    .custom-btn-color-success {
        background-color: #678816;
        box-shadow: 1px 1px 2px 0px #678816;
        border-color: #678816;
    }

    .custom-btn-color-danger {
        background: #c31200;
        box-shadow: 1px 1px 2px 0px #c31200;
        border-color: #c31200;

    }

</style>
