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
                    <div class="product-counter">
                        <p>Количество: {{item.quantity}}</p>
                        <div class="buttons-group">
                            <button type="button" class="btn btn-coutner" :disabled="item.quantity===1"
                                    @click="decrement(item.product)">-
                            </button>
                            <button type="button" class="btn btn-coutner"
                                    @click="increment(item.product)">+
                            </button>
                        </div>
                    </div>
                    <span class="price">{{item.product.food_price| currency}} / {{item.product.food_price*item.quantity | currency }}</span>

                </div>
                <button class="cartbox__item__remove" @click="remove(item.product.id)">
                    <i class="fa fa-trash"></i>
                </button>
            </div>

            <h4 v-if="cartProducts.length==0">Сперва выберите товар!</h4>
        </div>
        <div class="cartbox__buttons" v-if="cartProducts.length>0">
            <a class="food__btn" href="../cart"><span>Оформить заказ</span></a>
            <a class="food__btn" @click="clearCart" v-if="cartProducts.length>0"><span>Очистить корзину</span></a>
        </div>
    </div>
</template>
<script>
    import {mask} from 'vue-the-mask'

    export default {
        data() {
            return {

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
            sendMessage(message) {
                this.$notify({
                    group: 'info',
                    type: 'success',
                    title: 'Корзина Fastoran',
                    text: message
                });
            },
            addToCart() {
                if (!this.checkFirstRestoran(this.product_data.rest_id)) {
                    this.sendMessage("Возможно одновременно заказать только из одного заведения!", 'error')
                    return;
                }
                this.sendMessage("Товар добавлен в корзину!")
                this.$store.dispatch('addProductToCart', this.product_data)
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
        span {
            color: white;
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
