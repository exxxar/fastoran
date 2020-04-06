<template>
    <div class="product-btn-box">
        <a href="#add_to_cart" class="btn_a btn_link btn-add-to-cart" v-if="inCart(product_id)===0"
           :data-target="'menu'+product_id" @click="addToCart(product_data)"><i class="fas fa-cart-plus"></i></a>

        <div class="cnt-container" v-if="inCart(product_id)>0">
            <button class="btn btn-coutner" @click="decProduct(product_id)">
                -
            </button>
            <p v-html="inCart(product_id)"></p>
            <button class="btn btn-coutner" @click="incProduct(product_id)">
                <span>+</span>
            </button>
        </div>
    </div>
</template>
<script>
    export default {
        props: ["product_id", "product_data"],
        watch: {
            products: function (newVal, oldVal) {
                return newVal
            }
        },
        computed: {
            products() {
                return this.$store.getters.cartProducts;
            }
        },
        mounted() {
            let callback = (val, oldVal, uri) => {
                this.$store.dispatch("getProductList")
            }

            Vue.ls.on('store', callback) //watch change foo key and triggered callbac
        },
        methods: {
            checkFirstRestoran(restId) {
                return this.products.filter(item => item.product.rest_id !== restId).length === 0 || this.products.length === 0;
            },
            inCart(menuId) {
                let tmp = this.products.filter(item => item.product.id === menuId);
                return tmp.length === 0 ? 0 : tmp[0].quantity
            },
            addToCart(menu_item) {
                if (!this.checkFirstRestoran(menu_item.rest_id)) {
                    this.sendMessage("Возможно одновременно заказать только из одного заведения!", 'error')
                    return;
                }
                this.sendMessage("Товар добавлен в корзину!")
                this.$store.dispatch('addProductToCart', menu_item)
            },
            incProduct(menuId) {
                this.sendMessage("Товар добавлен в корзину!")
                this.$store.dispatch('incQuantity', menuId)
            },
            decProduct(menuId) {
                this.sendMessage("Лишний товар убран из корзины!")

                if (this.inCart(menuId) === 1) {
                    this.$store.dispatch('removeProduct', menuId)
                    return;
                }

                this.$store.dispatch('decQuantity', menuId)
            },
            /* add: function () {
                 console.log(this.product_data)
                 this.sendMessage("Товар успешно добавлен в корзину!")
                 this.$store.dispatch('addProductToCart', this.product_data)
               /!*  axios
                     .get('api/products/get/' + this.product_id)
                     .then(response => {

                         this.$store.dispatch('addProductToCart', response.data.product)
                     });*!/
             },*/
            sendMessage(message, type = 'success') {
                console.log(message);
                this.$notify({
                    group: 'info',
                    type: type,
                    title: 'Оповещение Fastoran',
                    text: message
                });
            },
        }
    }
</script>
<style lang="scss">
    .product-btn-box {
        position: absolute;
        top: 0;
        left: 0;
        display: flex;
        justify-content: flex-end;
        align-items: flex-start;
        width: 100%;
        height: 100%;
        font-size: 20px;
        padding: 10px;
        z-index: 10;
        box-sizing: border-box;

        a.btn_a.btn_link.btn-add-to-cart {
            padding: 10px;
            color: white;
            background: #e3342f;
        }
    }

    .cnt-container {
        display: flex;
        justify-content: space-around;
        width: 90px;

        p {
            text-align: center;
            font-weight: 900;
            color: #3b393c;
        }
    }
</style>
