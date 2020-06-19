<template>
    <div>
        <h1 class="text-center">Блинчики соленые</h1>
        <h2 class="text-center mt-5 mb-5">
            <mark>Основа блинчика</mark>
        </h2>
        <div class="row mt-4">
            <div class="col-12 col-sm-12 col-md-6" v-for="fill in getFilling(7)">
                <div class="container-wrapper">
                    <label class="container">{{fill.title}}<span
                        class="badge badge-weight">{{fill.weight}} гр.</span><span
                        class="badge">{{fill.price | currency}}</span>

                        <input v-if="fill.checked" checked="checked" type="checkbox" name="filling"
                               :disabled="fill.disabled||hasManyItems(fill.id)>1" v-model="fillings" :value="fill.id">
                        <input v-else type="checkbox" name="filling" :value="fill.id"
                               :disabled="fill.disabled||hasManyItems(fill.id)>1"
                               v-model="fillings">
                        <span class="checkmark"></span>
                    </label>

                    <div v-if="!fill.disabled">
                        <div class="counter-wrapper" v-if="hasManyItems(fill.id)>0">
                            <div class="counter">
                                <button class="btn btn-counter" @click="removeItem(fill.id)">-</button>
                                <p>{{hasManyItems(fill.id)}}</p>
                                <button class="btn btn-counter" @click="addItem(fill.id)">+</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <hr>
        <div class="row d-flex justify-content-center result">
            <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                <h3 class="text-center">Сколько таких блинчиков сделать?</h3>
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

                <p class="text-center  mt-4" v-if="message.length>0"><mark class="text-white">{{message}}</mark></p>
                <div class="d-flex justify-content-center flex-wrap mt-4">

                    <div class="col-12 col-sm-6 col-md-6 d-flex justify-content-center">
                        <button class="food__btn w-100 mt-2" :disabled="summary_count===0" @click="addToCart">
                            В корзину
                        </button>
                    </div>

                    <div class="col-12 col-sm-6 col-md-6 d-flex justify-content-center">
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
                timer: null,
                message:'',
                summary_count: 0,
                summary_weight: 0,
                summary_price: 0,
                price: 0,
                weight: 0,
                fillings: []
            }
        },
        watch: {
            summary_count: function (val) {
                this.summary_price = this.price * this.summary_count
                this.summary_weight = this.weight * this.summary_count
            },
            fillings: function (val) {
                window
                    .api
                    .watchForFillings(this, val)


            },
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
                .prepareCheckedItems(this, [7])
                .loadRestInfo(this, "chelentano_dn")
        },
        methods: {
            clearCalc() {
                window
                    .api
                    .clearCalc(this)

                window
                    .api
                    .prepareCheckedItems(this, [7])
            },
            addToCart() {
                window
                    .api
                    .addToCart(this,"Собранный соленый блинчик")
            },
            comingSoon(){
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
    hr {
        width: 100%;
        height: 1px;
        /* background: darkred; */
        border-top: 1px darkred solid;
        margin-top: 10px;
        margin-bottom: 10px;
        padding: 10px;
    }


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
