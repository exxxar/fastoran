<template>
    <div class="cart-main-area section-padding--lg bg--white">
        <div class="container">
            <div class="row" v-if="this.getMinOrderSum() > this.cartTotalPrice">
                <div class="col-md-12 col-sm-12 col-lg-12">
                    <div class="alert alert-danger" role="alert">
                        Ваша сумма заказа меньше миниальной ({{getMinOrderSum()}} руб.) в данном ресторане!!
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-lg-12">
                    <form action="#">
                        <div class="table-content table-responsive">
                            <table>
                                <thead>
                                <tr class="title-top">
                                    <th class="product-thumbnail">Изображение</th>
                                    <th class="product-name">Товар</th>
                                    <th class="product-price">Цена</th>
                                    <th class="product-quantity">Количество</th>
                                    <th class="product-subtotal">Всего</th>
                                    <th class="product-remove">Удалить</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-if="cartProducts.length>0" v-for="item in  cartProducts">
                                    <td class="product-thumbnail"><a href="#"><img :src="item.product.food_img"></a>
                                    </td>
                                    <td class="product-name"><a href="#">{{item.product.food_name}} <span
                                        v-if="item.product.selected_sub">(<em>{{item.product.selected_sub}}</em>)</span></a>
                                    </td>
                                    <td class="product-price"><span
                                        class="amount">{{item.product.food_price| currency}} </span></td>
                                    <td class="product-quantity">
                                        <p>Количество: {{item.quantity}}</p>
                                        <div class="buttons-group">
                                            <button type="button" class="btn btn-coutner" :disabled="item.quantity===1"
                                                    @click="decrement(item.product)">-
                                            </button>
                                            <button type="button" class="btn btn-coutner"
                                                    @click="increment(item.product)">+
                                            </button>
                                        </div>
                                    </td>
                                    <td class="product-subtotal">{{item.quantity*item.product.food_price| currency}}
                                    </td>
                                    <td class="product-remove"><a href="#">
                                        <button class="cartbox__item__remove" @click="remove(item.product.id)">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </a></td>
                                </tr>
                                <tr>
                                    <td><h4><span>Цена заказа</span></h4></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><h4><span>{{cartTotalPrice| currency}}</span></h4></td>
                                    <td><a href="#" class="food__btn" @click="clearCart" v-if="cartProducts.length>0">Очистить</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>

                </div>
            </div>
            <div class="row">

                <div class="col-lg-6 col-12 mb-30">

                    <!-- Checkout Accordion Start -->
                    <div id="checkout-accordion">


                        <div class="single-accordion">
                            <a class="accordion-head" data-toggle="collapse" data-parent="#checkout-accordion"
                               href="#checkout-method" aria-expanded="true">1. Ввод номера телефона</a>

                            <div id="checkout-method" class="collapse show" style="">
                                <div class="checkout-method accordion-body fix">
                                    <form action="#" class="billing-form checkout-form">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-12  mb-2"><input type="text"
                                                                                          placeholder="Ваш номер телефона"
                                                                                          name="phone"
                                                                                          v-model="phone"
                                                                                          required="required"
                                                                                          pattern="[\+]\d{2} [\(]\d{3}[\)] \d{3}[\-]\d{2}[\-]\d{2}"
                                                                                          class="form_control"
                                                                                          maxlength="19"
                                                                                          v-mask="['+38 (###) ###-##-##']">
                                            </div>

                                        </div>

                                    </form>

                                </div>
                            </div>

                        </div>

                        <div class="single-accordion">
                            <a class="accordion-head" data-toggle="collapse" data-parent="#checkout-accordion"
                               href="#more-products" aria-expanded="true">2. Добавить к заказу</a>

                            <div id="more-products" class="collapse show" style="">
                                <div class="more-product accordion-body fix">
                                    <form action="#">
                                        <h5>Вы можете добавить <strong>любой</strong> интересующий вас товар и наш
                                            курьер доставит его вместе с товаром из ресторана;)</h5>
                                        <br>
                                        <h5>При заказе укажите <strong>максимальную</strong> цену товара! Цена
                                            доставки увеличится <strong>на 50 руб.</strong>
                                        </h5>
                                        <br>
                                        <hr>
                                        <div class="row mb-2" v-for="(product, index) in custom_products">
                                            <div class="col-sm-7 mb-2">
                                                <input class="form-control" type="text" v-model="product.name"
                                                       minlength="5"
                                                       placeholder="Описание и кол-во товара" required></div>
                                            <div class="col-sm-4 mb-2">
                                                <input class="form-control" type="number" v-model="product.price"
                                                       min="10" max="1000"
                                                       placeholder="Цена, руб." required></div>
                                            <div class="col-sm-1 mb-2 "><a @click="removeCustomProduct(index)"
                                                                           class="btn-food-link"><i
                                                class="fas fa-trash"></i></a></div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-sm-12">
                                                <button type="button" @click="addCustomProduct" class="btn btn-success"
                                                        style="width:100%">
                                                    <span>Добавить</span></button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        </div>

                        <div class="single-accordion">
                            <a class="accordion-head" data-toggle="collapse" data-parent="#checkout-accordion"
                               href="#billing-method" aria-expanded="true">2. Доставка</a>
                            <div id="billing-method" class="collapse show" style="">

                                <div class="accordion-body billing-method fix">

                                    <form action="#" class="billing-form checkout-form">
                                        <div class="row">
                                            <div class="col-12 mb--20">
                                                <select v-model="delivery.city">
                                                    <option value="Донецк">Донецк</option>
                                                    <option value="Макеевка">Макеевка</option>
                                                </select>
                                            </div>
                                            <div class="col-12 mb--20">
                                                <input placeholder="Улица" type="text" v-model="delivery.street">
                                            </div>
                                            <div class="col-md-6  col-12 mb--20">
                                                <input placeholder="Номер дома" type="text"
                                                       v-model="delivery.home_number">
                                            </div>

                                            <div class="col-md-6  col-12 mb--20">
                                                <input placeholder="Номер квартиры" type="text"
                                                       v-model="delivery.flat_number">
                                            </div>

                                            <div class="col-md-6 col-12 mb--20">
                                                <input type="text" v-model="delivery.first_name" placeholder="Ваше имя">
                                            </div>


                                            <div class="col-md-6 col-12 mb--20">
                                                <select v-model="delivery.money_type">
                                                    <option value="0">Купюра для оплаты</option>
                                                    <option value="500">500 ₽</option>
                                                    <option value="1000">1000 ₽</option>
                                                    <option value="2000">2000 ₽</option>
                                                    <option value="5000">5000 ₽</option>
                                                </select>
                                            </div>

                                            <div class="col-12 mb--20">
                                                <textarea v-model="delivery.more_info"
                                                          placeholder="Дополнительная информация"></textarea>
                                            </div>

                                            <div class="col-12 mb--20">
                                                <button type="button" class="food__btn" @click="getRangePrice">
                                                    Рассчитать цену доставки
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div><!-- Checkout Accordion Start -->
                </div>

                <!-- Order Details -->
                <div class="col-lg-6 col-12 mb-30">

                    <div class="order-details-wrapper">
                        <h2>Ваш заказ</h2>
                        <div class="order-details">
                            <form action="#">
                                <ul>
                                    <li><p class="strong">Продукт</p>
                                        <p class="strong">Всего</p></li>


                                    <li v-for="item in  cartProducts"><p>{{item.product.food_name}}
                                        x{{item.quantity}} </p>
                                        <p>{{item.quantity*item.product.food_price| currency}}</p></li>

                                    <li><p class="strong">Цена основного заказа</p>
                                        <p class="strong">{{cartTotalPrice| currency}}</p></li>

                                    <li v-if="getCustomProductsSum()>0"><h4>Дополнительные товары</h4></li>
                                    <li v-for="item in  custom_products" v-if="item.name.length>0&&item.price>0"><p>
                                        {{item.name}}</p>
                                        <p>{{item.price| currency}}</p></li>
                                    <li v-if="getCustomProductsSum()>0"><p class="strong">Цена дополнительного
                                        заказа</p>
                                        <p class="strong">{{getCustomProductsSum()| currency}}</p></li>


                                    <li><p class="strong">Полная цена доставки</p>
                                        <p>
                                            {{deliveryPrice+custom_delivery_price|currency}}
                                        </p></li>
                                    <li><p class="strong">Всего</p>
                                        <p class="strong">
                                            {{cartTotalPrice+deliveryPrice+custom_delivery_price+getCustomProductsSum()
                                            | currency}}</p></li>
                                    <li>
                                        <button class="food__btn" @click="clearCart" v-if="cartProducts.length>0">
                                            Очистить корзину
                                        </button>
                                    </li>
                                    <li>
                                        <button class="food__btn" type="button"
                                                :disabled="canMakeOrder()===false"
                                                @click="sendRequest">Оформить
                                            заказ
                                        </button>
                                    </li>
                                </ul>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</template>
