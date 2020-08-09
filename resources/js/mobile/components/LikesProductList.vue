<template>
    <div class="product-list">
        <div class="tags-preloader" v-if="preloader">
            <img src="/img/ajax-loader.gif" alt="">
            <h6>Загружаем-с понравившийся товар</h6>
        </div>

        <div class="container ">
            <div class="row" v-if="likesProducts.length>0">
                <div class="col-6 banner-item" v-for="likeProduct in likesProducts">
                    <mobile-product-item :product="likeProduct.product" :like="true"></mobile-product-item>
                </div>
            </div>
            <div class="row" v-else>
                <div class="col-12">
                    <h5>Вы ничего не выбирали:(</h5>
                    <a href="/m/restorans" class="btn btn-outline-warning w-100 text-center">Глянуть все рестораны</a>
                    <img src="/img/index-logo1.png"  class="img-fluid p-5 pt-0" alt="Фасторан логотип">
                </div>
            </div>

        </div>


    </div>
</template>
<script>
    export default {
        data() {
            return {
                preloader:false,
            }
        },
        mounted() {

            let callback = (val, oldVal, uri) => {
                this.$store.dispatch("getLikesProductList")
            }

            Vue.ls.on('store_likes', callback)

            this.$store.dispatch("getLikesProductList")

            //this.refresh()
        },
        activated() {

            this.$store.dispatch("getLikesProductList")

        },
        computed: {
            likesProducts: function () {
                return this.$store.getters.likesProducts;
            },
        },

    }
</script>
<style lang="scss" scoped>
    .product-list {
        position: relative;
        padding: 5px;
        min-height: 200px;

        .container {
            padding-right: 5px;
            padding-left: 5px;
        }

        .banner-item {
            padding: 0px 3px;
        }

        .food-categories {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            box-sizing: border-box;
            padding: 0px;

            li {
                list-style: none;
                padding: 0px;

                a {
                    display: block;
                    height: 100%;
                    width: 100%;
                    color: black;
                    padding: 2px;
                    text-transform: lowercase;

                    &:hover {
                        background: none;
                        border-bottom: 2px #c31013 solid;
                    }
                }
            }
        }
    }

    .tags-preloader {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        z-index: 200;
        background: rgba(255, 255, 255, 0.8);

        img {
            width: 75px;
            height: 75px;
        }

    }


</style>
