<template>
    <div>
        <h4 class="text-center mt-2">Собираем вкусный<br>Бизнес-Ланч</h4>

        <h6 class="text-center mb-5">
            <mark>Цена ланча фиксирована - 150 руб!</mark>
        </h6>
        <div class="row justify-content-center">
            <div class="col-12 col-sm-12 col-md-4" v-for="fill in getFilling(23)">
                <div class="container-wrapper">
                    <label class="container text-left">
                        <label>{{fill.title}}
                            <span
                                class="badge">{{fill.price | currency}}</span>

                        </label>
                        <input v-if="fill.checked" checked="checked" type="checkbox" name="hot_dog_base_coating"
                               :disabled="fill.disabled||hasManyItems(fill.id)>1" v-model="base_lanch"
                               :value="fill.id">
                        <input v-else type="checkbox" name="hot_dog_base_coating"
                               :disabled="fill.disabled||hasManyItems(fill.id)>1"
                               v-model="base_lanch" :value="fill.id">
                        <span class="checkmark"></span>


                    </label>

                </div>

            </div>
        </div>

        <h3 class="text-left mt-2 mb-4">
            <mark>Выбираем салат</mark>
        </h3>

        <div class="row">
            <div class="col-12 col-sm-12 col-md-6" v-for="fill in getFilling(19)">

                <div class="container-wrapper">
                    <label class="container">{{fill.title}}<span
                        class="badge badge-weight">{{fill.weight}} гр.</span>
                        <input v-if="fill.checked" checked="checked" type="radio" name="fillings_1"
                               :disabled="fill.disabled||hasManyItems(fill.id)>1" v-model="fillings_1" :value="fill.id">
                        <input v-else type="radio" name="fillings_1" :value="fill.id"
                               :disabled="fill.disabled||hasManyItems(fill.id)>1"
                               v-model="fillings_1">
                        <span class="checkmark"></span>
                    </label>

                </div>


            </div>

        </div>


        <h3 class="text-left mt-2 mb-4">
            <mark>Первое блюдо</mark>
        </h3>

        <div class="row">
            <div class="col-12 col-sm-12 col-md-6" v-for="fill in getFilling(20)">

                <div class="container-wrapper">
                    <label class="container justify-between">{{fill.title}}<span
                        class="badge badge-weight">{{fill.weight}} гр.</span>
                        <input v-if="fill.checked" checked="checked" type="radio" name="fillings_2"
                               :disabled="fill.disabled||hasManyItems(fill.id)>1" v-model="fillings_2" :value="fill.id">
                        <input v-else type="radio" name="fillings_2" :value="fill.id"
                               :disabled="fill.disabled||hasManyItems(fill.id)>1"
                               v-model="fillings_2">
                        <span class="checkmark"></span>
                    </label>
                </div>


            </div>

        </div>


        <h3 class="text-left mt-2 mb-4">
            <mark>Выбираем гарнир</mark>
        </h3>

        <div class="row">
            <div class="col-12 col-sm-12 col-md-6" v-for="fill in getFilling(21)">

                <div class="container-wrapper">
                    <label class="container justify-between">{{fill.title}}<span
                        class="badge badge-weight">{{fill.weight}} гр.</span>
                        <input v-if="fill.checked" checked="checked" type="radio" name="fillings_3"
                               :disabled="fill.disabled||hasManyItems(fill.id)>1" v-model="fillings_3" :value="fill.id">
                        <input v-else type="radio" name="fillings_3" :value="fill.id"
                               :disabled="fill.disabled||hasManyItems(fill.id)>1"
                               v-model="fillings_3">
                        <span class="checkmark"></span>
                    </label>
                </div>


            </div>

        </div>

        <h3 class="text-left mt-2 mb-4">
            <mark>Выбираем напиток</mark>
        </h3>

        <div class="row">
            <div class="col-12 col-sm-12 col-md-6" v-for="fill in getFilling(22)">

                <div class="container-wrapper">
                    <label class="container justify-between">{{fill.title}}<span
                        class="badge badge-weight">{{fill.weight}} гр.</span>
                        <input v-if="fill.checked" checked="checked" type="radio" name="fillings_4"
                               :disabled="fill.disabled||hasManyItems(fill.id)>1" v-model="fillings_4" :value="fill.id">
                        <input v-else type="radio" name="fillings_4" :value="fill.id"
                               :disabled="fill.disabled||hasManyItems(fill.id)>1"
                               v-model="fillings_4">
                        <span class="checkmark"></span>
                    </label>
                </div>


            </div>

        </div>

        <hr>
        <div class="row d-flex justify-content-center result">
            <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                <h6 class="text-center">Сколько таких ланчей сделать?</h6>
                <div class="summary">
                    <div class="btn-counter" @click="decrementSummary">-</div>
                    <p>{{summary_count}}</p>
                    <div class="btn-counter" @click="incrementSummary">+</div>
                </div>
                <hr>

                <div class="d-flex justify-content-center">
                    <ul>
                        <li>Вес: <strong>{{summary_weight}} грамм</strong></li>
                        <li>Цена: <strong>{{summary_price}} руб</strong></li>
                    </ul>
                </div>

                <p class="text-center" v-if="message.length>0">
                    <mark class="text-white">{{message}}</mark>
                </p>
                <div class="d-flex justify-content-center flex-wrap">

                    <div class="col-12 col-sm-12 col-md-12 d-flex justify-content-center">
                        <button class="food__btn w-100 mt-2" :disabled="summary_count===0" @click="addToCart">
                            В корзину
                        </button>
                    </div>

                    <div class="col-12 col-sm-12 col-md-12 d-flex justify-content-center">
                        <button class="food__btn w-100 mt-2" @click="clearCalc">
                            Очистить
                        </button>
                    </div>

                </div>


            </div>
        </div>

    </div>
