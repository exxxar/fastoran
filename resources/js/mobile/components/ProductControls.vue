<template>
    <div>

        <div class="product-item__controls" v-if="product.rest_info.is_work" >
            <button type="button" @click="addToCart()" class="btn btn-outline-success product-item__btn" v-if="inCart()===0&&!hasSub()"><i
                class="fas fa-cart-plus"></i></button>

            <button type="button"  @click="openSubMenu()"  class="btn btn-outline-success product-item__btn"
                    v-if="inCart()===0&&hasSub()"><i class="fas fa-cart-plus"></i></button>

            <button type="button"
                    class="btn btn-outline-info product-item__btn" @click="showInfoModal"
                    v-if="inCart()===0" :id="'menu'+product.id" ><i
                class="fas fa-info-circle"></i></button>


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


        <div class="product-item__empty-box" v-if="!product.rest_info.is_work">
            <p class="text-center">
                <mark class="color&#45;&#45;white">Время работы:
                    <strong>{{product.rest_info.work_time}}</strong>
                </mark>
            </p>
        </div>

        <b-modal :id="'modal-info-'+product.id" hide-footer centered hide-backdrop no-stacking dialog-class="modal-class" content-class="content-class">

            <template v-slot:modal-title>
                <h5>Информация о товаре</h5>
            </template>
            <div class="d-block text-center">


                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A accusamus accusantium aspernatur, consequatur dicta doloremque fuga ipsa iusto maxime minus molestiae nulla officiis pariatur perspiciatis quisquam recusandae sit veniam vero.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A accusamus accusantium aspernatur, consequatur dicta doloremque fuga ipsa iusto maxime minus molestiae nulla officiis pariatur perspiciatis quisquam recusandae sit veniam vero.</p>


            </div>
            <b-button class="mt-3 btn btn-primary" >Добавить
            </b-button>


        </b-modal>

        <div v-if="product.id!=null">
            <b-modal :id="'modal-submenu-'+product.id" hide-footer no-stacking >

                <template v-slot:modal-title>
                    <h3>Выбор подкатегории</h3>
                </template>
                <div class="d-block text-center">


                    <b-form-checkbox-group :id="'modal-submenu-check-'+product.id" v-model="selected" name="flavour-2">

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
    </div>
</template>

<script>
    export default {
        props: ["product"],
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
            showInfoModal(){
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
            inCart() {
                let tmp = this.products.filter(item => item.product.id === this.product.id);
                return tmp.length === 0 ? 0 : tmp[0].quantity
            },
            openSubMenu() {
                this.$bvModal.show("modal-submenu-" + this.product.id)
            },
            addToCart() {
               /* if (!this.checkFirstRestoran(this.product.rest_id)) {
                    this.sendMessage("Возможно одновременно заказать только из одного заведения!", 'error')
                    return;
                }*/
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


    .product-item__controls {
        width: 100%;
        display: flex;
        padding: 10px;
        justify-content: space-between;
        position: relative;
        flex-direction: row-reverse;
        z-index: 100;

        & > div {
            width: 100%;
            display: flex;
            justify-content: space-between;
        }

        .product-item__btn {
            width: 50px;
            height: 50px;
        }

        p {
            margin-top: auto;
            margin-bottom: auto;
        }
    }

    .product-item__empty-box {
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
        margin-bottom: 60px;
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
