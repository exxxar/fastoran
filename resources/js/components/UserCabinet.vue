<template>
    <section class="user-cabinet">
        <div class="container">
            <login-form v-on:access_token="loadHistory" v-if="access_token==null"></login-form>

            <div class="row" v-if="access_token&&orders">
                <div class="col-sm-12 col-md-6 mt-2" v-for="order in orders">
                    <div class="card" style="width:100%">
                        <!-- <img class="card-img-top" :src="order.restoran.logo" :alt="order.restoran.name">-->
                        <div class="card-body">
                            <ul class="order-info" v-if="order!=null">
                                <li v-if="order.rest_id!=null"><p class="strong">Заказ из: {{order.restoran.name}}</p>
                                <li><p class="strong">Адрес доставки:</p>
                                    <p>{{order.receiver_address}}</p></li>
                                <li><p class="strong">Статус заказа:</p>
                                    <p>{{order.status_text}}</p></li>
                                <li><p class="strong">Цена заказа:</p>
                                    <p>{{order.summary_price}} руб.</p></li>
                                <li><p class="strong">Цена доставки:</p>
                                    <p>{{order.delivery_price}} руб.</p></li>
                                <li><p class="strong">Заказ принят в обработку в:</p>
                                    <p>{{order.created_at}}</p></li>
                                <li><p class="strong">Последнее изменение статуса:</p>
                                    <p>{{order.updated_at}}</p></li>
                            </ul>


                            <button class="btn btn-food text-white" type="button" data-toggle="collapse"
                                    :data-target="'#order'+order.id" aria-expanded="false"
                                    :aria-controls="'order'+order.id">
                                Детали заказа
                            </button>

                            <div class="collapse mt-2" :id="'order'+order.id">
                                <div class="card card-body">
                                    <ul>
                                        <li class="product-list-item" v-for="product in order.details" v-if="product.product_details">
                                            <p>{{product.product_details.food_name}}</p>
                                            <p>Цена: {{product.price}} руб.</p>
                                            <p>Количество: {{product.count}} шт</p>
                                            <hr>
                                        </li>

                                    </ul>
                                    <ul>

                                    </ul>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</template>
<script>
    export default {
        data() {
            return {
                access_token: null,
                orders: null
            }
        },
        methods: {
            loadHistory(event) {
                this.access_token = event;

                if (this.access_token == null)
                    return;

                axios.defaults.headers.common = {
                    'Authorization': `Bearer ${this.access_token}`,
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
                axios
                    .post('../api/v1/fastoran/history')
                    .then(resp => {
                        console.log(resp.data);
                        this.orders = resp.data.orders
                    })
            }
        }
    }
</script>
<style lang="scss" scoped>
    .user-cabinet {
        padding: 20px;
        box-sizing: border-box;
    }

    .order-info {
        li {
            width: 100%;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            font-size: 10px;
        }
    }

    .product-list-item {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        padding: 10px;
        border-bottom: 1px solid #ebebeb;
    }
</style>
