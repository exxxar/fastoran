<template>
    <div class="l-rest-info">
        <div class="container">
            <div class="l-rest-info__container">
                <div class="row flex-row align-center">
                    <div class="col-md-3 col-sm-4 col-xs-4">
                        <div class="l-rest-info__container--media">
                            <img :src="rest.logo" alt="">
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-8 col-xs-8">
                        <div class="l-rest-info__container--content flex-column justify-start">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="l-rest-info__container--content__title">
                                        <h2 class="text-uppercase">{{rest.name}}</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="l-rest-info-wrapper">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="l-rest-info__container--content__info">
                                            <div class="hidden-xs">
                                                <p>Специализация:</p>

                                            </div>
                                            <div>
                                                <p>{{rest.speicalization}}</p>

                                            </div>
                                        </div>
                                        <div class="l-rest-info__container--content__info">
                                            <div class="hidden-xs">
                                                <p>Время приёма заказов:</p>
                                            </div>
                                            <div>
                                                <p>{{rest.work_time}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="l-rest-info__container--content__info">
                                            <div class="hidden-xs">
                                                <p>Адрес:</p>
                                            </div>
                                            <div>
                                                <p>{{rest.adress}}</p>
                                            </div>
                                        </div>
                                       <!-- <div class="l-rest-info__container&#45;&#45;content__info">
                                            <div class="hidden-xs">
                                                <p>Контактный телефон:</p>
                                            </div>
                                            <div>
                                                <p>{{rest.phone1}}</p>
                                            </div>
                                        </div>-->
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="l-rest-list__container--item__content__body1">
                                        <div>
                                            <h4 class="white-xs">{{rest.min_sum}}</h4>
                                            <p class="white-xs">мин сумма <br>заказа</p>
                                        </div>
                                        <div>
                                            <h4 class="white-xs">{{rest.price_delivery}} руб *</h4>
                                            <p class="white-xs">мин стоимость <br>доставки</p>
                                        </div>
                                        <div>
                                            <h4 class="white-xs">{{rest.work_time}}</h4>
                                            <p class="white-xs">время <br> доставки</p>
                                        </div>
                                    <!--    <div>
                                            <div>
                                                <div class="like-container" data-target="197">
                                                    <div @click="like">
                                                        <img src="/img/svg/like.svg" alt="" class="hidden-xs">

                                                    </div>
                                                    <div>
                                                        <h4 class="white-xs">{{rest.rating.like_count}}</h4>
                                                    </div>
                                                </div>
                                                <div class="disslike-container" data-target="197">
                                                    <div @click="dislike">
                                                        <img src="/img/svg/disslike.svg" alt="" class="hidden-xs">

                                                    </div>
                                                    <div>
                                                        <h4 class="white-xs">{{rest.rating.dislike_count}}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="reviews"><a href="#">{{rest.comments_count}} отзывов</a></p>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props:["rest"],
        data(){
            return {

            }
        },
        methods:{
            like(){
                this.rest.rest_like++;
                axios
                .get('/api/v1/fastoran/restorans/like/'+this.rest.id);
            },
            dislike(){
                this.rest.rest_antilike++;
                axios
                    .get('/api/v1/fastoran/restorans/dislike/'+this.rest.id);
            }


        }
    }
</script>
