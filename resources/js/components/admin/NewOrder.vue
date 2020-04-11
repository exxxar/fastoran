<template>
    <div>
        <notifications group="message"/>
        <b-container fluid>
            <div class="row">
                <div class="single-accordion" style="width: 100%; ">
                    <a class="accordion-head" href="#" aria-expanded="true" style="background-color: #3490dc;">1. Выберите заведение</a>
                    <div id="restoran" class="" style="">
                        <div class="accordion-body restoran fix text-center">
                            <b-form-select v-model="rest_id" :options="restorans" :disabled="menu_loading" style="width: 40%;" @change="changeRestoran"></b-form-select>
                        </div>
                    </div>
                </div>
            </div>
<!--            <b-form-select v-model="status" :options="statuses"></b-form-select>-->
            <div class="single-accordion" style="width: 100%;">
                <a class="accordion-head" href="#" aria-expanded="true" style="background-color: #3490dc;">2. Выберите продукты</a>
                <div class="accordion-body fix text-center">
                    <div v-if="menu_loading" class="d-flex justify-content-center mt-3 mb-3">
                        <b-spinner style="width: 3rem; height: 3rem;" label="Large Spinner"></b-spinner>
                        <h2 style="height: 3rem;" class="mt-auto mb-auto ml-3">
                            Загрузка...
                        </h2>
                    </div>
                    <h3 class="text-center m-auto" v-if="rest_id =='' || rest_id == null"> Сначала выберите заведение</h3>
                    <div v-if="!menu_loading && rest_id !='' && rest_id != null">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="search-wrapper">
                                    <b-form-input type="text" class="mb-4 mt-4" v-model="search" placeholder="Поиск"></b-form-input>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="row mb-4 mt-4">
                                    <h4><span>Цена заказа: {{cartTotalPrice| currency}}</span></h4>
                                    <a href="#" class="btn btn-primary ml-3" @click="clearCart" v-if="cartProducts.length>0">Очистить</a>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <b-list-group style="min-height: 600px;max-height: 600px; overflow-y: scroll;">
                                    <b-list-group-item class="flex-column align-items-start" v-for="item in filteredList" v-bind:key="item.id">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h5 class="mb-1">{{item.food_name}}</h5>
                                        </div>
<div class="row">
    <div class="col-4">
        <img :src="item.food_img" style="height: 80px; width: 80px">
    </div>
    <div class="col-8"> <p class="mb-1">
                                       <span
                                           class="amount">Цена: {{item.food_price| currency}}
                                       </span>
    </p>

        <button class="btn btn-primary" @click="addProductToCart(item)">Добавить</button></div>

</div>


                                    </b-list-group-item>

                                </b-list-group>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6">
                                <div class="table-content table-responsive" style="min-height: 600px; max-height: 600px; overflow-y: scroll; width: 100%">
                                    <table>
                                        <thead>
                                        <tr class="title-top">
                                            <th class="product-name">Товар</th>
                                            <th class="product-price">Цена</th>
                                            <th class="product-quantity">Количество</th>
                                            <th class="product-subtotal">Всего</th>
                                            <th class="product-remove">Удалить</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-if="cartProducts.length>0" v-for="item in cartProducts">
                                            <td class="product-name"><a href="#">{{item.product.food_name}} <span
                                                v-if="item.product.selected_sub">(<em>{{item.product.selected_sub}}</em>)</span></a>
                                            </td>
                                            <td class="product-price"><span
                                                class="amount">{{item.product.food_price| currency}} </span></td>
                                            <td class="product-quantity">
                                                <p>Количество: {{item.quantity}}</p>
                                                <div class="row align-items-center justify-content-center buttons-group m-auto" style="width: 100%;">

                                                    <button type="button" class="btn btn-coutner btn-primary mr-2" :disabled="item.quantity===1"
                                                            @click="decrement(item.product)">-
                                                    </button>
                                                    <button type="button" class="btn btn-coutner btn-primary"
                                                            @click="increment(item.product)">+
                                                    </button>
                                                </div>
                                            </td>
                                            <td class="product-subtotal">{{item.quantity*item.product.food_price| currency}}
                                            </td>
                                            <td class="product-remove">
                                                <button class="cartbox__item__remove" @click="remove(item.product.id)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-lg-6 col-12 mb-30">

                    <!-- Checkout Accordion Start -->
                    <div id="checkout-accordion">

                        <!-- Checkout Method -->
                        <div class="single-accordion">
                            <a class="accordion-head" data-toggle="collapse" data-parent="#checkout-accordion"
                               href="#checkout-method" aria-expanded="true" style="background-color: #3490dc;">3. Введите номер телефона пользователя</a>

                            <div id="checkout-method" class="collapse show" style="">
                                <div class="checkout-method accordion-body fix">
                                    <form action="#" class="billing-form checkout-form">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-12  mb-2">
                                                <input type="text"
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

                        <!-- Billing Method -->
                        <div class="single-accordion">
                            <a class="accordion-head" data-toggle="collapse" data-parent="#checkout-accordion"
                               href="#billing-method" aria-expanded="true" style="background-color: #3490dc;">4. Данные доставки</a>
                            <div id="billing-method" class="collapse show" style="">

                                <div class="accordion-body billing-method fix">

                                    <form action="#" class="billing-form checkout-form">
                                        <div class="row">
                                            <div class="col-12 mb--20">
                                                <b-form-select v-model="delivery.city" :options="cities"></b-form-select>
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
                                                <input type="text" v-model="delivery.first_name" placeholder="Имя пользователя">
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
                                                <button type="button" class="btn btn-primary" @click="getRangePrice">
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

