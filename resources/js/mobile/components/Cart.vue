<template>
    <div>

        <div class="card mt-3 mb-3">
            <div class="card-body">
                <h5 class="card-title">Корзина
                    <mobile-cart-counter></mobile-cart-counter>
                </h5>
                <p>Оформление заказа</p>
                <div class="alert alert-danger" v-if="this.getMinOrderSum() > this.cartTotalPrice" role="alert">
                    Ваша сумма заказа меньше миниальной ({{getMinOrderSum()}} руб.) в данном ресторане!!
                </div>

                <div class="table-responsive" v-if="cartProducts!=null">
                    <table class="table cart-table" v-if="cartProducts.length>0">
                        <thead>
                        <tr>
                            <th scope="col" class="product-thumbnail">#</th>
                            <th scope="col" class="product-name">Товар</th>
                            <th scope="col" class="product-price">Цена</th>
                            <th scope="col" class="product-quantity">Количество</th>
                            <th scope="col" class="product-subtotal">Всего</th>
                            <th scope="col" class="product-remove">Удалить</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="cartProducts.length>0" v-for="item in  cartProducts">
                            <td class="product-thumbnail"><img :src="item.product.food_img"
                                                               class="imageBlock large rounded">
                            </td>
                            <td class="product-name">{{item.product.food_name}}
                                <h6>{{item.product.restoran.name}}</h6>
                                <span
                                v-if="item.product.selected_sub">(<em>{{item.product.selected_sub}}</em>)</span>
                            </td>
                            <td class="product-price"><span
                                class="amount">{{item.product.food_price| currency}} </span></td>
                            <td class="product-quantity">
                                <p>Количество: {{item.quantity}}</p>
                                <div class="buttons-group">
                                    <button type="button" class="btn btn-outline-success mr-1 mb-1"
                                            :disabled="item.quantity===1"
                                            @click="decrement(item.product)">-
                                    </button>
                                    <button type="button" class="btn btn-outline-success mr-1 mb-1"
                                            @click="increment(item.product)">+
                                    </button>
                                </div>
                            </td>
                            <td class="product-subtotal">{{item.quantity*item.product.food_price| currency}}
                            </td>
                            <td class="product-remove"><a href="#">
                                <button class="btn btn-outline-success mr-1 mb-1" @click="remove(item.product.id)">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </a></td>
                        </tr>

                        </tbody>
                    </table>

                    <h6>Цена заказа</h6>
                    <p>
                        {{cartTotalPrice| currency}}
                    </p>
                    <button type="button" class="btn btn-outline-success mr-1 mb-1 w-100" @click="clearCart"
                            v-if="cartProducts.length>0">Очистить корзину
                    </button>
                </div>

                <div class="accordion" id="accordionExample">
                    <div class="card">
                        <div class="card-header" id="headingOne">
                            <h2 class="mb-0">
                                <button class="btn btn-link" type="button" data-toggle="collapse"
                                        data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Ваши контактные данные
                                    <i class="arrow icon ion-ios-arrow-down"></i>
                                </button>
                            </h2>
                        </div>

                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                             data-parent="#accordionExample">
                            <div class="card-body">
                                <form action="">
                                    <div class="form-group">
                                        <label>Укажие ваш номер телефона</label>
                                        <input type="text"
                                               placeholder="Ваш номер телефона"
                                               name="phone"
                                               v-model="phone"
                                               required="required"
                                               pattern="[\+]\d{2} [\(]\d{3}[\)] \d{3}[\-]\d{2}[\-]\d{2}"
                                               class="form-control"
                                               maxlength="19"
                                               v-mask="['+38 (###) ###-##-##']">
                                    </div>
                                    <div class="form-group">
                                        <label>Укажие ваше имя</label>
                                        <input type="text" class="form-control"
                                               v-model="delivery.first_name" placeholder="Ваше имя"
                                               required>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingTwo">
                            <h2 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                        data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Доставка
                                    <i class="arrow icon ion-ios-arrow-down"></i>
                                </button>
                            </h2>
                        </div>
                        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                             data-parent="#accordionExample">
                            <div class="card-body">
                                <div class="contentList">
                                    <div>Самовывоз</div>
                                    <div>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch11"
                                                   v-model="take_by_self" checked="">
                                            <label class="custom-control-label" for="customSwitch11"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="take_by_self" v-if="take_by_self">
                                    <div class="map-section" v-if="getRestCoords!=null">
                                        <h6 class="mt-2">Забрать заказ можно по адресу:
                                            {{getRestCoords().address}}</h6>

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
                                <form v-if="!take_by_self" @submit="getRangePrice">
                                    <div class="form-group">
                                        <select v-model="delivery.city" class="form-control" required>
                                            <option value="Донецк">Донецк</option>
                                            <option value="Макеевка">Макеевка</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Выбери дату и время доставки (<a
                                            v-if="delivery.receiver_delivery_time.length>0"
                                            @click="resetSelectedDatetime">сбросить время доставки</a><span
                                            v-else>не обязательно</span>)</label>
                                        <datetime v-model="delivery.receiver_delivery_time"
                                                  :min-datetime="getCurrentDatetimeRange().min"
                                                  :max-datetime="getCurrentDatetimeRange().max"
                                                  type="datetime" :input-class="'form-control'"
                                                  :title="'Время отложенной доставки'"

                                        ></datetime>
                                    </div>

                                    <div class="form-group">
                                        <input class="form-control" placeholder="Улица" type="text"
                                               v-model="delivery.street"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <input class="form-control" placeholder="Номер дома" type="text" required
                                               v-model="delivery.home_number">
                                    </div>

                                    <div class="form-group">
                                        <input class="form-control" placeholder="Номер квартиры" type="text"
                                               v-model="delivery.flat_number">
                                    </div>

                                    <div class="form-group">
                                        <select class="form-control" v-model="delivery.money_type">
                                            <option value="0">Купюра для оплаты</option>
                                            <option value="500">500 ₽</option>
                                            <option value="1000">1000 ₽</option>
                                            <option value="2000">2000 ₽</option>
                                            <option value="5000">5000 ₽</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                                <textarea class="form-control" v-model="delivery.more_info"
                                                          placeholder="Дополнительная информация"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <p>{{delivery_range_message}}</p>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-outline-success mr-1 mb-1 w-100">
                                            Рассчитать цену доставки
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="headingThree">
                            <h2 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                        data-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                    Хочу добавить к заказу
                                    <i class="arrow icon ion-ios-arrow-down"></i>
                                </button>
                            </h2>
                        </div>
                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                             data-parent="#accordionExample">
                            <div class="card-body">
                                <form action="#">
                                    <h6>Вы можете добавить <strong>любой</strong> интересующий вас товар и наш
                                        курьер доставит его вместе с товаром из ресторана;)</h6>
                                    <br>
                                    <h6>При заказе укажите <strong>максимальную</strong> цену товара! Цена
                                        доставки увеличится <strong>на 50 руб.</strong>
                                    </h6>
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
                                            <button type="button" @click="addCustomProduct"
                                                    class="btn btn-outline-success mr-1 mb-1 w-100"
                                                    style="width:100%">
                                                Добавить еще
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" id="headingFour">
                            <h2 class="mb-0">
                                <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                        data-target="#collapseFour" aria-expanded="false"
                                        aria-controls="collapseFour">
                                    У меня есть промокод
                                    <i class="arrow icon ion-ios-arrow-down"></i>
                                </button>
                            </h2>
                        </div>
                        <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                             data-parent="#accordionExample">
                            <div class="card-body">
                                <form v-on:submit.prevent="requestPromocode">

                                    <div class="form-group">
                                        <input type="text"
                                               placeholder="Ваш промокод"
                                               name="phone"
                                               v-model="code"
                                               class="form-control" required>
                                    </div>

                                    <div class="form-group">
                                        <p>{{promocode_message}}</p>
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-outline-success mr-1 mb-1 w-100" type="submit">
                                            Получить скидку
                                        </button>
                                    </div>


                                </form>

                            </div>
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
                }).catch(error => {
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
                        receiver_address: `г. ${this.delivery.city}, ${this.delivery.street}, ${this.delivery.home_number}`,
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
<style lang="scss">
    .cart-table {
        thead {
            th {
                min-width: 200px;
            }

            th.product-price {
                min-width: 60px !important;
                width: 60px;
            }
            th.product-thumbnail {
                min-width: 60px !important;
                width: 60px;
            }
        }


    }

    .map-section {
        min-height: 350px;
        height: 400px;

    }
</style>
