<template>
    <div class="mobile-tags-cloud">

        <div class="tags-preloader" v-if="preloader">
            <img src="/img/ajax-loader.gif" alt="">
            <h5>Загружаем-с товар из категории</h5>
        </div>

     <!--   <div class="buttonCarousel owl-carousel">
            <div class="owl-item" >

            </div>

        </div>-->

        <VueSlickCarousel :arrows="false" :dots="false" v-bind="settings">
            <div v-for="category in categories">
                <div class="item" >
                    <a href="#">
                        <strong>{{category.name}}</strong>
                    </a>
                </div>
            </div>

        </VueSlickCarousel>


        <div class="container mb-5">
            <div class="row">
                <div class="col-md-6 col-lg-3 col-sm-6 col-6 banner-item" v-for="product in products">
                    <mobile-product-item :product="product"></mobile-product-item>
                </div>

            </div>
        </div>

    </div>
</template>
<script>

    import VueSlickCarousel from 'vue-slick-carousel'

    export default {
        data() {
            return {
                selectedCategory: null,
                categories: [],
                products: [],
                preloader: false,
                settings:{
                    "lazyLoad": "ondemand",
                    "dots": true,
                    "fade": true,
                    "infinite": true,
                    "speed": 500,
                    "slidesToShow": 6,
                    "slidesToScroll": 1
                }
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

        },
        components: { VueSlickCarousel },
    }
</script>
<style lang="scss">
    .mobile-tags-cloud {
        position: relative;

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
            z-index: 10;
            background: rgba(255, 255, 255, 0.8);

            img {
                margin-top: 50px;
                width: 75px;
                height: 75px;
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
                    color: white;
                    border: 1px dashed white;

                    &:hover {
                        background: #c31013;

                        // color:#fbc01c;
                    }
                }
            }
        }
    }


</style>
