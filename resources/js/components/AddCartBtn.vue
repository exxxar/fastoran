<template>
    <div class="product-btn-box">
        <a href="#add_to_cart" class="btn_a btn_link btn-add-to-cart" v-if="inCart()===0&&!hasSub()"
           @click="addToCart()"><i class="fas fa-cart-plus"></i></a>

        <a href="#add_to_cart" class="btn_a btn_link btn-add-to-cart" v-if="inCart()===0&&hasSub()"
           @click="openSubMenu()"><i class="fas fa-cart-plus"></i></a>


        <a href="#info" v-b-tooltip.hover :title="product_data.food_remark"
           class="btn_a btn_link btn-show-info"
           v-if="inCart()===0"
           :id="'menu'+product_id" :data-target="'menu'+product_id"><i class="fas fa-info-circle"></i></a>


        <div v-if="product_id&&product_data">
            <b-modal :id="'modal-submenu-'+product_id" hide-footer>

                <template v-slot:modal-title>
                    <h3>Выбор подкатегории</h3>
                </template>
                <div class="d-block text-center">
                    <ul>
                        <li v-for="sub in getFoodSub()">
                            <b-form-group :label="product_data.food_name">
                                <b-form-radio v-model="selected" name="some-radios" :value="sub.name">{{sub.name}}
                                </b-form-radio>

                            </b-form-group>
                        </li>
                    </ul>
                </div>
                <b-button class="mt-3 btn-food" :disabled="selected==null" block @click="addToCartWithSub">Добавить
                </b-button>


            </b-modal>
        </div>


        <div class="cnt-container" v-if="inCart()>0">
            <button class="btn btn-coutner" @click="decProduct()">
                -
            </button>
            <p v-html="inCart()"></p>
            <button class="btn btn-coutner" @click="incProduct()">
                <span>+</span>
            </button>
        </div>


    </div>
</template>
<script>
    export default {
        props: ["product_id", "product_data"],
        data() {
            return {
                selected: null
            }
        },
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
            addToCartWithSub() {
                this.product_data.selected_sub = this.selected
                this.addToCart()
                this.$bvModal.hide("modal-submenu-" + this.product_id)
            },
            hasSub() {
                return this.product_data.food_sub != null;
            },
            getFoodSub() {
                return this.hasSub() ? JSON.parse(this.product_data.food_sub) : [];
            },
            checkFirstRestoran(restId) {
                return this.products.filter(item => item.product.rest_id !== this.product_data.rest_id).length === 0 || this.products.length === 0;
            },
            inCart() {
                let tmp = this.products.filter(item => item.product.id === this.product_id);
                return tmp.length === 0 ? 0 : tmp[0].quantity
            },
            openSubMenu() {
                this.$bvModal.show("modal-submenu-" + this.product_id)
            },
            addToCart() {
                if (!this.checkFirstRestoran(this.product_data.rest_id)) {
                    this.sendMessage("Возможно одновременно заказать только из одного заведения!", 'error')
                    return;
                }
                this.sendMessage("Товар добавлен в корзину!")
                this.$store.dispatch('addProductToCart', this.product_data)
            },
            incProduct() {
                this.sendMessage("Товар добавлен в корзину!")
                this.$store.dispatch('incQuantity', this.product_id)
            },
            decProduct() {
                this.sendMessage("Лишний товар убран из корзины!")

                if (this.inCart() === 1) {
                    this.$store.dispatch('removeProduct', this.product_id)
                    return;
                }

                this.$store.dispatch('decQuantity', this.product_id)
            },
            sendMessage(message, type = 'success') {
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

    .btn-food {
        background: #e3342f;
        border: none;

        &:hover {
            background: darkred;
        }
    }

    .product-btn-box {
        position: absolute;
        top: 0;
        left: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        font-size: 20px;
        padding: 10px;
        z-index: 11;
        box-sizing: border-box;

        a.btn_a.btn_link.btn-show-info {
            padding: 10px;
            color: white;
            background: #9ce300;
        }

        a.btn_a.btn_link.btn-add-to-cart {
            padding: 10px;
            color: white;
            background: #e3342f;
        }
    }

    .cnt-container {
        display: flex;
        justify-content: space-around;
        width: 100%;
        background: #f8fafc7a;
        padding: 10px;

        p {
            text-align: center;
            font-weight: 900;
            color: #3b393c;
            font-size: 24px;
            padding-top: 7px;
        }
    }
</style>
