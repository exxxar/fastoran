<template>
    <div class="cartbox__inner text-left">
        <div class="cartbox__items">
            <!-- Cartbox Single Item -->
            <div class="cartbox__item" v-if="cartProducts.length>0" v-for="item in  cartProducts">
                <div class="cartbox__item__thumb">
                    <a href="product-details.html">
                        <img :src="item.product.food_img"
                             alt="small thumbnail">
                    </a>
                </div>
                <div class="cartbox__item__content">
                    <h5><a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/product-details.html"
                           class="product-name">{{item.product.food_name}}</a></h5>
                    <p><span class="product-counter">

                       Количество:  {{item.quantity}}
                        <button type="button" class="btn btn-coutner" :disabled="item.quantity===1"
                                @click="decrement(item.product.id)">-</button>
                        <button type="button" class="btn btn-coutner"
                                @click="increment(item.product.id)">+</button></span></p>
                    <span class="price">{{item.product.food_price| currency}} / {{item.product.food_price*item.quantity | currency }}</span>

                </div>
                <button class="cartbox__item__remove" @click="remove(item.product.id)">
                    <i class="fa fa-trash"></i>
                </button>
            </div>

            <h4 v-if="cartProducts.length==0">Вы еще не выбрали никакой товар!</h4>
        </div>
        <div class="cartbox__inputs" v-if="cartProducts.length>0">

            <input type="text" v-model="address" @blur="getRangePrice" placeholder="Введите ваш адрес">

            <input type="text" v-model="name" @blur="getRangePrice" placeholder="Введите ваше имя">
            <p v-if="message.length>0">{{message}}<br><a href="#" @click="resendSms">Вы можете повторно получить код в СМС</a></p>
            <input type="text" placeholder="Ваш номер телефона" name="phone" @blur="sendSms"
                   v-model="phone"
                   required="required" pattern="[\+]\d{2} [\(]\d{3}[\)] \d{3}[\-]\d{2}[\-]\d{2}" class="form_control"
                   maxlength="19"
                   v-mask="['+38 (###) ###-##-##']">

            <input type="number" v-model="sms_code" @blur="checkValidCode" placeholder="Введите код из СМС">
        </div>
        <div class="cartbox__total" v-if="cartProducts.length>0">
            <ul>
                <li><span class="cartbox__total__title">Цена заказа</span><span class="price">{{cartTotalPrice| currency}}</span>
                </li>
                <li class="shipping-charge" v-if="delivery_range!=null"><span class="cartbox__total__title">Цена доставки</span><span
                    class="price">{{deliveryPrice|currency}}</span></li>
                <li class="grandtotal">Сумма заказа<span
                    class="price">{{cartTotalPrice+deliveryPrice | currency}}</span></li>
            </ul>
        </div>

        <div class="cartbox__buttons" v-if="cartProducts.length>0">
            <a class="food__btn" v-if="is_valid" @click="sendRequest"><span>Оформить заказ</span></a>
            <a class="food__btn" @click="clearCart" v-if="cartProducts.length>0"><span>Очистить корзину</span></a>
        </div>
    </div>
</template>
<script>
    import {mask} from 'vue-the-mask'

    export default {
        data() {
            return {
                is_valid: false,
                phone: null,
                name: '',
                message: '',
                address: '',
                delivery_range: null,
                deliveryPrice: 0,
                sending: false,
                sms_code: null,
                coords: {
                    latitude: 0,
                    longitude: 0
                }

            }
        },

        mounted() {
            let callback = (val, oldVal, uri) => {
                this.$store.dispatch("getProductList")
            }

            Vue.ls.on('store', callback) //watch change foo key and triggered callbac

            this.$store.dispatch("getProductList")


        },
        activated() {

            this.$store.dispatch("getProductList")
        },
        computed: {
            cartProducts: function () {
                return this.$store.getters.cartProducts;
            },
            cartTotalCount: function () {
                return this.$store.getters.cartTotalCount;
            },
            cartTotalPrice: function () {
                return this.$store.getters.cartTotalPrice;
            }
        },
        methods: {
            resendSms(){
                this.message = "На ваш номер повторно отправлен смс с кодом!";
                axios
                    .post("../api/v1/fastoran/order/resend", {
                        "phone": this.phone,
                    }).then(resp=>{
                    this.message = resp.data.message;
                })
            },
            canSendOrder() {
                return this.delivery_range != null && this.cartProducts.length > 0 && this.phone.length > 10
            },
            sendSms() {
                this.message = "На ваш номер отправлен смс с кодом!";
                axios
                    .post("../api/v1/fastoran/order/sms", {
                        "phone": this.phone,
                        "name": this.name
                    }).then(resp=>{
                        this.message = resp.data.message;
                })
            },
            checkValidCode() {
                axios
                    .post("../api/v1/fastoran/check_valid_code", {
                        "phone": this.phone,
                        "code": this.sms_code
                    }).then(resp => {
                    this.is_valid = resp.data.is_valid
                    this.message = resp.data.message;
                });
            },
            getRangePrice() {
                axios
                    .post("../api/v1/range/" + this.cartProducts[0].product.rest_id, {
                        "address": this.address
                    }).then(resp => {

                    this.delivery_range = resp.data.range
                    this.deliveryPrice = resp.data.price
                    this.coords.latitude = resp.data.latitude
                    this.coords.longitude = resp.data.longitude

                });
            },
            sendRequest(e) {
               // e.preventDefault();
                this.sending = true;
                let products = [];
                this.cartProducts.forEach(function (item) {
                    products.push({
                        product_id: item.product.id,
                        count: item.quantity,
                        price: item.product.food_price
                    })
                });
                axios
                    .post('../api/v1/fastoran/orders', {
                        phone: this.phone,
                        receiver_name: this.name,
                        receiver_phone: this.phone,
                        receiver_latitude: this.coords.latitude,
                        receiver_longitude: this.coords.longitude,
                        rest_id: this.cartProducts[0].product.rest_id,
                        status: 0,
                        receiver_delivery_time: '',
                        receiver_address: this.address,
                        receiver_order_note: '',
                        receiver_domophone: '',
                        order_details: products
                    })
                    .then(response => {
                        this.sendMessage(response.data.message);
                        this.message = '';
                        this.sms_code = '';
                        this.is_valid = false;
                        this.clearCart()

                        this.sending = false;
                    });
            },
            sendMessage(message) {
                this.$notify({
                    group: 'info',
                    type: 'success',
                    title: 'Отправка заказа Fastoran',
                    text: message
                });
            },
            increment(id) {
                this.$store.dispatch("incQuantity", id)
            },
            decrement(id) {
                this.$store.dispatch("decQuantity", id)
            },
            remove(id) {
                this.$store.dispatch("removeProduct", id)
            },
            clearCart() {
                this.$store.dispatch("clearCart")
            }
        },
        directives: {mask}
    }
</script>
<style lang="scss" scoped>
    .cartbox__inputs {
        padding: 10px;
        width: 100%;
        margin-top: 5px;

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px lightblue solid;
        }
    }

    .food__btn {
        span {
            color: white;
        }
    }

    .cartbox__buttons {
        padding-bottom: 200px;
    }
</style>
