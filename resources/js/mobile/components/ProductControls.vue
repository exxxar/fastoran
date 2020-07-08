<template>
    <div>
        <div style="width:100%;" v-if="product.food_status!==6">
            <div class="product-item__controls">
                <button type="button" @click="addToCart()" class="btn btn-outline-success product-item__btn"
                        v-if="inCart()===0&&!hasSub()"><i
                    class="fas fa-cart-plus"></i></button>

                <button type="button" @click="openSubMenu()" class="btn btn-outline-success product-item__btn"
                        v-if="inCart()===0&&hasSub()"><i class="fas fa-cart-plus"></i></button>
                <!--
                            <button type="button"
                                    class="btn btn-outline-info product-item__btn" @click="showInfoModal"
                                    v-if="inCart()===0" :id="'menu'+product.id" ><i
                                class="fas fa-info-circle"></i></button>-->


                <div v-if="inCart()>0">
                    <button type="button" class="btn btn-outline-success product-item__btn" @click="decProduct()">
                        -
                    </button>
                    <p v-html="inCart()"></p>
                    <button type="button" class="btn btn-outline-success product-item__btn" @click="incProduct()">
                        <span>+</span>
                    </button>
                </div>
            </div>
        </div>
        <div v-else style="width:100%;" class="d-flex justify-content-center flex-wrap">

            <p class="text-center line-height pr-1 pl-1" v-if="inCart()!==0">Выбрано: {{inCartWeight()}} грамм</p>
            <p class="text-center line-height pr-1 pl-1" v-if="inCart()===0">Товар на вес! {{product.food_price}}₽ за {{product.food_ext}}
                грамм</p>
            <button type="button" class="btn btn-outline-success product-item__btn mb-1"
               @click="openWeightModal()"><i class="fas fa-cart-plus"></i></button>
        </div>

        <div class="product-item__empty-box" v-if="!product.rest_info.is_work">
            <p class="text-center">
                <mark class="color&#45;&#45;white">Время работы:
                    <strong>{{product.rest_info.work_time}}</strong>
                </mark>
            </p>
        </div>


        <b-modal :id="'modal-weight-'+product.id" hide-footer scrollable centered hide-backdrop no-stacking
                 dialog-class="modal-class" content-class="content-class">

            <template v-slot:modal-title>
                <h6>Укажие вес продукта, грамм</h6>
            </template>
            <div class="d-block text-center">
                <input type="number" min="100" max="10000" class="form-control" v-model="weight">
            </div>
            <b-button class="mt-1 btn  btn-outline-success" block @click="addToCartWithWeight">Добавить
            </b-button>


        </b-modal>

        <div v-if="product.id!=null">
            <b-modal :id="'modal-submenu-'+product.id" hide-footer scrollable centered hide-backdrop no-stacking
                     dialog-class="modal-class" content-class="content-class">

                <template v-slot:modal-title>
                    <h6>Выбор подкатегории</h6>
                </template>
                <div class="d-block text-center">


                    <b-form-checkbox-group :id="'modal-submenu-check-'+product.id" v-model="selected" name="flavour-2">

                        <li class="sub-item" v-for="sub in getFoodSub()">

                            <b-form-checkbox v-model="selected" :value="sub.name">{{sub.name}}
                            </b-form-checkbox>

                        </li>
                    </b-form-checkbox-group>


                </div>
                <b-button class="mt-1 tn  btn-outline-success" :disabled="selected==null||selected.length===0" block
                          @click="addToCartWithSub">Добавить
                </b-button>


            </b-modal>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["product"],
        data() {
            return {
                selected: null,
                weight: 100,
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
            openWeightModal() {
                this.$bvModal.show("modal-weight-" + this.product.id)
            },
            addToCartWithWeight() {
                if (!this.checkFirstRestoran(this.product.rest_id)) {
                    this.sendMessage("Возможно одновременно заказать только из одного заведения!", 'error')
                    return;
                }
                this.$store.dispatch("addProductToCartWithWeight", {product: this.product, weight: this.weight})
                this.$bvModal.hide("modal-weight-" + this.product.id)
                this.sendMessage("Весовой товар добавлен в корзину!")
            },
            showInfoModal() {
                this.$bvModal.show("modal-info-" + this.product.id)
            },
            addToCartWithSub() {
                this.addToCart()

                this.selected.forEach((item, key) => {
                    if (key <= this.selected.length - 2) {
                        this.incProduct();
                    }

                });

                let tmp = this.selected.join();

                this.$store.dispatch("addSub", {id: this.product.id, more_info: tmp})
                this.$bvModal.hide("modal-submenu-" + this.product.id)
            },
            hasSub() {
                return this.product.food_sub != null;
            },
            getFoodSub() {
                return this.hasSub() ? JSON.parse(this.product.food_sub) : [];
            },
            checkFirstRestoran(restId) {
                return this.products.filter(item => item.product.rest_id !== this.product.rest_id).length === 0 || this.products.length === 0;
            },
            inCartWeight(){
                let tmp = this.products.filter(item => item.product.id === this.product.id);
                return tmp.length === 0 ? 0 : tmp[0].weight
            },
            inCart() {
                let tmp = this.products.filter(item => item.product.id === this.product.id);
                return tmp.length === 0 ? 0 : tmp[0].quantity
            },
            openSubMenu() {
                if (!this.checkFirstRestoran(this.product.rest_id)) {
                    this.sendMessage("Возможно одновременно заказать только из одного заведения!", 'error')
                    return;
                }

                this.$bvModal.show("modal-submenu-" + this.product.id)
            },
            addToCart() {
                if (!this.checkFirstRestoran(this.product.rest_id)) {
                    this.sendMessage("Возможно одновременно заказать только из одного заведения!", 'error')
                    return;
                }
                this.sendMessage("Товар добавлен в корзину!")
                this.$store.dispatch('addProductToCart', this.product)
            },
            incProduct() {

                this.sendMessage("Товар добавлен в корзину!")
                this.$store.dispatch('incQuantity', this.product.id)
            },
            decProduct() {
                this.sendMessage("Лишний товар убран из корзины!")

                if (this.inCart() === 1) {
                    this.$store.dispatch('removeProduct', this.product.id)
                    return;
                }

                if (this.hasSub())
                    this.$store.dispatch('remSub', this.product.id)
                this.$store.dispatch('decQuantity', this.product.id)
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

    .custom-control {
        margin-bottom: 0px;
    }

    .line-height {
        line-height: 100%;
    }
    .product-item__controls {
        width: 100%;
        display: flex;
        padding: 5px 5px 10px 5px;
        justify-content: space-evenly;
        position: relative;
        flex-direction: row-reverse;
        z-index: 100;

        & > div {
            width: 100%;
            display: flex;
            justify-content: space-between;
        }



        p {
            margin-top: auto;
            margin-bottom: auto;
        }
    }

    .product-item__btn {
        width: 35px;
        height: 35px;
        padding: 5px;
    }

    .product-item__empty-box {
        position: relative;
        /* top: 0; */
        /* left: 0; */
        display: flex;
        justify-content: flex-end;
        align-items: center;
        width: 100%;
        height: 55px;
        font-size: 12px;
        padding: 0px 10px 0px 10px;
        z-index: 11;
        box-sizing: border-box;

        .text-center {
            font-size: 14px;
            width: 100%;
            margin: 0;

            mark {
                background-color: #ffc107;
            }
        }

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

    .modal-content {
        bottom: 10px;
        position: fixed;
    }

    .modal-class {
        display: flex;
        align-items: flex-end;
        padding: 0px;
        margin: 0;
    }

    .content-class {
        border: none;
        border-top: 1px solid rgba(0, 0, 0, .2);
        border-radius: 0;
        margin-bottom: 40px;
    }
</style>
