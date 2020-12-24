<template>
    <div>
 <!--       <div class="additions-days" v-if="product.addition&&inCart()>0">
            <div class="row d-flex justify-content-around align-items-center">

                <label class="check-container" v-for="(day, index) in addional_day">{{day}}
                    <input type="checkbox" v-model="selected_additional_days" :value="index" :name="'check'+index+uuid"
                           @change="selectDay(index)">
                    <span class="checkmark"></span>
                </label>


            </div>
        </div>-->

        <div class="cnt-container" v-if="inCart()>0" @mouseenter="show_addition_btn=true" @mouseleave="show_addition_btn=false" >
            <div class="group-btn-counter">
                <button class="btn btn-coutner " @click="remProduct()" v-b-popover.hover.bottom="'Убрать весь продукт из корзины'">
                    <span><i class="fas fa-trash"></i></span>
                </button>
                <button class="btn btn-coutner " @click="decProduct()" v-b-popover.hover.bottom="'Убрать порцию из корзины'">
                    -
                </button>
            </div>
            <p v-html="inCart()" class="text-white"></p>
            <button class="btn btn-coutner " @click="incProduct()"  v-b-popover.hover.bottom="'Добавить еще порцию в корзину'">
                <span>+</span>


            </button>
            <div class="btn btn-success sub-btn" @click="openCart()" v-if="show_addition_btn">Оформить</div>

        </div>

        <button class="btn btn-danger w-100 text-uppercase mt-2 p-3" @click="addToCart()"
                :disabled="!hasMainProductInCart()"
                v-if="!(current_day_index<product.day_index)&&inCart()===0">В КОРЗИНУ
            <span>{{orderDay(product.day_index)}}</span>
        </button>
        <button class="btn btn-success w-100 text-uppercase mt-2 p-3 custom-btn-color-success"
                v-b-popover.hover.bottom="'Добавить товар в корзину'"
                @click="addToCart()"
                :disabled="!hasMainProductInCart()"
                v-if="(current_day_index<product.day_index)&&inCart()===0">
            В КОРЗИНУ
        </button>
    </div>

</template>
<script>
    import {v4 as uuidv4} from "uuid";
    import { EventBus } from '../../app.js';

    export default {
        props: ["product"],
        data() {
            return {
                show_addition_btn:false,
                uuid: null,
                current_day_index: 1,
                addional_day: ["Пн", "Вт", "Ср", "Чт", "Пт"],
                selected_additional_days: []
            }
        },
        watch: {
            cart: function (newVal, oldVal) {
                return newVal
            },

        },
        computed: {
            cart() {
                return this.$store.getters.goCartProducts;
            },
            goProduct() {
                return this.$store.getters.getGoProductById(this.product.id)
            }
        },
        mounted() {
            let today = new Date();

            this.uuid = uuidv4();

            this.current_day_index = today.getDay()

            let callback = (val, oldVal, uri) => {
                this.$store.dispatch("goCartProducts")
            }

            Vue.ls.on('store_go', callback) //watch change foo key and triggered callbac
        },
        methods: {
            openCart(){
                EventBus.$emit('open-cart');
            },
            selectDay(index) {

                this.$store.dispatch("setGoDaysForItem", {
                    id: this.product.id,
                    days: this.selected_additional_days
                })
            },
            orderDay(dayIndex) {
                var dt = new Date();

                dt.setDate(dt.getDate() + 7 - dt.getDay() + dayIndex);

                return dt.getDate() + "." + (dt.getMonth() + 1) + "." + dt.getFullYear();
            },
            incProduct() {

                this.sendMessage("Товар добавлен в корзину!")
                this.$store.dispatch('incGoQuantity', this.product.id)
            },
            remProduct() {
                this.sendMessage("Лишний товар убран из корзины!")
                this.$store.dispatch('removeGoProduct', this.product.id)
            },

            decProduct() {
                this.sendMessage("Лишний товар убран из корзины!")


                if (this.inCart(this.product) === 1) {
                    this.$store.dispatch('removeGoProduct', this.product.id)
                    return;
                }

                this.$store.dispatch('decGoQuantity', this.product.id)
            },
            hasMainProductInCart() {
                let tmp = this.cart.filter(item => item.product.addition === 0);
                return tmp.length > 0 || this.product.addition == false
            },
            inCart() {
                let tmp = this.cart.filter(item => item.product.id === this.product.id);

                if (tmp[0])
                    this.selected_additional_days = tmp[0].days

                return tmp.length === 0 ? 0 : tmp[0].quantity


            },

            addToCart() {
                if (!this.hasMainProductInCart()) {
                    this.sendMessage("Сперва выберите основной продукт!", "warn")
                    return;
                }
                this.sendMessage("Товар добавлен в корзину!")
                this.$store.dispatch('addGoProductToCart', this.product)
            },
            sendMessage(message, type = 'success') {
                this.$notify({
                    group: 'info',
                    type: type,
                    title: 'Оповещение ОбедыGO',
                    text: message
                });
            },
        }
    }
</script>

<style lang="scss">

    .cnt-container {
        position: relative;

        .sub-btn {
            position: absolute;
            padding: 10px;
            border-radius: 5px;
            top: -30px;
            right: -14px;
            /* opacity: 0.5; */
            box-shadow: 1px 1px 2px 0px #000000;
            transition: 0.3s;
            cursor: pointer;
            text-transform: uppercase;
            color: white;
            font-weight: 800;
            font-size: 10px;

            &:hover {
                color:white;
            }

        }

    }
    .additions-days {
        position: absolute;
        top: 51px;
        right: 8px;
        width: 160px;
        padding: 10px;
        display: block;
        color: black;

        .check-container {
            display: block;
            position: relative;
            /* padding-left: 35px; */
            margin-bottom: 0px;
            cursor: pointer;
            font-size: 12px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            text-transform: uppercase;
            padding-top: 25px;
            padding-left: 3px;
            width: 30px;

        }

        /* Hide the browser's default checkbox */
        .check-container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        /* Create a custom checkbox */
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            border-radius: 5px;
            background-color: #eee;
            box-shadow: 1px 1px 2px 0px #000000;
        }

        /* On mouse-over, add a grey background color */
        .check-container:hover input ~ .checkmark {
            background-color: #ccc;
        }

        /* When the checkbox is checked, add a blue background */
        .check-container input:checked ~ .checkmark {
            background-color: #c31200;

        }

        /* Create the checkmark/indicator (hidden when not checked) */
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the checkmark when checked */
        .check-container input:checked ~ .checkmark:after {
            display: block;
        }

        /* Style the checkmark/indicator */
        .check-container .checkmark:after {
            left: 9px;
            top: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }
    }


</style>
