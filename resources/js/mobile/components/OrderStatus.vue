<template>
    <div>
        <p v-if="counter">Статус заказа можно проверить через: {{counter}} секунд.</p>
        <form v-on:submit.prevent="findOrder">

                <div class="form-group">
                    <input type="number" class="form-control"
                           placeholder="Номер заказа"
                           v-model="order_id" pattern="\d{1,11}"
                           max="99999999" min="0"
                           required>
                </div>

                <div class="form-group">
                    <button class="btn btn-outline-success mr-1 mb-1 w-100" :disabled="searching">
                        {{counter?counter+" сек.":"Узнать статус"}}
                    </button>
                </div>

        </form>

        <div v-if="this.order">
            <div class="map-section" v-if="coords_client.length>0&&coords_deliveryman.length>0">
                <yandex-map
                    :coords="coords_deliveryman"
                    zoom=15
                >
                    <ymap-marker
                        :coords="coords_client"
                        :icon="markerClientIcon"
                        marker-id="123124"
                    />
                    <ymap-marker
                        :coords="coords_deliveryman"
                        :icon="markerDeliverymanIcon"
                        marker-id="123123"
                        @click="testMarker"
                        hint-content="Ваш доставщик уже в пути!"
                    />
                </yandex-map>
            </div>

            <ul class="status-list" v-if="order!=null">
                <li v-if="order.rest_id!=null"><p class="strong">Заказ из: {{order.restoran.name}}</p>
                <li><p class="strong">Статус заказа:</p>
                    <p>{{order.status_text}}</p></li>
                <li><p class="strong">Будет доставлено в:</p>
                    <p>{{order.delivered_time}}</p></li>
                <li><p class="strong">Цена заказа:</p>
                    <p>{{order.summary_price}} руб.</p></li>
                <li><p class="strong">Цена доставки:</p>
                    <p>{{order.delivery_price}} руб.</p></li>
                <li><p class="strong">Заказ принят в обработку в:</p>
                    <p>{{order.created_at}}</p></li>
                <li><p class="strong">Последнее изменение статуса:</p>
                    <p>{{order.updated_at}}</p></li>
            </ul>

        </div>


    </div>
</template>

<script>
    import {mask} from 'vue-the-mask'
    import {yandexMap, ymapMarker} from 'vue-yandex-maps'

    export default {
        data() {
            return {
                order_id: localStorage.getItem("last_order_id") == null ? '' : localStorage.getItem("last_order_id"),
                order: null,
                searching: false,
                counter: null,
                coords_client: [],
                visible: false,
                map_updater: null,
                coords_deliveryman: [],
                settings: {
                    apiKey: 'c3ddaef1-2a3e-4aea-bd55-698a8735fc7d',
                    lang: 'ru_RU',
                    coordorder: 'latlong',
                    version: '2.1'
                },
                markerDeliverymanIcon: {
                    layout: 'default#imageWithContent',
                    imageHref: '../img/icons/deliveryman.png',
                    imageSize: [43, 43],
                    imageOffset: [0, -25],
                    contentOffset: [0, 15],
                },
                markerClientIcon: {
                    layout: 'default#imageWithContent',
                    imageHref: '../img/icons/client.png',
                    imageSize: [43, 43],
                    imageOffset: [0, -25],
                    contentOffset: [0, 15],
                }
            }
        },
        mounted() {
            if (localStorage.getItem("status_counter") != null) {
                this.searching = true;
                this.startTimer(localStorage.getItem("status_counter"))
            }


        },
        watch: {
            visible: function (newVal, oldVal) {
                if (this.visible && this.order_id != null && coords_client.length > 0 && coords_deliveryman.length > 0) {
                    this.map_updater = setInterval(() => this.findOrder(), 15000)
                } else
                    clearInterval(this.map_updater)
            }
        },
        methods: {
            testMarker() {
                console.log("жду тебя, ждууу!")
            },
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
            findOrder() {
                this.searching = true;
                this.sendMessage("Выполняем поиск заказа!")
                this.order = null;
                //todo: подключить Pusher
                axios
                    .get("../api/v1/fastoran/orders/" + this.order_id)
                    .then(resp => {
                            this.startTimer();

                            if (resp.data.order == null) {
                                this.sendMessage("Данный заказ не найден в системе!", 'error')
                                return;
                            }

                            this.order = resp.data.order

                            if (this.order.latitude != null && this.order.longitude != null)
                                this.coords_client = [
                                    this.order.latitude, this.order.longitude
                                ];

                            if (this.order.deliveryman_latitude != null && this.order.deliveryman_longitude != null)
                                this.coords_deliveryman = [
                                    this.order.deliveryman_latitude, this.order.deliveryman_longitude
                                ];

                            localStorage.setItem("last_order_id", this.order_id)

                        }
                    )
            },
            sendMessage(message, type = 'success') {
                this.$notify({
                    group: 'info',
                    type: type,
                    title: 'Проверка заказа Fastoran',
                    text: message
                });
            }
            ,
        },
        directives: {
            mask
        },
        components: {yandexMap, ymapMarker}
    }
</script>

<style lang="scss">

    .map-section {
        width: 100%;
        height: 350px;
    }

    #result-modal {
        .modal-content {
            border-radius: 0;

            .modal-header {
                background: #d50c0d;
                border-radius: 0;
                color: white;
            }
        }
    }


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
                text-align:right;
            }
            p.strong {
                font-weight: bold;
                text-align:left;
            }
        }
    }

    .ymap-container {
        height: 100%;
    }
</style>
