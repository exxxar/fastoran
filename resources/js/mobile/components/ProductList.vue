<template>
    <div class="product-list">
        <ul class="food-categories">
            <li v-for="category in categories"><a :href="category.name" @click="loadProducts(category.id)">{{category.name}}</a>
            </li>
        </ul>

        <div class="tags-preloader" v-if="preloader">
            <img src="/img/ajax-loader.gif" alt="">
            <h5>Загружаем-с товар из категории</h5>
        </div>

        <div class="container mb-5">
            <div class="row">
                <div class="col-6 banner-item" v-for="product in products">
                    <mobile-product-item :product="product"></mobile-product-item>
                </div>

            </div>
        </div>

    </div>
</template>
<script>
    export default {
        props:["restoran_id"],
        data() {
            return {
                selectedCategory: null,
                categories: [],
                products: [],
                preloader: false
            }
        },
        mounted() {
            this.loadCategories()

        },
        methods: {
            loadCategories() {
                this.preloader = true;
                axios
                    .get("/api/v1/fastoran/menu_categories_in_rest/"+this.restoran_id)
                    .then(resp => {
                        this.categories = resp.data.menu_categories
                        this.preloader = false;
                        this.loadProducts(this.categories[0].id)
                    })
            },
            loadProducts(id) {
                this.preloader = true;
                this.products = [];
                axios
                    .get("/api/v1/fastoran/menu_categories/" + id)
                    .then(resp => {
                        this.products = resp.data.products
                        this.preloader = false;
                    })
            },

        }
    }
</script>
<style lang="scss" scoped>
    .product-list {
        position: relative;

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
                    color:black;
                    padding:2px;
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
        z-index: 10;
        background: rgba(255, 255, 255, 0.8);

        img {
            margin-top: 50px;
            width: 75px;
            height: 75px;
        }

    }


</style>
