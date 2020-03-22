<template>
    <div class="l-menu">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <button type="button" class="btn btn-warning btn-filtres hidden-xs hidden-sm hidden-md hidden-lg">
                        Фильтры и сортировка
                    </button>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <div class="l-rest-list__filtres menu-filtres fixed-xs-hidden">
                        <a href="#" class="close-filter hidden-sm hidden-md hidden-lg"><img src="/img/close-filter.png"
                                                                                            alt=""></a>
                        <div class="l-rest-list__filtres--section">
                            <ul>
                                <li v-for="category in categories" @click="setCategoryFilter(category.id)">
                                    <input type="checkbox" class="menu-filter" :id="'category'+category.id"><label
                                    :for="'category'+category.id">{{category.name}}</label>
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
                        <div v-for="category in categories" class="l-menu-list-item"
                             :data-menu-item="'category'+category.id">
                            <div class="l-menu-list-item__title" role="" data-toggle=""
                                 :href="'#item-category'+category.id"
                                 aria-expanded="true" aria-controls="item-f428" style="">
                                <div>
                                    <h2 class="text-uppercase">{{category.name}}</h2>
                                </div>
                                <div>
                                    <span class="caret hidden-sm hidden-md hidden-lg"><img src="img/menu-caret.png"
                                                                                           alt=""></span>
                                </div>
                            </div>
                            <div class="l-menu-list-item__body" aria-expanded="" id="item-f428" style="">
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
                                                    <div class="round"><i class="glyphicon glyphicon-search"></i></div>
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
                                                        <button type="button" class="btn btn-warning add-btn hidden"
                                                                :data-target="'menu'+menu.id">Заказать
                                                        </button>
                                                        <div class="cnt-container">
                                                            <button class="btn-minus" :data-target="'menu'+menu.id"><span>-</span>
                                                            </button>
                                                            <input type="text" readonly="true" value="6"
                                                                   data-input="5300">
                                                            <button class="btn-plus" :data-target="'menu'+menu.id"><span>+</span>
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
        props: ["rest_id"],
        data() {
            return {
                filter: {
                    category: null
                },
                categories: [],
                menus: []
            }
        },
        mounted() {
        },
        methods: {
            loadData() {
                axios
                    .get('/menu/' + this.rest_id)
                    .then((resp) => {
                        this.categories = resp.data.categories;
                        this.menus = resp.data.menus;
                    });
            },
            getFoodImg(menu) {
                return menu.food_img == null ? 'no-img.png' : menu.food_img;
            },
            getMenuByCategories(categoryId) {
                return this.menus.filter(item => {
                    return item.food_category_id === categoryId
                })
            },
            getFilteredRestorans() {
                let tmp = this.menus;

                if (this.filter.category != null)
                    tmp = tmp.filter(item => {
                        return item.food_category_id === this.filter.category
                    });

                return tmp;
            },
            setCategoryFilter(categoryId) {
                this.filter.category = categoryId
            },
            clearFilter() {
                this.filter.category = null
            }
        }
    }
</script>
