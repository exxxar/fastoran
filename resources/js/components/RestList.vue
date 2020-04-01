<template>
    <div class="l-rest-list">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <button type="button" class="btn btn-warning btn-filtres hidden-sm hidden-md hidden-lg">Фильтры и
                        сортировка
                    </button>
                    <div class="l-rest-list__filtres fixed-xs-hidden">
                        <a href="#" class="close-filter hidden-sm hidden-md hidden-lg"><img src="/img/close-filter.png"
                                                                                            alt=""></a>
                        <div class="l-rest-list__filtres--section">
                            <h4 class="text-uppercase">Направление кухни</h4>
                            <ul class="kitchen">
                                <li v-for="kitchen in kitchens">
                                    <input type="checkbox" v-model="filter.kitchens" class="rest-filter"
                                           :value="kitchen.id"
                                           :id="'kitchen'+kitchen.id"
                                    ><label :for="'kitchen'+kitchen.id">{{kitchen.name}}</label>
                                </li>
                            </ul>
                        </div>
                        <!--     <div class="l-rest-list__filtres--section">
                                 <h4 class="text-uppercase">Критерии</h4>
                                 <ul class="criterion">
                                     <li><input type="checkbox" class="rest-filter" id="9"><label for="9">Бесплатная
                                         доставка</label></li>
                                     <li><input type="checkbox" class="rest-filter" id="11"><label for="11">Акционные
                                         блюда</label></li>
                                     <li><input type="checkbox" class="rest-filter" id="12"><label for="12">Бонусные
                                         блюда</label></li>
                                 </ul>
                             </div>-->
                        <div class="l-rest-list__filtres--section">
                            <h4 class="text-uppercase">Район доставки</h4>
                            <ul class="region">
                                <li v-for="region in regions"><input type="checkbox"
                                                                     class="rest-filter"
                                                                     :id="'region'+region.id"><label
                                    :for="'region'+region.id">{{region.name}}</label>
                                </li>
                            </ul>
                        </div>

                        <div class="event-filtres">
                            <!--<div>
                                <button type="button"
                                        class="btn btn-warning text-uppercase hidden-sm hidden-md hidden-lg">
                                    Применить
                                </button>
                            </div>-->
                            <div>
                                <button type="button" @click="clearFilters()"
                                        class="btn btn-warning text-uppercase reset-filtres hidden-sm hidden-md hidden-lg">
                                    очистить
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="l-rest-list__container">
                        <h4 class="text-uppercase hidden-xs">заказ и доставка еды из ресторанов донецка</h4>
                        <ul class="item-list" id="item-list">
                            <li v-for="restoran in getFilteredRestorans()">
                                <a :href="`/rest/${restoran.url}`" class="l-rest-list__container--item"
                                   :id="restoran.id">
                                    <div class="top-shadow"></div>

                                    <div class="l-rest-list__container--item__media">
                                        <img :src="restoran.logo" :alt="restoran.seo_description">
                                    </div>
                                    <div class="l-rest-list__container--item__content">
                                        <div class="l-rest-list__container--item__content__header">
                                            <h4 class="text-uppercase">{{restoran.name}}</h4>
                                            <ul class="kitchen-list">
                                                <li v-for="kitchen in restoran.kitchen">{{kitchen.name}}</li>
                                            </ul>
                                        </div>
                                        <div class="l-rest-list__container--item__content__body">
                                            <div>
                                                <h4>{{restoran.min_sum}}</h4>
                                                <p>Мин сумма заказа</p>
                                            </div>
                                            <div class="clear"></div>
                                            <div>
                                                <h4>{{restoran.tarif}}</h4>
                                                <p>Cтоимость доставки</p>
                                            </div>
                                            <div class="clear"></div>
                                            <div class="hidden-xs hide_m">
                                                <h4>{{restoran.time_delivery}}</h4>
                                                <p>время <br> доставки</p>
                                            </div>
                                            <div class="hidden-xs hide_m">
                                                <div>
                                                    <div class="like-container" data-target="197">
                                                        <div>
                                                            <i class="far fa-thumbs-up"></i>
                                                        </div>
                                                        <div>
                                                            <h4>{{restoran.rest_like}}</h4>
                                                        </div>
                                                    </div>
                                                    <div class="disslike-container" data-target="197">
                                                        <div>
                                                            <i class="far fa-thumbs-down"></i>
                                                        </div>
                                                        <div>
                                                            <h4>{{restoran.rest_antilike}}</h4>
                                                        </div>
                                                    </div>
                                                </div>
                                                <p class="reviews">{{restoran.comments}} отзывов</p>
                                            </div>
                                        </div>
                                        <div class="delivery-info">
                                            <p>{{restoran.remark}}</p>
                                        </div>
                                    </div>


                                    <div class="bottom-shadow"></div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["kitchen"],
        data() {
            return {
                filter: {
                    regions: [],
                    kitchens: []
                },
                restorans: [],
                kitchens: [],
                regions: [],

            }
        },
        mounted() {
            this.loadData()
            if (this.kitchen)
                this.filter.kitchens.push(this.kitchen)
        },
        methods: {
            loadData() {
                axios
                    .get('/restorans')
                    .then((resp) => {
                        this.restorans = resp.data.restorans.data;
                  /*      this.kitchens = resp.data.kitchens;
                        this.regions = resp.data.regions;*/
                    });
            },
            getFilteredRestorans() {

                let tmp = this.restorans;

                if (this.filter.regions.length > 0)
                    tmp = tmp.filter(item => this.filter.regions.includes(item.region_id));

                if (this.filter.kitchens.length > 0)
                    tmp = tmp.filter(item => {
                        let intersection = item.kitchens.filter(x => this.filter.kitchens.includes(x.id));
                        return intersection.length > 0
                    });


                return tmp;
            },
            clearFilters() {
                this.filter.region = null;
                this.filter.kitchen = null;
            }
        }
    }
</script>
