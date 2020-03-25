<template>
    <div class="l-menu">
        <notifications group="message"/>
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <button type="button" class="btn btn-warning btn-filtres  hidden-md hidden-lg">
                        Фильтры и сортировка
                    </button>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <div class="l-rest-list__filtres menu-filtres fixed-xs-hidden">
                        <a href="#" class="close-filter hidden-sm hidden-md hidden-lg"><img src="/img/close-filter.png"
                                                                                            alt=""></a>
                        <div class="l-rest-list__filtres--section">
                            <ul>
                                <li v-for="category in categories" v-if="category.in_category_count>0">
                                    <input type="checkbox" class="menu-filter" :id="'category-menu-'+category.id"
                                           :value="category.id" v-model="filter.categories"><label
                                    :for="'category-menu-'+category.id">{{category.name}} </label>
                                    <i data-toggle="collapse" role="button" :data-target="'#category'+category.id"
                                       class="fas fa-angle-up"></i>
                                </li>
                            </ul>
                            <!-- <a href="#" class="save-menu"><img src="/img/save-menu.png" alt=""><span>Скачать меню</span></a> -->
                        </div>
                        <div class="event-filtres">
                            <!-- <div>
                                 <button type="button" class="btn btn-warning text-uppercase hidden-sm hidden-md hidden-lg">Применить</button>
                             </div>-->
                            <div>
                                <button type="button" @click="clearFilter()"
                                        class="btn btn-warning text-uppercase reset-filtres hidden-sm hidden-md hidden-lg">
                                    очистить
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="l-menu-list">
                        <div v-for="category in getFilteredCategories()" v-if="category.in_category_count>0"
                             class="l-menu-list-item"
                             :data-menu-item="'category'+category.id">
                            <div class="l-menu-list-item__title" aria-labelledby="headingOne" data-toggle="collapse"
                                 role="button" :data-target="'#category'+category.id"
                                 :href="'#category'+category.id"
                                 aria-expanded="true" :aria-controls="'category'+category.id" style="">
                                <div>
                                    <h2 class="text-uppercase footer-title">{{category.name}}</h2>
                                </div>
                                <div>
                                    <span class="caret hidden-sm hidden-md hidden-lg"><img src="img/menu-caret.png"
                                                                                           alt=""></span>
                                </div>
                            </div>
                            <div class="l-menu-list-item__body collapse" :id="'category'+category.id"
                                 :data-parent="'#category'+category.id" role="tabpanel" aria-labelledby="headingOne"
                                 aria-expanded="true" style="">
                                <div class="row">
                                    <div v-for="menu in getMenuByCategories(category.id)"
                                         class="col-md-4 col-sm-6 col-xs-12">
                                        <div class="menu-item" :id="'menu'+menu.id">
                                            <div class="menu-item__media">
                                                <img
                                                    :src="getFoodImg(menu)"
                                                    alt="">
                                                <a href="#" class="item-zoom hidden-xs" data-toggle="modal"
                                                   data-target="#modal-menu-item">
                                                    <div class="round"><i class="fas fa-search"></i></div>
                                                </a>
                                            </div>
                                            <div class="menu-item__description">
                                                <div>
                                                    <p class="menu-item__description--name">{{menu.food_name}}</p>
                                                    <p class="hidden weight">{{menu.food_ext}}</p>
                                                </div>
                                                <div class="menu-item__description--full hidden-sm hidden-md hidden-lg">
                                                    <p class="menu-item__description--text">{{menu.food_remark}}</p>

                                                </div>
                                                <div class="price-info">
                                                    <div><h4>{{menu.food_price}}</h4></div>
                                                    <div>
                                                        <button type="button" class="btn btn-warning add-btn"
                                                                v-if="inCart(menu.id)===0"
                                                                :data-target="'menu'+menu.id" @click="addToCart(menu)">
                                                            Заказать
                                                        </button>
                                                        <div class="cnt-container" v-if="inCart(menu.id)>0">
                                                            <button class="btn-minus" @click="decProduct(menu.id)">
                                                                <span>-</span>
                                                            </button>
                                                            <input type="text" readonly="true" :value="inCart(menu.id)">
                                                            <button class="btn-plus" @click="incProduct(menu.id)">
                                                                <span>+</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="reviews">
                        <div class="reviews-header">
                            <div>
                                <h2 class="text-uppercase">отзывы о </h2>
                            </div>
                        </div>
                        <div class="reviews-body">
                            <div class="reviews-title">
                                <div>
                                    <div class="round">
                                        <img src="/img/svg/comment.svg" alt="">
                                    </div>
                                    <a href="#" data-toggle="modal" class="add-comment">Написать отзыв</a>
                                </div>
                                <div>
                                    <p>В этом разделе Вы можете прочитать отзывы о заведении и поделиться своим. Расскажите другим пользователям, понравилось ли Вам обслуживание, как долго ехал курьер, оправдали ли блюда Ваши ожидания. Чтобы добавить отзыв, пожалуйста, зарегистрируйтесь и сделайте заказ.</p>
                                </div>
                            </div>




                            <div class="reviews-item  ">
                                <div class="reviews-item-head">
                                    <div class="like">
                                        <img src="/img/svg/like-review.svg" alt="">
                                    </div>
                                    <div class="like disslike">
                                        <img src="/img/svg/disslike.svg" alt="">
                                    </div>
                                    <div class="name">
                                        <h5></h5>
                                    </div>
                                    <div class="date">
                                        <p> | </p>
                                    </div>
                                </div>
                                <div class="reviews-item-body">
                                    <p></p>
                                </div>
                            </div>




                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

