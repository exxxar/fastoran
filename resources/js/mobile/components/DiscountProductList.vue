<template>
    <div class="product-list">
        <div class="tags-preloader" v-if="preloader">
            <img src="/img/ajax-loader.gif" alt="">
            <h6>Загружаем-с товар со скидкой</h6>
        </div>

        <div class="container ">
            <div class="row" v-if="this.products.length>0">
                <div class="col-6 banner-item" v-for="product in products">
                    <mobile-product-item :product="product"></mobile-product-item>
                </div>

            </div>

            <div class="row" v-if="this.products.length===0">
                <div class="col-12">
                    <h5>Увы, скидок на данный момент нет:(</h5>
                    <a href="/m/restorans" class="btn btn-outline-warning w-100 text-center">Глянуть все рестораны</a>
                    <img src="/img/index-logo1.png"  class="img-fluid p-5 pt-0" alt="Фасторан логотип">
                </div>
            </div>

            <div class="row" v-if="this.products.length>0">
                <div class="col-12">
                    <button v-if="this.prev_page_url!=null" class="btn btn-outline-success w-100  mt-1" @click="prev()">
                        Предыдущая страница
                    </button>
                </div>
                <div class="col-12 ">
                    <button v-if="this.next_page_url!=null" class="btn btn-outline-success w-100 mt-1" @click="next()">
                        Следующая страница
                    </button>
                </div>
            </div>
        </div>


    </div>
</template>
<script>
    export default {
        data() {
            return {
                products: [],
                preloader: false,
                first_page_url: null,
                next_page_url: null,
                prev_page_url: null,
            }
        },
        mounted() {
            this.refresh()
        },
        methods: {
            loadDiscountProducts() {
                this.preloader = true;
                axios
                    .get(this.current_page_url)
                    .then(resp => {
                        this.products = resp.data.data
                        this.preloader = false;

                        this.first_page_url = resp.data.first_page_url
                        this.next_page_url = resp.data.next_page_url
                        this.prev_page_url = resp.data.prev_page_url
                    })
            },

            refresh() {
                this.current_page_url = '/api/v1/fastoran/sales';
                this.loadDiscountProducts();
            },
            prev() {
                this.current_page_url = this.prev_page_url
                this.loadDiscountProducts();
            },
            next() {
                this.current_page_url = this.next_page_url
                this.loadDiscountProducts();
            },

        }
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
