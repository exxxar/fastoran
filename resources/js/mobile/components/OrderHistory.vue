<template>
    <div>
        <p v-if="counter">Историю заказов можно проверить через: {{counter}} секунд.</p>

        <form v-on:submit.prevent="refresh">

            <div class="form-group">
                <input type="text"
                       placeholder="Ваш номер телефона"
                       name="phone"
                       v-model="phone"
                       required="required"
                       pattern="[\+]\d{2} [\(]\d{3}[\)] \d{3}[\-]\d{2}[\-]\d{2}"
                       class="form-control"
                       maxlength="19"
                       v-mask="['+38 (###) ###-##-##']">
            </div>

            <div class="form-group">
                <button class="btn btn-outline-success mr-1 mb-1 w-100" :disabled="searching">
                    {{counter?"Обновить через "+counter+" сек.":"Узнать историю заказов"}}
                </button>
            </div>

        </form>


        <div class="listView detailed" v-if="this.orders.length>0">
            <a href="#" class="listItem" v-for="order in orders">
                <div class="listItemContainer">
                    <div class="image">
                        <img :src="order.restoran.logo" alt="avatar">
                    </div>
                    <div class="text">
                        <div>
                            <div class="text-muted">
                                Цена заказ {{order.summary_price| currency}}
                            </div>
                            <div class="text-muted">
                                Цена доставки {{order.delivery_price| currency}} ({{order.delivery_range}} км)
                            </div>
                            <div class="text-muted">
                                Заказано: {{order.created_at}} <i class="far fa-clock"></i>
                            </div>
                            <div class="text-muted">
                                Доставлено: {{order.updated_at}} <i class="far fa-clock"></i>
                            </div>
                        </div>

                    </div>
                </div>
                <ul>
                    <li v-for="product in order.details">{{product.product_details.food_name}}
                        {{product.product_details.food_price | currency}} x{{product.count}}
                    </li>
                </ul>
            </a>

        </div>

        <div class="row" v-if="this.orders.length>0">
            <div class="col-12">
                <button v-if="this.prev_page_url!=null" class="btn btn-outline-success w-100" @click="prev()" :disabled="searching">
                    {{counter?"Назад через "+counter+" сек.":"Предидушая страница"}}

                </button>
            </div>
            <div class="col-12">
                <button v-if="this.next_page_url!=null" class="btn btn-outline-success w-100" @click="next()" :disabled="searching">
                    {{counter?"Далее через "+counter+" сек.":"Следующая страница"}}
                </button>
            </div>
        </div>


    </div>
</template>

<script>
    import {mask} from 'vue-the-mask'

    export default {
        data() {
            return {
                current_page_url: null,
                phone: localStorage.getItem("phone", null) ?? null,
                orders: [],
                searching: false,
                counter: null,
                visible: false,
                first_page_url: null,
                next_page_url: null,
                prev_page_url: null,
            }
        },
        mounted() {
            if (localStorage.getItem("status_counter") != null) {
                this.searching = true;
                this.startTimer(localStorage.getItem("status_counter"))
            }


        },

        methods: {

            startTimer(time) {
                this.counter = time != null ? Math.min(time, 30) : 30;

                let counterId = setInterval(() => {
                        if (this.counter > 0)
                            this.counter--
                        else {
                            clearInterval(counterId)
                            this.searching = false
                            this.counter = null
                        }
                        localStorage.setItem("status_counter", this.counter)
                    }, 1000
                )
            },
            refresh(){
              this.current_page_url = '/api/v1/fastoran/order/history';
                this.findOrders();
            },
            prev() {
                this.current_page_url = this.prev_page_url
                this.findOrders();
            },
            next() {
                this.current_page_url = this.next_page_url
                this.findOrders();
            },
            findOrders() {
                this.searching = true;
                this.sendMessage("Выполняем поиск!")
                this.orders = [];

                axios.post(this.current_page_url, {
                    phone: this.phone
                }).then(resp => {
                     this.startTimer();
                    localStorage.setItem("phone", this.phone == null ? '' : this.phone);
                    this.orders = resp.data.data

                    this.first_page_url = resp.data.first_page_url
                    this.next_page_url = resp.data.next_page_url
                    this.prev_page_url = resp.data.prev_page_url

                    this.searching = false;
                })
            },
            sendMessage(message, type = 'success') {
                this.$notify({
                    group: 'info',
                    type: type,
                    title: 'Получение истории заказов Fastoran',
                    text: message
                });
            }
            ,
        },
        directives: {
            mask
        },
    }
</script>

<style lang="scss">


    .status-list {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        margin: 0;
        padding: 0;

        li {
            width: 100%;
            padding: 0px;
            display: flex;
            justify-content: space-between;

            p {
                text-align: right;
            }

            p.strong {
                font-weight: bold;
                text-align: left;
            }
        }
    }

    .listItemContainer {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }

    .listItemContainer ~ ul {
        list-style: decimal;
        padding: 10px 0px 10px 20px;
        color: black;
        width: 100%;
        word-break: break-all;
    }

    a.listItem {
        display: flex;
        flex-wrap: wrap;
    }
</style>
