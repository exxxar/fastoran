<template>
    <div class="tab-content container">

        <div class="row mt-2 mb-2">
            <div class="col-md-6 col-sm-12">
                <input type="search" class="search-input w-100" v-model="filteredText"
                       placeholder="Быстрый поиск по продуктам...">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-4 col-12" v-for="product in filteredProducts()"
                 v-if="food_category_selected==product.food_part_id">

                <obedy-product :product="product" v-if="!product.is_week"/>
                <obedy-product :product="product" v-if="product.is_week"
                               style="border: 2px solid rgb(103, 136, 22);padding: 15px;background: repeating-linear-gradient( 45deg, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.2) 10px, rgba(0, 0, 0, 0.3) 10px, rgba(0, 0, 0, 0.3) 20px ), #ceff55;"
                               :week="true"/>


            </div>


        </div>
        <h3 class="mt-4 mb-2 text-uppercase" style="color: #c31200;">А также можно добавить к заказу....</h3>

        <div class="row mt-2 ingredients pb-2">
            <div class="col-sm-12 d-flex justify-content-start">
                <p :class="(current_category_id===item.id?'active':'')" v-for="item in categories"
                   v-if="countProductInCategory(item.id)>0"
                   @click="current_category_id=item.id">
                    #{{item.title}}</p>
            </div>
        </div>
        <div class="row">

            <div class="col-12 col-sm-6 col-md-6 col-lg-3" v-if="current_category_id==item.category_id"
                 v-for="item in getAdditions()">


                <obedy-product :product="item"/>

            </div>
        </div>

        <h3 class="mt-4 mb-2 text-uppercase" style="color: #c31200;">Можете посмотреть меню на неделю <a
            href="/img/go/full_1.jpg" target="_blank">ТУТ</a> и <a href="/img/go/full_2.jpg" target="_blank">ТУТ</a>
        </h3>


    </div>
</template>

<script>
    import vueCustomScrollbar from 'vue-custom-scrollbar'
    import ObedyProduct from '../obedy/ObedyProduct'
    import ObedyControls from '../obedy/ObedyControls'

    import "vue-custom-scrollbar/dist/vueScrollbar.css"

    export default {
        props: ["food_category_selected"],
        data() {
            return {
                filteredText: null,
                current_category_id: 1,
                current_day: 2,
                settings: {
                    suppressScrollX: true,
                    suppressScrollY: false,
                },

            }
        },
        computed: {
            products() {
                return this.$store.getters.getGoProducts;
            },
            categories() {
                return this.$store.getters.getGoCategories;
            }
        },

        mounted() {
            this.$store.dispatch("loadProducts");
            this.$store.dispatch("loadCategories");
        },
        methods: {
            filteredProducts() {
                return this.filteredText == null ? this.products :
                    this.products.filter(item => item
                            .title
                            .toLowerCase()
                            .indexOf(this.filteredText.toLowerCase()) !== -1 ||
                        (item.description ? item
                            .description
                            .toLowerCase()
                            .indexOf(this.filteredText.toLowerCase()) !== -1 : false)
                    )

            },
            getAdditions() {
                return this.products ? this.products.filter(item => item.category_id != null) : []
            },
            countProductInCategory(catId) {
                let count = 0;
                this.products.forEach(item => {
                    if (item.category_id === catId)
                        count++;
                });
                return count;
            },

            sendMessage(message, type = 'success') {
                this.$notify({
                    group: 'info',
                    type: type,
                    title: 'Оповещение ОбедыGO',
                    text: message
                });
            },
        },
        components: {
            vueCustomScrollbar, ObedyProduct, ObedyControls
        }

    }
</script>

<style lang="scss">


    .search-input {
        padding: 15px;
        border-radius: 5px;
        box-shadow: 1px 1px 2px 0px #000000;
        border: 3px #748f26 solid;
    }

    .tab-content {

        width: 100%;
        min-height: 500px;
        padding: 15px;


    }

    .ingredients {
        p {
            border-bottom: 2px transparent solid;
            padding: 10px;
            text-transform: uppercase;
            text-align: center;
            font-weight: 800;
            color: gray;
            cursor: pointer;

            &.active {
                border-bottom: 2px #c31200 solid;
                text-transform: uppercase;
                text-align: center;
                font-weight: 800;
                color: black;

                &:first-letter {
                    color: #c31200;
                }

            }

        }
    }


    [data-glide-el="controls"] {
        justify-content: space-between;
        display: flex;

        button {
            position: absolute;
            top: -21px;
            background: #678816;
            border: none;
            width: 40px;
            height: 40px;
            color: white;
            border-radius: 5px;
        }

        .prev {
            left: 0;
        }

        .next {
            right: 0;
        }
    }


    .additions {
        overflow-x: auto;
        position: relative;
        width: 100%;
        height: 100%;

    }

    .simple-item {
        width: 100%;
        /* max-width: 200px; */
        height: auto;
        min-width: 175px;
        /* max-height: 200px; */
        min-height: 175px;
        padding: 5px;

        img {
            height: 100%;
            width: 100%;
            object-fit: cover;

            border-radius: 5px;
            box-shadow: 1px 1px 2px 0px #000000;
        }
    }

    .custom-btn-color-success {
        background-color: #678816;
        box-shadow: 1px 1px 2px 0px #678816;
        border-color: #678816;
    }

    .custom-btn-color-danger {
        background: #c31200;
        box-shadow: 1px 1px 2px 0px #c31200;
        border-color: #c31200;

    }

</style>
