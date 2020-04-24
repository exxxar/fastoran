<template>
    <div>
        <p v-if="counter">Статус заказа можно проверить через: {{counter}} секунд.</p>

        <form v-on:submit.prevent="findOrder">
            <div class="row">
                <div class="col-12 col-sm-8 mt-2">
                    <input type="number" class="res__search"
                           placeholder="Номер заказа"
                           v-model="order_id" pattern="\d{1,11}"
                           max="99999999" min="0"
                           required>
                </div>

                <div class="col-12 col-sm-4 mt-2">
                    <button class="btn search-btn" :disabled="searching">
                        {{counter?counter+" сек.":"Узнать статус"}}
                    </button>
                </div>

            </div>
        </form>

        <b-modal id="result-modal" class="test" hide-footer title="Проверка заказа">

            <div class="d-block text-center ">

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


                <div class="loader" v-else>
                    <img src="img/ajax-loader.gif" alt="">
                </div>
            </div>
        </b-modal>
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

                axios
                    .get("../api/v1/fastoran/orders/" + this.order_id)
                    .then(resp => {
                            this.startTimer();

                            if (resp.data.order == null) {
                                this.sendMessage("Данный заказ не найден в системе!", 'error')
                                return;
                            }
                            this.$bvModal.show("result-modal")
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

    .loader {
        width: 100%;
        height: 100%;

        display: flex;
        justify-content: center;
        align-items: center;

        img {
            width: 50px;
            height: 50px;
            object-fit: contain;
        }
    }

    .search-btn {
        height: 100%;
        width: 100%;
        background: #d50c0d;
        border: none;

        color: white;
        text-transform: uppercase;
        font-weight: 700;
        line-height: 100%;

        max-width: 300px;
        min-height: 50px;

        &[disabled] {
            background: darkgray;
        }

        &:focus,
        &:active,
        &:hover {
            background: #7D0017;
        }
    }

    .test {
        background: red;
    }

    .status-list {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;

        li {
            width: 100%;
            padding: 10px;
            display: flex;
            justify-content: space-between;

            p.strong {
                font-weight: bold;
            }
        }
    }

    .ymap-container {
        height: 100%;
    }
</style>
