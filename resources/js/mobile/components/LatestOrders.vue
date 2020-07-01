<template>
    <!-- listview -->
    <div class="listView detailed">
        <a href="#" class="listItem" v-for="order in orders">
            <div class="listItemContainer">
                <div class="image">
                    <img :src="order.restoran.logo" alt="avatar">
                </div>
                <div class="text">
                    <div>
                        <strong>Клиент {{order.receiver_name}}</strong>
                        <div class="text-muted">
                            Цена заказ {{order.summary_price| currency}}

                        </div>

                        <div class="text-muted">
                            Цена доставки {{order.delivery_price| currency}} ({{order.delivery_range}} км)

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
    <!-- * listview -->

</template>
<script>
    export default {
        data() {
            return {
                orders: []
            }
        },
        mounted() {
            this.loadLatesOrders()
        },
        methods: {
            loadLatesOrders() {
                axios.get('/api/v1/fastoran/order/latest').then(resp => {
                    this.orders = resp.data
                })

            }
        }

    }
</script>
<style lang="scss">
    .listItemContainer {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }

    .listItemContainer ~ ul {
        list-style: decimal;
        padding: 10px;
        color: black;

    }

    a.listItem {
        display: flex;
        flex-wrap: wrap;
    }

</style>
