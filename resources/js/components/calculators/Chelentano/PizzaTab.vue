<template>
    <div>
        <h1 class="text-center mt-4 mb-4">Собираем вкусную пиццу</h1>
        <h2 class="text-center">
            <mark>Выбираем основу пиццы...</mark>
        </h2>
        <div class="row mt-4 mb-4">
            <div class="col-12 col-sm-12 col-md-6" v-for="fill in getFilling(8)">
                <div class="container-wrapper">
                    <label class="container">{{fill.title}}<span
                        class="badge badge-weight">{{fill.weight}} гр.</span><span
                        class="badge">{{fill.price | currency}}</span>


                        <input v-if="fill.checked" checked="checked" type="radio" name="pizza_base"
                               :disabled="fill.disabled||hasManyItems(fill.id)>1" v-model="pizza_base"  :value="fill.id">
                        <input v-else type="radio" name="pizza_base"
                               :disabled="fill.disabled||hasManyItems(fill.id)>1"
                               v-model="pizza_base"  :value="fill.id">
                        <span class="checkmark"></span>


                    </label>

                </div>

            </div>
        </div>
        <hr>
        <h2 class="text-center">
            <mark>А теперь выбираем начинку пиццы...</mark>
        </h2>

        <div class="row mt-4">
            <div class="col-12 col-sm-12 col-md-6">
                <h3 class="text-left mb-4">
                    <mark>{{getCategory(1).title}}</mark>
                </h3>
                <div class="container-wrapper" v-for="fill in getFilling(1)">
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
            <div class="col-12 col-sm-12 col-md-6">
                <h3 class="text-left mb-4">
                    <mark>{{getCategory(2).title}}</mark>
                </h3>
                <div class="container-wrapper" v-for="fill in getFilling(2)">
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

                <h3 class="text-left mb-4 mt-4">
                    <mark>{{getCategory(3).title}}</mark>
                </h3>
                <div class="container-wrapper" v-for="fill in getFilling(3)">
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
        <h3 class="text-left mb-4 mt-4">
            <mark>{{getCategory(4).title}}</mark>
        </h3>
        <div class="row mt-4">
            <div class="col-12 col-sm-12 col-md-6" v-for="fill in getFilling(4)">
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
            <div class="col-4">
                <h3 class="text-center">Сколько таких пицц сделать сделать?</h3>
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
                <div class="d-flex justify-content-center mt-4">

                    <button class="food__btn" :disabled="summary_count===0" @click="comingSoon">
                        Добавить в корзину
                    </button>
                </div>


            </div>
        </div>

    </div>
</template>
<script>
    export default {
        data() {
            return {
                message:'',
                pizza_base: 59,
                summary_count: 0,
                summary_weight: 0,
                summary_price: 0,
                price: 0,
                weight: 0,
                fillings: []
            }
        },
        watch: {
            pizza_base: function (newVal, oldVal) {
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
                console.log(val)
                window
                    .api
                    .watchForFillings(this, val)


            }
        },
        mounted() {
            window
                .api
                .prepareCheckedItems(this, [1, 2, 3, 4, 8])

        },
        methods: {
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
            color: white;
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
