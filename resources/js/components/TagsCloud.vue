<template>
    <div class="tags-cloud">
        <ul class="food-categories">
            <li v-for="category in categories"><a :href="category.name" @click="loadProducts(category.id)">{{category.name}}</a></li>
        </ul>

        <div class="tags-preloader" v-if="preloader">
            <img src="/img/ajax-loader.gif" alt="">
            <h5>Загружаем-с товар из категории</h5>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-3 col-sm-6" v-for="product in products">
                <div class="banner--2">
                    <div class="banner__thumb">
                        <a href="#"><img
                            class="lazyload" :data-src="product.food_img"
                            alt="banner images"></a>


                    </div>
                    <add-cart-btn :product_id="product.id" v-if="product.rest_info.is_work"
                                  :product_data="product"></add-cart-btn>

                    <div class="product-btn-box" v-else>
                        <p class="text-center">
                            <mark class="color--white">Время работы: <strong>{{product.rest_info.work_time}}</strong>
                            </mark>
                        </p>
                    </div>

                    <h4 class="banner__h4">
                        <mark>{{product.food_price}}₽</mark>
                    </h4>
                    <div class="rest-img">
                        <a :href="'../rest/'+product.rest_info.url">
                            <img class="lazyload" :data-src="product.rest_info.logo" alt="">
                        </a>
                    </div>
                    <div class="banner__hover__action banner__left__bottom">
                        <div class="banner__hover__inner">

                            <h2 class="pink-text">
                                <mark>{{product.food_name}}</mark>
                            </h2>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                selectedCategory: null,
                categories: [],
                products: [],
                preloader:false
            }
        },
        mounted() {
            this.loadCategories()
        },
        methods: {
            loadCategories() {
                this.preloader = true;
                axios
                    .get("../api/v1/fastoran/menu_categories")
                    .then(resp => {
                        this.categories = resp.data.menu_categories
                        this.preloader = false;
                    })
            },
            loadProducts(id) {
                this.preloader = true;
                this.products = [];
                axios
                    .get("../api/v1/fastoran/menu_categories/" + id)
                    .then(resp => {
                        this.products = resp.data.products
                        this.preloader = false;
                    })
            },

        }
    }
</script>
<style lang="scss">
    .tags-cloud {
        background: rgba(29, 29, 29, 0.95) url('/images/bg/4.jpg') center no-repeat;
        background-size: cover;
        padding: 50px;
        position: relative;
    }

    .tags-preloader {
        position: absolute;
        left:0;
        top: 0;
        height:100%;
        width:100%;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        z-index: 10;
        background: rgba(255,255,255,0.8);
        img {
            margin-top:50px;
            width:75px;
            height:75px;
        }

    }
    .food-categories {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        padding: 50px;
        box-sizing: border-box;

        li {
            padding: 5px;

            a {
                display: block;
                height: 100%;
                width: 100%;
                padding: 10px;
                color:white;
                border: 1px dashed white;

                &:hover {
                    background: #c31013;

                    // color:#fbc01c;
                }
            }
        }
    }
</style>
