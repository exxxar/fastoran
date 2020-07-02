<template>
    <div class="product-item">
        <div class="product-item__thumb">
            <a @click="showInfoModal"><img
                class="lazyload" :data-src="product.food_img"
                alt="banner images"></a>
        </div>

        <mobile-product-controls :product="product"></mobile-product-controls>


        <h4 class="product-item__h4">
            {{product.food_price}}₽
        </h4>
        <div class="product-item__rest-img">
            <a :href="'../mobile-restoran/'+product.rest_info.url">
                <img class="lazyload" :data-src="product.rest_info.logo" alt="">
            </a>
        </div>
        <div class="product-item__hover__action product-item__left__bottom">
            <div class="product-item__hover__inner">

                <h2 class="pink-text">
                    <mark>{{product.food_name}}</mark>
                </h2>

            </div>
        </div>

        <b-modal :id="'modal-info-'+product.id" hide-footer centered hide-backdrop no-stacking
                 dialog-class="modal-class" content-class="content-class">

            <template v-slot:modal-title>
                <h5>Информация о товаре</h5>
            </template>
            <div class="d-block text-center">
                <p>{{product.food_name}}</p>
                <p>{{product.food_remark}}</p>
            </div>
            <b-button class="mt-3 btn btn-primary">Добавить
            </b-button>


        </b-modal>
    </div>
</template>

<script>
    export default {
        props: ["product"],
        methods: {
            showInfoModal() {
                this.$bvModal.show("modal-info-" + this.product.id)
            },
        }
    }
</script>
<style lang="scss" scoped>
    .product-item {
        margin-top: 10px;
        position: relative;
        background: white;
        box-sizing: border-box;
        border-radius: 5px;
        border: 1px lightgray solid;


        &[data-promo] {
            background: #fbc01c;
        }

        &[data-promo]:after {
            content: attr(data-promo);
            position: absolute;
            z-index: 1;
            top: 0;
            right: 0;
            padding: 5px;
            font-weight: 900;
            font-size: 12px;
            letter-spacing: 2px;
            color: #ffffff;
            width: 100%;
            text-align: center;
            text-transform: uppercase;
            background: #fbc01c;
            font-family: Alegreya, serif;
            border-radius: 5px 5px 0px 0px;


        }


        .product-item__thumb {
            width: 100%;
            height: 100%;
            display: flex;
            min-height: 160px;
            justify-content: center;
            align-items: center;
            background: transparent;
            // border: 1px dashed #fff;

            a {
                display: block;
                overflow: hidden;

                img {
                    width: 100%;
                    border-radius: 5px 5px 0px 0px;
                }
            }
        }

        .product-item__hover__action {
            position: absolute;
            text-align: center;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            z-index: 9;

            &.product-item__left__bottom {
                position: absolute;
                width: 100%;
                height: 100%;
                display: flex;
                text-align: left;
                transform: translate(0);
                /* width: auto; */
                justify-content: center;
                align-items: flex-end;
                top: 0;
                left: 0;
                padding: 0px 10px 57px 10px;

            }

            &.product-item__left__top {
                left: 30px;
                text-align: left;
                top: 30px;
                transform: translate(0px);
                width: auto;
            }

            &.product-item__right__bottom {
                bottom: 30px;
                left: auto;
                right: 30px;
                top: auto;
                transform: translateY(0px);
                width: auto;
            }

            .product-item__hover__inner {
                h4 {
                    color: #fff;
                    font-size: 36px;
                    font-style: italic;
                    font-weight: 400;
                    line-height: 100%;
                    margin-bottom: 15px;
                    text-transform: uppercase;

                    mark {
                        background: #d12e2c;
                        color: #fff;
                        padding: 5px;
                        margin: 0;
                        border-radius: 0px 20px;
                    }
                }

                h2 {

                    font-size: 10px;
                    font-weight: 900;
                    text-transform: capitalize;
                    color: #fff;
                    /* text-shadow: 2px 2px 2px black;*/
                    &.pink-text {
                        color: #ffd84a;
                        text-transform: uppercase;
                        text-align: center;


                        mark {
                            background: #d12e2c;
                            color: #fff;
                            padding: 0;
                            margin: 0;
                        }
                    }
                }

                p {
                    color: #444444;
                    font-size: 14px;
                    font-weight: 700;
                    margin-top: 3px;
                }

                span {
                    color: #444444;
                    display: inline-block;
                    font-size: 40px;
                    font-weight: 700;
                }
            }
        }
    }

    .product-item__h4 {
        position: absolute;
        top: 0px;
        left: 0px;
        z-index: 10;
        padding: 10px;
        background: red;
        color: white;
        font-size: 12px;
        border-radius: 5px 0px 5px 0px;

        mark {
            background: #d50c0d;
            color: #fff;
            padding: 5px;
            font-size: 36px;
        }
    }

    .product-item__rest-img {
        position: absolute;
        top: 0px;
        right: 0;
        border-radius: 0px 5px 0px 5px;
        display: flex;
        justify-content: center;
        z-index: 12;
        padding: 0px;
        background: white;

        a {
            background: transparent;
            overflow: hidden;
            border-radius: 0px 5px 0px 5px;

            img {
                width: 50px;
                height: 50px;
            }
        }
    }

</style>