</template>
<script>
    export default {
        data() {
            return {
                cat: [19, 20, 21, 22, 23],
                timer: null,
                message: '',
                base_lanch: 150,
                summary_count: 0,
                summary_weight: 0,
                summary_price: 0,
                price: 0,
                weight: 0,
                fillings_1: 152,
                fillings_2: 155,
                fillings_3: 158,
                fillings_4: 161,
                fillings:[]
            }
        },
        watch: {
            fillings_1: function (newVal, oldVal) {
                if (oldVal)
                    this.removeItem(oldVal)
                if (newVal)
                    this.addItem(newVal)
            },
            fillings_2: function (newVal, oldVal) {
                if (oldVal)
                    this.removeItem(oldVal)
                if (newVal)
                    this.addItem(newVal)
            },
            fillings_3: function (newVal, oldVal) {
                if (oldVal)
                    this.removeItem(oldVal)
                if (newVal)
                    this.addItem(newVal)
            },
            fillings_4: function (newVal, oldVal) {
                if (oldVal)
                    this.removeItem(oldVal)
                if (newVal)
                    this.addItem(newVal)
            },

            base_lanch: function (newVal, oldVal) {
                if (oldVal)
                    this.removeItem(oldVal)
                if (newVal)
                    this.addItem(newVal)
            },
            summary_count: function (val) {
                this.summary_price = this.price * this.summary_count
                this.summary_weight = this.weight * this.summary_count
            },
            fillings: function (val) {
                window
                    .api
                    .watchForFillings(this, val)


            }
            ,
            products: function (newVal, oldVal) {
                return newVal
            },
        },
        computed: {
            products() {
                return this.$store.getters.cartProducts;
            }
        },
        mounted() {
            window
                .api
                .prepareCheckedItems(this, this.cat)
                .loadRestInfo(this, "svinya_pub_dn")

            let callback = (val, oldVal, uri) => {
                this.$store.dispatch("getProductList")
            }

            Vue.ls.on('store', callback) //watch change foo key and triggered callbac

            this.addItem(this.fillings_1)
            this.addItem(this.fillings_2)
            this.addItem(this.fillings_3)
            this.addItem(this.fillings_4)
        },
        methods: {
            addToCart() {
                window
                    .api
                    .addToCart(this, "Собранный бизнес-ланч")
            },
            clearCalc() {
                window
                    .api
                    .clearCalc(this)

                window
                    .api
                    .prepareCheckedItems(this, this.cat)
            },
            comingSoon() {
                this.message = "Данный сервис будет доступен в ближайшее время!"
                this.sendMessage(
                    "Сервис еще недоступен!"
                )
            },
            decrementSummary() {
                window
                    .api
                    .decrementSummary(this)
            },
            incrementSummary() {
                window
                    .api
                    .incrementSummary(this)
            },
            hasManyItems(id) {
                return window
                    .api
                    .hasManyItems(this, id)
            },
            removeItem(id) {
                window
                    .api
                    .removeItem(this, id)
            },
            addItem(id) {
                window
                    .api
                    .addItem(this, id)
            },
            getCategory(id) {
                return window
                    .api
                    .getCategory(this, id)
            },
            getFilling(type) {
                return window
                    .api
                    .getFilling(this, type)

            },
            sendMessage(message) {
                this.$notify({
                    group: 'info',
                    type: 'success',
                    title: 'Калькулятор вкусняшек Fastoran',
                    text: message
                });
            },


        }
    }
</script>
<style lang="scss" scoped>



    .hot-dog-calc .checkmark {
        position: absolute;
        height: 25px;
        width: 25px;
        background-color: #eee;
        position: absolute;
        left: 50%;
        top: -30px;
    }

    hr {
        width: 100%;
        height: 1px;
        /* background: darkred; */
        border-top: 1px darkred solid;
        margin-top: 5px;
        margin-bottom: 5px;
        padding: 10px;
        box-sizing: border-box;
    }


    h6,
    h2,
    h3 {
        mark {
            background: transparent;
            border-bottom:2px #d50c0d solid;
            //color: white;
        }
    }

    .container-wrapper {
        display: flex;
        justify-content: space-between;
    }

    .result {
        ul {
            width: 150px;

            li {
                width: 100%;
                display: flex;
                justify-content: space-between;

            }
        }

        .summary {
            width: 100%;
            display: flex;
            padding: 10px;
            justify-content: space-around;
            align-items: center;

            p {
                padding: 10px;
            }

            .btn-counter {
                width: 50px;
                height: 50px;
                display: flex;
                justify-content: center;
                align-items: center;
                background: darkorange;
                font-size: 20px;
                font-weight: bolder;
                color: #4e3d03;
            }
        }
    }

    .counter-wrapper {
        display: inline-block;

        .counter {
            display: flex;
            justify-content: space-between;
            width: 100px;
            padding: 5px;

            .btn-counter {
                width: 25px;
                height: 25px;
                background: darkorange;
                color: white;
                padding: 0px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
        }
    }
</style>
