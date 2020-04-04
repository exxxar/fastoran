<template>
    <div class="cartbox__inner text-left">
        <div class="cartbox__items">
            <!-- Cartbox Single Item -->
            <div class="cartbox__item">
                <div class="cartbox__item__thumb">
                    <a href="product-details.html">
                        <img src="https://d29u17ylf1ylz9.cloudfront.net/aahar/images/blog/sm-img/1.jpg"
                             alt="small thumbnail">
                    </a>
                </div>
                <div class="cartbox__item__content">
                    <h5><a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/product-details.html"
                           class="product-name">Vanila Muffin</a></h5>
                    <p>Qty: <span>01</span></p>
                    <span class="price">$15</span>
                </div>
                <button class="cartbox__item__remove">
                    <i class="fa fa-trash"></i>
                </button>
            </div><!-- //Cartbox Single Item -->
            <!-- Cartbox Single Item -->
            <div class="cartbox__item">
                <div class="cartbox__item__thumb">
                    <a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/product-details.html">
                        <img src="https://d29u17ylf1ylz9.cloudfront.net/aahar/images/blog/sm-img/2.jpg"
                             alt="small thumbnail">
                    </a>
                </div>
                <div class="cartbox__item__content">
                    <h5><a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/product-details.html"
                           class="product-name">Wheat Bread</a></h5>
                    <p>Qty: <span>01</span></p>
                    <span class="price">$25</span>
                </div>
                <button class="cartbox__item__remove">
                    <i class="fa fa-trash"></i>
                </button>
            </div><!-- //Cartbox Single Item -->
            <!-- Cartbox Single Item -->
            <div class="cartbox__item">
                <div class="cartbox__item__thumb">
                    <a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/product-details.html">
                        <img src="https://d29u17ylf1ylz9.cloudfront.net/aahar/images/blog/sm-img/3.jpg"
                             alt="small thumbnail">
                    </a>
                </div>
                <div class="cartbox__item__content">
                    <h5><a href="https://d29u17ylf1ylz9.cloudfront.net/aahar/product-details.html"
                           class="product-name">Mixed Fruits Pie</a></h5>
                    <p>Qty: <span>01</span></p>
                    <span class="price">$30</span>
                </div>
                <button class="cartbox__item__remove">
                    <i class="fa fa-trash"></i>
                </button>
            </div><!-- //Cartbox Single Item -->
        </div>
        <div class="cartbox__total">
            <ul>
                <li><span class="cartbox__total__title">Subtotal</span><span class="price">$70</span></li>
                <li class="shipping-charge"><span class="cartbox__total__title">Shipping Charge</span><span
                    class="price">$05</span></li>
                <li class="grandtotal">Total<span class="price">$75</span></li>
            </ul>
        </div>
        <div class="cartbox__buttons">
            <a class="food__btn"
               href="https://d29u17ylf1ylz9.cloudfront.net/aahar/cart.html"><span>View cart</span></a>
            <a class="food__btn"
               href="https://d29u17ylf1ylz9.cloudfront.net/aahar/checkout.html"><span>Checkout</span></a>
        </div>
    </div>
    <!--<div class="cart">

        <div class="container" v-if="cartProducts.length>0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="chopcafe_product_table">
                        <table class="chopcafe_table chopcafe_custom_table table">
                            <thead>
                            <tr>
                                <th>Изображение</th>
                                <th>Название продукта</th>
                                <th>Цена</th>
                                <th>Количество</th>
                                <th>Всего</th>
                                <th>Удалить</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in cartProducts">
                                <td class="thumbnail">
                                    <img :src="item.product.image_url" class="img-fluid" alt="">
                                </td>
                                <td class="product_title"><a href="shop_details.html">{{item.product.title}}</a>
                                </td>
                                <td class="product_price"><span>{{item.product.price | currency}}</span></td>
                                <td class="product_quantity">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-2 col-lg-2">
                                            <button type="button" class="btn btn-primary" :disabled="item.quantity===1"
                                                    @click="decrement(item.product.id)">-
                                            </button>

                                        </div>

                                        <div class="col-sm-4 col-lg-4">
                                            <input type="number" :value="item.quantity" step="1" min="0"
                                                   class="form-control">

                                        </div>
                                        <div class="col-sm-2 col-lg-2">
                                            <button type="button" class="btn btn-primary"
                                                    @click="increment(item.product.id)">+
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="total">
                                    <span>{{item.product.price*item.quantity | currency }}</span>
                                </td>
                                <td class="product_delete">
                                    <a href="#" @click="remove(item.product.id)"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="billing_order_confirm">
                        <table class="table chopcafe_table">
                            <thead>
                            <tr>
                                <th class="cart_title" colspan="2">Итого</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="subtotal"></td>
                                <td class="subtotal_price"><span>Всего</span></td>
                            </tr>
                            <tr>
                                <td class="product"><span>Количество</span></td>
                                <td class="price"><span>{{cartTotalCount}}</span></td>
                            </tr>
                            <tr>
                                <td class="shipping"><span>Доставка</span></td>
                                <td class="shipping_info"><span>{{deliveryPrice|currency}}</span></td>
                            </tr>
                            <tr>
                                <td class="total_price"><span>Цена заказа</span></td>
                                <td class="price"><span>{{cartTotalPrice+deliveryPrice | currency}}</span></td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="row mt-2">
                            <div class="col-lg-6 col-sm-12">
                                <div class="update_cart">
                                    <a href="#" class="chopcafe_btn clear_cart_btn" @click="clearCart"><i
                                        class="fas fa-times-circle"></i>Очистить
                                        корзину</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-6">
                    <form @submit="sendRequest">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form_group">
                                    <input type="text" placeholder="Ваше имя" name="name"
                                           v-model="name"
                                           required="required"
                                           class="form_control">
                                </div>
                            </div>
                            <div class="col-lg-12 mt-2">
                                <div class="form_group">
                                    <input type="text" placeholder="Ваш номер телефона" name="phone"
                                           v-model="phone"
                                           required="required" pattern="[\+]\d{2} [\(]\d{3}[\)] \d{3}[\-]\d{2}[\-]\d{2}" class="form_control" maxlength="19"
                                           v-mask="['+38 (###) ###-##-##']">
                                </div>
                            </div>

                            <div class="col-lg-12 mt-2">
                                <div class="form_group">
                                    <textarea style="height: 122px;" placeholder="Сообщение для нас"
                                              name="message"
                                              v-model="message"
                                              class="form_control"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 mt-2">
                                <div class="continue_shopping">
                                    <button class="chopcafe_btn continue_btn" :disabled="sending"><i
                                        class="fas fa-shopping-cart"></i>Оформить
                                        покупку</button>
                                </div>
                            </div>


                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div v-if="cartProducts.length===0">
            <div class="row justify-content-center">
                <img :src="'../assets/images/empty_cart.png'" alt="">
            </div>
            <h1 class="text-center">Корзина пуста:(</h1>
        </div>

    </div>-->
</template>
<script>
    import {mask} from 'vue-the-mask'
    export default {
        data() {
            return {
                phone: '',
                name: '',
                message: '',
                deliveryPrice: 50,
                sending:false
            }
        },
        mounted() {
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
            sendRequest(e) {
                e.preventDefault();
                this.sending = true;
                let products = '';
                this.cartProducts.forEach(function (item) {
                    products += item.product.title +"_#"+item.product.id+ "_ x  "+ item.quantity + "штук => " + item.quantity * item.product.price + "₽\n"
                });
                let message = `*Заказ с сайта:*\n${products}\n_${this.message}_\nСуммарно: ${this.cartTotalPrice + this.deliveryPrice} ₽`;
                axios
                    .post('api/send-request', {
                        name: this.name,
                        phone: this.phone,
                        message: message
                    })
                    .then(response => {
                        this.sendMessage("Заказ успешно отправлен");
                        this.sending = false;
                        this.clearCart()
                    });
            },
            sendMessage(message) {
                this.$notify({
                    group: 'messages',
                    type: 'success',
                    title: 'Отправка заказа ISUSHI',
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
<style lang="scss">
    .chopcafe_custom_table {
        min-width: 1000px;
    }
</style>
