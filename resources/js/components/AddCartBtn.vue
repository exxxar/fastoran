<template>
    <div class="product-btn-box">
        <div style="width:100%;" v-if="product_data.food_status!==6">
            <a class="btn_a btn_link btn-add-to-cart" v-if="inCart()===0&&!hasSub()"
               @click="addToCart()"><i class="fas fa-cart-plus"></i></a>

            <a class="btn_a btn_link btn-add-to-cart" v-if="inCart()===0&&hasSub()"
               @click="openSubMenu()"><i class="fas fa-cart-plus"></i></a>


            <a v-b-tooltip.hover :title="product_data.food_remark"
               class="btn_a btn_link btn-show-info"
               v-if="inCart()===0"
               :id="'menu'+product_id" :data-target="'menu'+product_id"><i class="fas fa-info-circle"></i></a>


            <div v-if="product_id!=null">
                <b-modal :id="'modal-submenu-'+product_id" hide-footer no-stacking>

                    <template v-slot:modal-title>
                        <h3>Выбор подкатегории</h3>
                    </template>
                    <div class="d-block text-center">


                        <b-form-checkbox-group :id="'modal-submenu-check-'+product_id" v-model="selected"
                                               name="flavour-2">

                            <li class="sub-item" v-for="sub in getFoodSub()">

                                <b-form-checkbox v-model="selected" :value="sub.name">{{sub.name}}
                                </b-form-checkbox>

                            </li>
                        </b-form-checkbox-group>


                    </div>
                    <b-button class="mt-3 btn-food" :disabled="selected==null||selected.length===0" block
                              @click="addToCartWithSub">Добавить
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

        <div v-else style="width:100%;" class="d-flex justify-content-flex-end">

            <p class="text-left" v-if="inCart()!==0">Выбрано: {{inCartWeight()}} грамм</p>
            <p class="text-left" v-if="inCart()===0">Товар на вес! {{product_data.food_price}}₽ за {{product_data.food_ext}} грамм</p>
            <a class="btn_a btn_link btn-add-to-cart"
               @click="openWeightModal()"><i class="fas fa-cart-plus"></i></a>


            <a v-b-tooltip.hover :title="product_data.food_remark"
               class="btn_a btn_link btn-show-info"
               :id="'menu'+product_id" :data-target="'menu'+product_id"><i class="fas fa-info-circle"></i></a>

            <b-modal :id="'modal-weight-'+product_id" hide-footer no-stacking>

                <template v-slot:modal-title>
                    <h3>Укажие вес продукта</h3>
                </template>
                <div class="d-block text-center">
                    <input type="number" min="100" max="10000" class="form-control" v-model="weight">
                </div>
                <b-button class="mt-3 btn-food"  block @click="addToCartWithWeight">Добавить
                </b-button>


            </b-modal>
        </div>

    </div>
</template>
<script>
    export default {
        props: ["product_id", "product_data"],
        data() {
            return {
                selected: null,
                weight:100,
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
            openWeightModal(){
                this.$bvModal.show("modal-weight-" + this.product_id)
              console.log("Test");
            },
            addToCartWithWeight(){
                if (!this.checkFirstRestoran(this.product_data.rest_id)) {
                    this.sendMessage("Возможно одновременно заказать только из одного заведения!", 'error')
                    return;
                }
                this.$store.dispatch("addProductToCartWithWeight", {product: this.product_data, weight: this.weight})
                this.$bvModal.hide("modal-weight-" + this.product_id)
                this.sendMessage("Весовой товар добавлен в корзину!")
            },
            addToCartWithSub() {
                this.addToCart()

                this.selected.forEach((item, key) => {
                    if (key <= this.selected.length - 2) {
                        this.incProduct();
                    }

                });

                let tmp = this.selected.join();

                this.$store.dispatch("addSub", {id: this.product_id, more_info: tmp})
                this.$bvModal.hide("modal-submenu-" + this.product_id)
            },
            hasSub() {
                return this.product_data.food_sub != null;
            },
            getFoodSub() {
                return this.hasSub() ? JSON.parse(this.product_data.food_sub) : [];
            },
            checkFirstRestoran(restId) {
                //console.log(this.product_data)
                return this.products.filter(item => /*item.product.rest_id !== this.product.rest_id&&*/
                    item.product.restoran.parent_id!== this.product_data.restoran.parent_id
                ).length === 0 || this.products.length === 0;

      },
            inCartWeight(){
                let tmp = this.products.filter(item => item.product.id === this.product_id);
                return tmp.length === 0 ? 0 : tmp[0].weight
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

                if (this.hasSub())
                    this.$store.dispatch('remSub', this.product_id)
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

    .sub-item {
        list-style: none;
        padding: 10px;
        border: 1px lightblue solid;
        width: 100%;
        margin-bottom: 5px;
    }

    .btn-food {
        background: #e3342f;
        border: none;

        &:hover {
            background: darkred;
        }
    }

    .product-btn-box {
        position: relative;
        top: 0;
        left: 0;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        width: 100%;
        height: 70px;
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
        justify-content: space-between;
        width: 100%;
        padding: 10px 0px;

        p {
            text-align: center;
            font-weight: 900;
            color: #3b393c;
            font-size: 24px;
            padding-top: 7px;
        }
    }
</style>