</template>
<script>
    export default {
        props: ["rest"],
        data() {
            return {
                filter: {
                    categories: []
                },
                categories: [],
                menus: []
            }
        }, watch: {
            products: function (newVal, oldVal) {
                return newVal
            }
        },
        computed: {
            products() {
                return this.$store.getters.cartProducts;
            }
        },
        mounted() {
            this.loadData()
        },
        methods: {

            inCart(menuId) {
                let tmp = this.products.filter(item => item.product.id === menuId);
                return tmp.length === 0 ? 0 : tmp[0].quantity
            },
            addToCart(menu_item) {
                this.$store.dispatch('addProductToCart', menu_item)
            },
            incProduct(menuId) {
                this.sendMessage("Товар добавлен в корзину!")
                this.$store.dispatch('incQuantity', menuId)
            },
            decProduct(menuId) {
                this.sendMessage("Лишний товар убран из корзины!")

                if (this.inCart(menuId) === 1) {
                    this.$store.dispatch('removeProduct', menuId)
                    return;
                }

                this.$store.dispatch('decQuantity', menuId)
            },
            loadData() {
                this.$preloaders.open(/*{ options }*/);
                axios
                    .get('/api/menu/' + this.rest)
                    .then((resp) => {
                        this.categories = resp.data.categories;
                        this.menus = resp.data.restoran.menus;
                        this.$preloaders.close(/*{ options }*/)
                    });
            },
            getFoodImg(menu) {
                return menu.food_img == null ? 'no-img.png' : menu.food_img;
            },
            getMenuByCategories(categoryId) {
                let tmp = this.menus;

                return tmp.filter(item => item.food_category_id === categoryId);
            },

            getFilteredCategories() {
                let tmp = this.categories;

                if (this.filter.categories.length > 0)
                    tmp = tmp.filter(item => this.filter.categories.includes(item.id));

                return tmp;
            },
            sendMessage(message) {
                this.$notify({
                    group: 'message',
                    type: 'success',
                    title: 'Меню',
                    text: message
                });
            },
            clearFilter() {
                this.filter.categories = [];
            }

        }
    }
</script>