<!--                    <div class="order-details-wrapper" style="height: 47px;">-->
<!--                        <h2 style="background: #3490dc; height: 47px;">Заказ</h2>-->
                    <div class="single-accordion">
                        <a class="accordion-head" data-toggle="collapse" data-parent="#checkout-accordion"
                           href="#billing-method" aria-expanded="true" style="background-color: #3490dc;">5. Заказ</a>
                        <div class="accordion-body fix">
                            <div class="order-details">
                                <form action="#">
                                    <ul>
                                        <li><p class="strong">Продукт</p>
                                            <p class="strong">Всего</p>
                                        </li>
                                        <li v-for="item in cartProducts"><p>{{item.product.food_name}}
                                            x{{item.quantity}} </p>
                                            <p>{{item.quantity*item.product.food_price| currency}}</p></li>
                                        <li><p class="strong">Цена заказа</p>
                                            <p class="strong">{{cartTotalPrice| currency}}</p></li>
                                        <li><p class="strong">Цена доставки</p>
                                            <p>
                                                {{deliveryPrice|currency}}
                                            </p></li>
                                        <li><p class="strong">Всего</p>
                                            <p class="strong">{{cartTotalPrice+deliveryPrice | currency}}</p></li>
                                        <li>
                                            <button class="btn btn-primary" @click="clearCart" v-if="cartProducts.length>0">
                                                Очистить корзину
                                            </button>
                                        </li>
                                        <li>
                                            <button class="btn btn-primary" type="button"
                                                    @click="makeOrder">Создать новый заказ
                                            </button>
                                        </li>
                                    </ul>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </b-container>
    </div>
</template>

