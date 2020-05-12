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
                    <form v-if="cartProducts!=null">
                        <div class="table-content table-responsive" v-if="cartProducts.length>0">
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
                               href="#billing-method" aria-expanded="true">2. Доставка

                            </a>
                            <div id="billing-method" class="collapse show" style="">

                                <div class="accordion-body billing-method fix">

                                    <div>
                                        <b-form-checkbox
                                            id="checkbox-delivery-1"
                                            v-model="take_by_self"
                                            name="checkbox-delivery-1"
                                            :unchecked-value="false"
                                        >
                                            Самовывоз
                                        </b-form-checkbox>
                                    </div>
                                    <div class="take_by_self" v-if="take_by_self">
                                        <div class="map-section" v-if="getRestCoords!=null">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label>Укажие ваше имя</label>
                                                    <input type="text" class="form-control"
                                                           v-model="delivery.first_name" placeholder="Ваше имя"
                                                           required>

                                                </div>

                                            </div>
                                            <h3 class="mt-2">Забрать заказ можно по адресу:
                                                {{getRestCoords().address}}</h3>

                                            <yandex-map
                                                :coords="getRestCoords().coords"
                                                zoom=15
                                            >
                                                <ymap-marker
                                                    :coords="getRestCoords().coords"
                                                    :icon="marker"
                                                    marker-id="123123"
                                                    hint-content="Место где вы сможете забрать заказ"
                                                />
                                            </yandex-map>
                                        </div>
                                    </div>
                                    <form v-if="!take_by_self" @submit="getRangePrice"
                                          class="billing-form checkout-form">
                                        <div class="row">
                                            <div class="col-12 mb--20">
                                                <select v-model="delivery.city" required>
                                                    <option value="Донецк">Донецк</option>
                                                    <option value="Макеевка">Макеевка</option>
                                                </select>
                                            </div>
                                            <div class="col-12 mb--20">
                                                <label>Выбери дату и время доставки (<a
                                                    v-if="delivery.receiver_delivery_time.length>0"
                                                    @click="resetSelectedDatetime">сбросить время доставки</a><span
                                                    v-else>не обязательно</span>)</label>
                                                <datetime v-model="delivery.receiver_delivery_time"
                                                          :min-datetime="getCurrentDatetimeRange().min"
                                                          :max-datetime="getCurrentDatetimeRange().max"
                                                          type="datetime"

                                                ></datetime>
                                            </div>

                                            <div class="col-12 mb--20">
                                                <input placeholder="Улица" type="text" v-model="delivery.street"
                                                       required>
                                            </div>
                                            <div class="col-md-6  col-12 mb--20">
                                                <input placeholder="Номер дома" type="text" required
                                                       v-model="delivery.home_number">
                                            </div>

                                            <div class="col-md-6  col-12 mb--20">
                                                <input placeholder="Номер квартиры" type="text"
                                                       v-model="delivery.flat_number">
                                            </div>

                                            <div class="col-md-6 col-12 mb--20">
                                                <input type="text" v-model="delivery.first_name" placeholder="Ваше имя"
                                                       required>
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
                                                <p>{{delivery_range_message}}</p>
                                            </div>
                                            <div class="col-12 mb--20">
                                                <button type="submit" class="food__btn">
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

                    <div class="single-accordion">
                        <a class="accordion-head" data-toggle="collapse" data-parent="#checkout-accordion"
                           href="#more-products" aria-expanded="true">3. Добавить к заказу</a>

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
                           href="#promocode" aria-expanded="true">4. Акционный прмокод</a>

                        <div id="promocode" class="collapse show" style="">
                            <div class="promocode accordion-body fix">
                                <form v-on:submit.prevent="requestPromocode" class="billing-form checkout-form">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12  mb-2"><input type="text"
                                                                                      placeholder="Ваш промокод"
                                                                                      name="phone"
                                                                                      v-model="code"
                                                                                      class="form_control" required>
                                        </div>

                                        <div class="col-sm-12 col-md-12  mb-2">
                                            <p>{{promocode_message}}</p>
                                        </div>

                                        <div class="col-sm-12 col-md-12  mb-2">
                                            <button class="food__btn" type="submit">Получить скидку</button>
                                        </div>

                                    </div>

                                </form>

                            </div>
                        </div>

                    </div>

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
                                    <li v-for="item in  custom_products" v-if="item.name!=null"><p>
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
                                    <li v-if="this.message.length>0" class="status-order">
                                        {{this.message}}
                                    </li>
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
    import {yandexMap, ymapMarker} from 'vue-yandex-maps'

    export default {
        data() {
            return {
                preparedToSend: false,
                is_valid: false,
                phone: localStorage.getItem("phone", null) ?? null,
                name: '',
                message: '',
                delivery_range_message: '',
                promocode_message: '',
                is_valid_promocode: false,
                code: null,
                custom_delivery_price: 0,
                delivery_range: null,
                deliveryPrice: 0,
                sending: false,
                take_by_self: false,
                custom_products: [],
                marker: {
                    layout: 'default#imageWithContent',
                    imageHref: '../img/icons/deliveryman.png',
                    imageSize: [43, 43],
                    imageOffset: [0, -25],
                    contentOffset: [0, 15],
                },
                delivery: {
                    city: "Донецк",
                    street: localStorage.getItem("food_street") == null ? '' : localStorage.getItem("food_street"),
                    first_name: localStorage.getItem("food_first_name") == null ? '' : localStorage.getItem("food_first_name"),
                    home_number: localStorage.getItem("food_home_number") == null ? '' : localStorage.getItem("food_home_number"),
                    flat_number: localStorage.getItem("food_flat_number") == null ? '' : localStorage.getItem("food_flat_number"),
                    more_info: '',
                    money_type: '0',
                    receiver_delivery_time: '',
                },
                coords: {
                    latitude: 0,
                    longitude: 0
                }

            }
        },

        watch: {
            take_by_self: function (newVal, oldVal) {
                this.preparedToSend = newVal;
                this.delivery.receiver_delivery_time = '';
                this.delivery.delivery_range = 0;
            },
            phone: function (newVal, oldVal) {
                this.is_valid = this.phone == null ? false : newVal.length === 19
            }
        },
        mounted() {
            this.is_valid = this.phone == null ? false : this.phone.length === 19
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
            resetSelectedDatetime() {
                this.delivery.receiver_delivery_time = '';
            },
            getCurrentDatetimeRange() {

                var max_date = new Date();
                var min_date = new Date();


                min_date.setDate(min_date.getDate());
                max_date.setDate(max_date.getDate() + 1);

                min_date.setHours(11, 0);
                max_date.setHours(20, 45);

                return {
                    min: min_date.toISOString(),
                    max: max_date.toISOString(),

                }
            },
            getCustomProductsSum() {
                let sum = 0;

                this.custom_products.forEach(element => {
                    if (element.price != null && element.name.trim().length > 0)
                        sum += parseInt(element.price)
                });
                return sum;
            },
            getRestCoords() {
                return {
                    coords: [
                        this.cartTotalCount !== 0 ? this.cartProducts[0].product.restoran.latitude : 0,
                        this.cartTotalCount !== 0 ? this.cartProducts[0].product.restoran.longitude : 0
                    ],
                    address: this.cartTotalCount !== 0 ? this.cartProducts[0].product.restoran.adress : 'Не указано'
                }
            },
            getMinOrderSum() {
                return this.cartTotalCount === 0 ?
                    0 : this.cartProducts[0].product.restoran.min_sum;
            },
            requestPromocode() {

                if (this.cartTotalCount === 0) {
                    this.sendMessage("Сперва добавьте товар в корзину!")
                    this.promocode_message = "Необходимо добавить товар в корзину для начала!";
                    return
                }

                this.promocode_message = "Проверяем наличие акционных товаров в корзине..."
                let promo_product = (this.cartProducts.filter(item => {
                    return item.product.food_status === 1

                }));


                if (promo_product.length === 0) {
                    this.promocode_message = "В корзине нет акционных товаров";
                    return;
                }

                this.promocode_message = "Запрашиваем скидку на товар";
                let product_id = promo_product[0].product.id;

                axios
                    .post('../api/v1/fastoran/order/price_by_code', {
                        code: this.code,
                        product_id: product_id
                    }).then(resp => {
                    this.promocode_message = `Цена акционного товара ${resp.data.price} руб.`;
                    this.is_valid_promocode = true;
                }).catch(error=>{
                    console.log(error)
                    this.promocode_message = "Ошибочный код!"
                })
            },
            canMakeOrder() {

                let acceptMinPrice = (this.getMinOrderSum() <= this.cartTotalPrice) || this.is_valid_promocode;
                let acceptCoords = this.preparedToSend;
                let acceptPhoneNumber = this.is_valid;
                let acceptMinCount = this.cartTotalCount > 0;
                let sending = this.sending

                //console.log(`${acceptMinPrice} ${acceptCoords} ${acceptPhoneNumber} ${acceptMinCount} ${sending} `)

                return acceptMinPrice && acceptCoords && acceptPhoneNumber && acceptMinCount && !sending;
            },
            addCustomProduct() {
                this.custom_products = this.custom_products.filter(item => item.name.trim().length > 0 && item.price > 0)
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
            getRangePrice(e) {
                e.preventDefault();

                if (this.cartTotalCount === 0) {
                    this.sendMessage("Сперва добавьте товар в корзину!")
                    return
                }

                if (this.getCustomProductsSum() === 0) {
                    this.custom_products = [];
                    this.custom_delivery_price = 0;
                }

                this.delivery_range_message = "Расчитываем цену доставки...";

                let address = `Украина, г. ${this.delivery.city}, ${this.delivery.street}, ${this.delivery.home_number}`;
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

                    this.delivery_range_message = `Цена доставки составляет ${resp.data.price + this.custom_delivery_price} руб. `;


                });
            },
            sendRequest(e) {
                // e.preventDefault();
                this.sending = true;

                localStorage.setItem("phone", this.phone == null ? '' : this.phone);
                localStorage.setItem("food_city", this.delivery.city == null ? '' : this.delivery.city);
                localStorage.setItem("food_street", this.delivery.street == null ? '' : this.delivery.street);
                localStorage.setItem("food_first_name", this.delivery.first_name == null ? '' : this.delivery.first_name);
                localStorage.setItem("food_home_number", this.delivery.home_number == null ? '' : this.delivery.home_number);
                localStorage.setItem("food_flat_number", this.delivery.flat_number == null ? '' : this.delivery.flat_number);

                if (this.getCustomProductsSum() === 0) {
                    this.custom_products = [];
                    this.custom_delivery_price = 0;
                }

                let receiver_delivery_time = '';
                if (this.delivery.receiver_delivery_time !== '') {
                    let tmp_time = new Date(this.delivery.receiver_delivery_time);
                    receiver_delivery_time = tmp_time.toLocaleDateString('ru-RU') + " " + tmp_time.toLocaleTimeString('ru-RU')
                }

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
                        receiver_delivery_time: receiver_delivery_time,
                        receiver_address: `г. ${this.delivery.city}, ${this.delivery.street}, ${this.delivery.home_number}, ${this.delivery.flat_number}`,
                        receiver_order_note: this.delivery.more_info + "\nКупюра:" + this.delivery.money_type + " руб.",
                        receiver_domophone: '',
                        take_by_self: this.take_by_self,
                        order_details: products,
                        custom_details: this.custom_products


                    })
                    .then(response => {
                        this.clearCart()
                        this.sendMessage("Ваш заказ успешно отправлен! Номер заказа #" + response.data.order_id);

                        ym(61797661, 'reachGoal', 'zakaz');

                        this.deliveryPrice = 0;
                        this.delivery_range = null;
                        this.sending = false;

                        localStorage.setItem("last_order_id", response.data.order_id)
                        localStorage.setItem("status_counter", null)

                        this.message = "Ваш заказ успешно отправлен! Номер заказа #" + response.data.order_id
                        //window.location.href = "/success";
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
                this.custom_products = [];

                this.deliveryPrice = 0;
                this.delivery_range = null;

                this.$store.dispatch("clearCart")


            }
        },
        directives: {mask},
        components: {yandexMap, ymapMarker}
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

    .status-order {
        background: red;
        color: white;
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
