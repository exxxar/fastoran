<template>
    <div>
        <notifications group="message"/>
        <div class="single-accordion" style="width: 100%; ">
            <a class="accordion-head" href="#" aria-expanded="true">1.
                Выберите заведение</a>
            <div id="restoran" class="" style="">
                <div class="accordion-body restoran fix text-center">
                    <b-form-select v-model="rest_id" :options="restorans" :disabled="menu_loading"
                                   @change="changeRestoran"></b-form-select>
                </div>
            </div>
        </div>

        <div class="single-accordion" style="width: 100%;">
            <a class="accordion-head" href="#" aria-expanded="true">2. Выберите
                продукты</a>
            <div class="accordion-body fix text-center">
                <div v-if="menu_loading" class="d-flex justify-content-center mt-3 mb-3">
                    <b-spinner style="width: 3rem; height: 3rem;" label="Large Spinner"></b-spinner>
                    <h2 style="height: 3rem;" class="mt-auto mb-auto ml-3">
                        Загрузка...
                    </h2>
                </div>
                <h3 class="text-center m-auto" v-if="rest_id =='' || rest_id == null"> Сначала выберите
                    заведение</h3>
                <div v-if="!menu_loading && rest_id !='' && rest_id != null">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-lg-12">
                            <div class="search-wrapper">
                                <b-form-input type="text" class="mb-4 mt-4" v-model="search"
                                              placeholder="Поиск"></b-form-input>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12 col-sm-12 col-lg-12 mt-3">

                            <b-tabs card>
                                <b-tab :title="category.title" v-for="(category,index) in filteredList">
                                    <b-card-text>
                                        <b-list-group>


                                            <b-list-group-item class="flex-column align-items-start"
                                                               v-for="item in category.menus"
                                                               v-bind:key="item.id">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h5 class="mb-1">{{item.food_name}}</h5>
                                                </div>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <img :src="item.food_img" v-b-tooltip.hover
                                                             :title="item.food_remark"
                                                             style="height: 80px; width: 80px">
                                                    </div>
                                                    <div class="col-8">

                                                        <p class="mb-1"><span class="amount">Цена: {{item.food_price| currency}}</span>
                                                        </p>


                                                        <add-cart-btn class="mt-2" :product_id="item.id"
                                                                      :product_data="item"></add-cart-btn>
                                                    </div>

                                                </div>


                                            </b-list-group-item>

                                        </b-list-group>

                                    </b-card-text>
                                </b-tab>
                            </b-tabs>


                            <!--         <div class="accordion" id="accordionCategories"
                                          style="min-height: 100px;max-height: 800px; overflow-y: scroll;">
                                         <div class="card" v-for="(category,index) in filteredList">
                                             <div class="card-header" :id="'heading_'+category.alias">
                                                 <h2 class="mb-0">
                                                     <button class="btn btn-link collapsed" type="button"
                                                             data-toggle="collapse"
                                                             :data-target="'#collapse_'+category.alias" aria-expanded="false"
                                                             :aria-controls="'#collapse_'+category.alias">
                                                         {{category.title}}
                                                     </button>
                                                 </h2>
                                             </div>
                                             <div :id="'collapse_'+category.alias" :class="'collapse'+(index===0?' show':'')"
                                                  :aria-labelledby="'heading_'+category.alias"
                                                  data-parent="#accordionCategories">
                                                 <div class="card-body">
                                                     <b-list-group
                                                         style="min-height: 100px;max-height: 600px; overflow-y: scroll;">


                                                         <b-list-group-item class="flex-column align-items-start"
                                                                            v-for="item in category.menus"
                                                                            v-bind:key="item.id">
                                                             <div class="d-flex w-100 justify-content-between">
                                                                 <h5 class="mb-1">{{item.food_name}}</h5>
                                                             </div>
                                                             <div class="row">
                                                                 <div class="col-4">
                                                                     <img :src="item.food_img" v-b-tooltip.hover
                                                                          :title="item.food_remark"
                                                                          style="height: 80px; width: 80px">
                                                                 </div>
                                                                 <div class="col-8">

                                                                     <p class="mb-1"><span class="amount">Цена: {{item.food_price| currency}}</span>
                                                                     </p>


                                                                     <add-cart-btn class="mt-2" :product_id="item.id"
                                                                                   :product_data="item"></add-cart-btn>
                                                                 </div>

                                                             </div>


                                                         </b-list-group-item>

                                                     </b-list-group>
                                                 </div>
                                             </div>
                                         </div>

                                     </div>-->
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12 col-sm-12 col-lg-12 mt-3" v-if="cartProducts.length>0">
                            <h3>Выбранные продукты</h3>
                            <b-list-group>
                                <b-list-group-item v-if="cartProducts.length>0"
                                                   class="flex-column align-items-start"
                                                   v-for="item in cartProducts" v-bind:key="item.product.id">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{item.product.food_name}}</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <img :src="item.product.food_img" style="height: 80px; width: 80px">
                                        </div>
                                        <div class="col-8">
                                            <p class="mb-1">
                                       <span class="amount">Цена: {{item.product.food_price| currency}} / {{item.product.food_price*item.quantity | currency }}
                                       </span>
                                            </p>

                                            <div class="product-counter">
                                                <p>Количество: {{item.quantity}}</p>
                                                <div class="buttons-group">
                                                    <button type="button" class="btn btn-coutner"
                                                            :disabled="item.quantity===1"
                                                            @click="decrement(item.product)">-
                                                    </button>
                                                    <button type="button" class="btn btn-coutner"
                                                            @click="increment(item.product)">+
                                                    </button>

                                                    <button class="cartbox__item__remove"
                                                            @click="remove(item.product.id)">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>


                                        </div>

                                    </div>


                                </b-list-group-item>

                            </b-list-group>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-6 col-12 mb-30">
                <div class="single-accordion">
                    <a class="accordion-head" data-toggle="collapse" data-parent="#checkout-accordion"
                       href="#checkout-method" aria-expanded="true">3.
                        Введите номер телефона пользователя</a>

                    <div id="checkout-method" class="collapse show">
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
                <div class="single-accordion">
                    <a class="accordion-head" data-toggle="collapse" data-parent="#checkout-accordion"
                       href="#billing-method" aria-expanded="true">4. Данные
                        доставки</a>
                    <div id="billing-method" class="collapse show">

                        <div class="accordion-body billing-method fix">

                            <form action="#" class="billing-form checkout-form">
                                <div class="row">
                                    <div class="col-12 mb--20">
                                        <b-form-select v-model="delivery.city"
                                                       :options="cities"></b-form-select>
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
                                        <input type="text" v-model="delivery.first_name"
                                               placeholder="Имя пользователя">
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
            </div>

            <div class="col-lg-6 col-12 mb-30">
                <div class="single-accordion">
                    <a class="accordion-head" data-toggle="collapse" data-parent="#checkout-accordion"
                       href="#billing-method" aria-expanded="true">5. Заказ</a>
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
                                        <button class="food__btn" @click="clearCart"
                                                v-if="cartProducts.length>0">
                                            Очистить корзину
                                        </button>
                                    </li>
                                    <li>
                                        <button class="food__btn" type="button"
                                                @click="makeOrder">Оформить заказ
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
                rest_id: null,
                status: '',
                phone: null,
                name: '',
                address: '',
                delivery_range: null,
                deliveryPrice: 0,
                restorans: [],
                cities: [
                    {value: "Донецк", text: "Донецк"},
                    {value: "Макеевка", text: "Макеевка"},
                ],

                items: [],
                delivery: {
                    city: "Донецк",
                    street: '',
                    first_name: '',
                    home_number: '',
                    flat_number: '',
                    more_info: '',
                    money_type: '0',
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
            cartProducts: function () {
                return this.$store.getters.cartProducts;
            },
            cartTotalCount: function () {
                return this.$store.getters.cartTotalCount;
            },
            cartTotalPrice: function () {
                return this.$store.getters.cartTotalPrice;
            },
            filteredList() {
                if (this.items.length === 0)
                    return [];

                if (this.search.trim().length === 0)
                    return this.items;
                // console.log(this.items)

                let tmp_categories = [{
                    title: "Все категории",
                    alias: "all_categories",
                    menus: []
                }];

                this.items.forEach(category => {
                    category.menus.forEach(item => {
                        console.log(item.food_name)
                        if (item.food_name.toLowerCase().includes(this.search.toLowerCase()))
                            tmp_categories[0].menus.push(item)

                    })

                })

                return tmp_categories
            },
        },
        methods: {
            changeRestoran() {
                if (this.rest_id != null) {
                    this.clearCart()
                    this.loadData();
                }
            },
            async getRestorans() {
                this.loading = true;
                const response = await axios
                    .get(`/api/v1/fastoran/restorans`)
                    .then(resp => {
                        let restorans = resp.data.restorans.data;
                        restorans.forEach(item => {
                            this.restorans.push({value: item.id, text: item.name})
                        });
                        this.restorans.push({value: null, text: 'Выберете ресторан'})
                        this.loading = false;
                    });
            },
            loadData() {
                this.items = [];
                this.menu_loading = true;
                axios
                    .get(`/api/v1/fastoran/menus/${this.rest_id}`)
                    .then(resp => {
                        this.items = resp.data.menu_items;
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
                if (this.delivery.city != null && this.delivery.street !== '' && this.delivery.home_number !== '') {
                    let address = `г. ${this.delivery.city}, ${this.delivery.street}, ${this.delivery.home_number}`;
                    axios
                        .post("../api/v1/range/" + this.rest_id, {
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

                axios
                    .post('/orders/store', {
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
                        ym(61797661, 'reachGoal', 'zakaz');
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
                this.$store.dispatch("clearCart")
            }
        },
        directives: {mask}
    }
</script>

<style lang="scss" scoped>
    .product-counter {
        flex-wrap: wrap;

        p {
            width: 100%;
        }

        .buttons-group {
            width: 100%;
            display: flex;
            justify-content: space-evenly;

            button.cartbox__item__remove {
                width: 35px;
                height: 35px;
            }
        }
    }
</style>