<script>
    import {mask} from 'vue-the-mask'
    export default {
        data() {
            return {
                rest_id: null,
                status: '',
                phone: null,
                name: '',
                address: '',
                delivery_range: null,
                deliveryPrice: 0,
                restorans:[],
                statuses: [
                    { value: null, text: 'Выберете статус' },
                    { value: 0, text: 'В обработке' },
                    { value: 1, text: 'Готовится' },
                    { value: 2, text: 'В процессе доставки' },
                    { value: 3, text: 'Доставлен' },
                    { value: 4, text: 'Отклонен администратором' }
                ],
                cities: [
                    { value: null, text: 'Выберете город' },
                    { value: "Донецк", text: "Донецк" },
                    { value: "Макеевка", text: "Макеевка" },
                ],

                items:[],
                cartProducts:[],
                delivery: {
                    city: null,
                    street: '',
                    first_name: '',
                    home_number: '',
                    flat_number: '',
                    more_info: '',
                    money_type: '0',
                },
                coords: {
                    latitude: 0,
                    longitude: 0
                },
                loading: false,
                menu_loading: false,
                search: '',
                req: ''
            }
        },
        created() {
            this.getRestorans();
        },
        computed: {
            cartTotalCount: function (){
                let summ = 0;
                this.cartProducts.forEach((item) => {
                    summ += item.quantity
                });
                return summ
            },
            cartTotalPrice: function () {
                let summ = 0;
                    this.cartProducts.forEach((item) => {
                    summ += item.product.food_price * item.quantity
                });
                return summ
            },
            filteredList() {
                return this.items.filter(item => {
                    return item.food_name.toLowerCase().includes(this.search.toLowerCase())
                })
            },
        },
        methods: {
            changeRestoran() {
                if(this.rest_id != null)
                {
                    this.cartProducts=[];
                    this.loadData();
                }
            },
            async getRestorans() {
                this.loading = true;
                const response = await axios
                    .get(`/admin/restorans/getRestorans`)
                    .then(resp => {
                        this.restorans = resp.data.restorans;
                        this.restorans.push({ value: null, text: 'Выберете ресторан' })
                        this.loading = false;
                    });
            },
            loadData() {
                this.items=[];
                this.menu_loading = true;
                 axios
                    .get(`/admin/menus/show/${this.rest_id}`)
                    .then(resp => {
                        this.items = resp.data.menu;
                        this.menu_loading = false;
                    });

            },
            addProductToCart(product) {
                let cartItem = this.cartProducts.find(item => item.product.id === product.id)
                if (!cartItem)
                    this.cartProducts.push({
                        product,
                        quantity: 1
                    })
                else
                    cartItem.quantity++;
            },
            getRangePrice() {
                if (this.delivery.city !=null && this.delivery.street != '' && this.delivery.home_number !='')
                {
                    let address = `г. ${this.delivery.city}, ${this.delivery.street}, ${this.delivery.home_number}`;
                    axios
                        .post("/admin/orders/range/" + this.rest_id, {
                            "address": address
                        }).then(resp => {

                        this.preparedToSend = true;
                        this.delivery_range = resp.data.range
                        this.deliveryPrice = resp.data.price
                        this.coords.latitude = resp.data.latitude
                        this.coords.longitude = resp.data.longitude

                    });
                }
            },
            makeOrder() {
                let products = [];
                this.cartProducts.forEach(function (item) {
                    products.push({
                        product_id: item.product.id,
                        count: item.quantity,
                        price: item.product.food_price,
                        more_info: item.product.selected_sub != null ? item.product.selected_sub : ''
                    })
                });
                axios
                    .post('/admin/orders/store', {
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
                        order_details: products
                    })
                    .then(response => {
                        this.clearCart()
                        this.sendMessage(response.data.message);
                        ym(61797661,'reachGoal','zakaz');
                        this.deliveryPrice = 0;
                        this.delivery_range = null;
                    });
            },
            sendMessage(message) {
                this.$notify({
                    group: 'info',
                    type: 'success',
                    title: 'Создание нового заказа',
                    text: message
                });
            },
            hasSub(product) {
                return product.food_sub != null;
            },
            increment(product) {
                this.sendMessage('Товар добавлен в корзину!');
                let cartItem = this.cartProducts.find(item => item.product.id === product.id)
                cartItem.quantity++
            },
            decrement(product) {
                this.sendMessage('Лишний товар убран из корзины!');

                if (this.hasSub(product)){
                    let tmp_item = this.cartProducts.find(item => item.product.id === product.id)
                    let tmp = tmp_item.product.selected_sub
                    tmp = tmp.split(',')
                    tmp = tmp.slice(0,tmp.length-1).join()
                    tmp_item.product.selected_sub = tmp
                }
                let cartItem = this.cartProducts.find(item => item.product.id === product.id)
                if (cartItem.quantity > 1)
                    cartItem.quantity--;
            },
            remove(id) {
                this.cartProducts = this.cartProducts.filter(item => item.product.id != id);
                // this.$store.dispatch("removeProduct", id)
            },
            clearCart() {
                this.deliveryPrice = 0;
                this.delivery_range = null;
                this.cartProducts=[];
            }
        },
        directives: {mask}
    }
</script>

<style scoped>

</style>