<script>
    import {mask} from 'vue-the-mask'

    export default {
        data() {
            return {
                preparedToSend: false,
                is_valid: false,
                phone: localStorage.getItem("phone", null) ?? null,
                name: '',
                message: '',
                address: '',
                custom_delivery_price: 0,
                delivery_range: null,
                deliveryPrice: 0,
                sending: false,
                sms_code: null,
                custom_products: [],
                delivery: {
                    city: "Донецк",
                    street: localStorage.getItem("food_street", ""),
                    first_name: localStorage.getItem("food_first_name", ""),
                    home_number: localStorage.getItem("food_home_number", ""),
                    flat_number: localStorage.getItem("food_flat_number", ""),
                    more_info: '',
                    money_type: '0',
                },
                coords: {
                    latitude: 0,
                    longitude: 0
                }

            }
        },

        watch: {

            phone: function (newVal, oldVal) {
                this.is_valid = newVal.length === 19
            }
        },
        mounted() {
            this.is_valid = this.phone.length === 19
            let callback = (val, oldVal, uri) => {
                this.$store.dispatch("getProductList")
            }

            Vue.ls.on('store', callback)

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
            getCustomProductsSum() {
                let sum = 0;

                this.custom_products.forEach(element => {
                    if (element.price != null)
                        sum += parseInt(element.price)
                });
                return sum;
            },
            getMinOrderSum() {
                return this.cartTotalCount === 0 ?
                     0 : this.cartProducts[0].product.restoran.min_sum;
            },
            canMakeOrder() {

                let acceptMinPrice = this.getMinOrderSum() <= this.cartTotalPrice;
                let acceptCoords = this.preparedToSend;
                let acceptPhoneNumber = this.is_valid;
                let acceptMinCount = this.cartTotalCount >0 ;

                console.log("test:", acceptMinPrice && acceptCoords && acceptPhoneNumber && acceptMinCount)
                return acceptMinPrice && acceptCoords && acceptPhoneNumber && acceptMinCount;
            },
            addCustomProduct() {
                this.custom_products.push({
                    name: "",
                    price: null
                })

                this.custom_delivery_price = 50;
            },
            removeCustomProduct(id) {

                this.custom_products = this.custom_products.filter((item, index) => index !== id)
                this.sendMessage("Товар удален")

                this.custom_delivery_price = this.getCustomProductsSum() === 0 ? 0 : 50;

            },
            getRangePrice() {
                if (this.cartTotalCount === 0) {
                    this.sendMessage("Сперва добавьте товар в корзину!")
                    return
                }
                let address = `г. ${this.delivery.city}, ${this.delivery.street}, ${this.delivery.home_number}`;
                axios
                    .post("../api/v1/range/" + this.cartProducts[0].product.rest_id, {
                        "address": address
                    }).then(resp => {

                    this.preparedToSend = true;
                    this.delivery_range = resp.data.range
                    this.deliveryPrice = resp.data.price
                    this.coords.latitude = resp.data.latitude
                    this.coords.longitude = resp.data.longitude

                    this.custom_delivery_price = this.getCustomProductsSum() === 0 ? 0 : 50;

                });
            },
            sendRequest(e) {
                // e.preventDefault();
                this.sending = true;

                localStorage.setItem("phone", this.phone);
                localStorage.setItem("food_city", this.delivery.city);
                localStorage.setItem("food_street", this.delivery.street);
                localStorage.setItem("food_first_name", this.delivery.first_name);
                localStorage.setItem("food_home_number", this.delivery.home_number == null ? '' : this.delivery.home_number);
                localStorage.setItem("food_flat_number", this.delivery.flat_number == null ? '' : this.delivery.flat_number);


                let products = [];
                this.cartProducts.forEach(function (item) {
                    products.push({
                        product_details: item.product,
                        count: item.quantity,
                        price: item.product.food_price,
                        more_info: item.product.selected_sub != null ? item.product.selected_sub : ''
                    })
                });
                axios
                    .post('../api/v1/fastoran/orders', {
                        phone: this.phone,
                        receiver_name: this.delivery.first_name,
                        receiver_phone: this.phone,
                        receiver_latitude: this.coords.latitude,
                        receiver_longitude: this.coords.longitude,
                        rest_id: this.cartProducts[0].product.rest_id,
                        status: 0,
                        receiver_delivery_time: '',
                        receiver_address: `г. ${this.delivery.city}, ${this.delivery.street}, ${this.delivery.home_number}`,
                        receiver_order_note: this.delivery.more_info + "\nКупюра:" + this.delivery.money_type + " руб.",
                        receiver_domophone: '',
                        order_details: products,
                        custom_details:this.custom_products


                    })
                    .then(response => {
                        this.clearCart()
                        this.sendMessage(response.data.message);

                        ym(61797661, 'reachGoal', 'zakaz');

                        this.deliveryPrice = 0;
                        this.delivery_range = null;
                        this.sending = false;

                        window.location.href = "/success";
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

            hasSub(product) {
                return product.food_sub != null;
            },
            increment(product) {
                this.sendMessage("Товар добавлен в корзину!")
                this.$store.dispatch('incQuantity', product.id)
            },
            decrement(product) {
                this.sendMessage("Лишний товар убран из корзины!")

                if (this.hasSub(product))
                    this.$store.dispatch('remSub', product.id)
                this.$store.dispatch('decQuantity', product.id)
            },
            remove(id) {
                this.$store.dispatch("removeProduct", id)
            },
            clearCart() {
                this.products = [{name: '', price: null}];

                this.deliveryPrice = 0;
                this.delivery_range = null;

                this.$store.dispatch("clearCart")

                window.location.href = "/";

            }
        },
        directives: {mask}
    }
</script>
<style lang="scss" scoped>

    .more-product {
        h5 {
            strong {
                color: #d50c0d;
                font-weight: 800;
            }
        }
    }

    .cartbox__item__content {
        h5 {
            a {
                display: block;
                text-align: center;
                width: 100%;
            }
        }
    }

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
        width: 100%;

        span {
            color: white;
        }

        &:disabled {
            background: gray;
            color: darkgray;
        }
    }

    .cartbox__buttons {
        padding-bottom: 200px;
    }

    .buttons-group {
        width: 100%;
        display: flex;
        justify-content: space-evenly;
    }

    .product-counter {
        display: flex;
        justify-content: space-evenly;
        padding: 5px;
        box-sizing: border-box;

        width: 100%;
        flex-wrap: wrap;
    }

    .price {
        width: 100%;
        text-align: center;
        display: block;
    }
</style>
