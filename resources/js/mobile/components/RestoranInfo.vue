<template>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{restoran.name}}</h5>


            <figure>
                <img :src="restoran.logo" alt="image" class="imageBlock img-fluid">
                <figcaption class="text-center">
                    Наше время работы: {{restoran.work_time}}
                </figcaption>
            </figure>

            <div class="accordion" id="accordionExample">
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                    data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                Описание
                                <i class="arrow icon ion-ios-arrow-down"></i>
                            </button>
                        </h2>
                    </div>

                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample"
                         style="">
                        <div class="card-body">
                            <p class="text-justify">{{restoran.description}}</p>
                            <ul>
                                <li>Минимальная сумма доставки: {{restoran.min_sum}} руб.</li>
                                <li>Цена доставки от: {{restoran.price_delivery}} руб.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                    data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Наше расположение
                                <i class="arrow icon ion-ios-arrow-down"></i>
                            </button>
                        </h2>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample"
                         style="">
                        <div class="card-body">
                            <div class="map-section">
                                <yandex-map
                                    :coords="coords_restoran"
                                    zoom=15
                                >
                                    <ymap-marker
                                        :coords="coords_restoran"
                                        :icon="markerRestoranIcon"
                                        marker-id="123124"
                                    />
                                </yandex-map>
                            </div>
                            <p>{{restoran.adress}}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
    import {yandexMap, ymapMarker} from 'vue-yandex-maps'

    export default {
        props: ["restoran"],
        data() {
            return {
                coords_restoran: [
                    this.restoran.latitude, this.restoran.longitude
                ],
                settings: {
                    apiKey: 'c3ddaef1-2a3e-4aea-bd55-698a8735fc7d',
                    lang: 'ru_RU',
                    coordorder: 'latlong',
                    version: '2.1'
                },
                markerRestoranIcon: {
                    layout: 'default#imageWithContent',
                    imageHref: this.restoran.logo,
                    imageSize: [43, 43],
                    imageOffset: [0, -25],
                    contentOffset: [0, 15],
                },
            }
        },
        components: {yandexMap, ymapMarker}
    }
</script>

<style lang="scss" scoped>
    .map-section {
        width: 100%;
        height: 350px;
    }

    figure {
        border: 1px #fcb414 solid;
        figcaption {
            background: #fcb414;
            border-radius: 0;
            color: black;
            font-weight: 600;
            text-transform: uppercase;
            margin: 0;
        }
    }
</style>
