<template>
    <div>
        <h1 class="text-center mt-4 mb-4">Собираем вкусную пиццу</h1>
        <h2 class="text-center">
            <mark>Выбираем основу пиццы...</mark>
        </h2>
        <div class="row mt-4 mb-4">
            <div class="col-6">
                <label class="container">Пицца Челентано<span
                    class="badge badge-weight">350 гр.</span><span class="badge">95 ₽</span>
                    <input type="radio" name="base" checked>
                    <span class="checkmark"></span>
                </label>
            </div>
            <div class="col-6">
                <label class="container">Пицца Челентано с белым соусом<span
                    class="badge badge-weight">350 гр.</span><span class="badge">95 ₽</span>
                    <input type="radio" name="base">
                    <span class="checkmark"></span>
                </label>
            </div>
        </div>
        <hr>
        <h2 class="text-center">
            <mark>А теперь выбираем начинку пиццы...</mark>
        </h2>

        <div class="row mt-4">
            <div class="col-6">
                <h3 class="text-left mb-4">
                    <mark>{{getCategory(1).title}}</mark>
                </h3>
                <div class="container-wrapper" v-for="fill in getFilling(1)">
                    <label class="container">{{fill.title}}<span
                        class="badge badge-weight">{{fill.weight}} гр.</span><span
                        class="badge">{{fill.price | currency}}</span>
                        <input type="checkbox" name="filling">
                        <span class="checkmark"></span>
                    </label>

                    <div class="counter-wrapper">
                        <div class="counter">
                            <button class="btn btn-counter">-</button>
                            <p>1</p>
                            <button class="btn btn-counter">+</button>
                        </div>
                    </div>
                </div>


            </div>
            <div class="col-6">
                <h3 class="text-left mb-4">
                    <mark>{{getCategory(2).title}}</mark>
                </h3>
                <div class="container-wrapper" v-for="fill in getFilling(2)">
                    <label class="container">{{fill.title}}<span
                        class="badge badge-weight">{{fill.weight}} гр.</span><span
                        class="badge">{{fill.price | currency}}</span>
                        <input type="checkbox" name="filling">
                        <span class="checkmark"></span>
                    </label>

                    <div class="counter-wrapper">
                        <div class="counter">
                            <button class="btn btn-counter">-</button>
                            <p>1</p>
                            <button class="btn btn-counter">+</button>
                        </div>
                    </div>
                </div>

                <h3 class="text-left mb-4 mt-4">
                    <mark>{{getCategory(3).title}}</mark>
                </h3>
                <div class="container-wrapper" v-for="fill in getFilling(3)">
                    <label class="container">{{fill.title}}<span
                        class="badge badge-weight">{{fill.weight}} гр.</span><span
                        class="badge">{{fill.price | currency}}</span>
                        <input type="checkbox" name="filling">
                        <span class="checkmark"></span>
                    </label>

                    <div class="counter-wrapper">
                        <div class="counter">
                            <button class="btn btn-counter">-</button>
                            <p>1</p>
                            <button class="btn btn-counter">+</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h3 class="text-left mb-4 mt-4">
            <mark>{{getCategory(4).title}}</mark>
        </h3>
        <div class="row mt-4">
            <div class="col-6" v-for="fill in getFilling(4)">
                <div class="container-wrapper">
                    <label class="container">{{fill.title}}<span
                        class="badge badge-weight">{{fill.weight}} гр.</span><span
                        class="badge">{{fill.price | currency}}</span>
                        <input type="checkbox" name="filling">
                        <span class="checkmark"></span>
                    </label>

                    <div class="counter-wrapper">
                        <div class="counter">
                            <button class="btn btn-counter">-</button>
                            <p>1</p>
                            <button class="btn btn-counter">+</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <hr>
        <div class="row d-flex justify-content-center result">
            <div class="col-4">
                <h3 class="text-center">Сколько таких пицц сделать?</h3>
                <div class="summary">
                    <div class="btn-counter">-</div>
                    <p>1</p>
                    <div class="btn-counter">+</div>
                </div>
                <hr>
                <div class="d-flex justify-content-center">
                    <ul>
                        <li>Вес: <strong>2000 грамм</strong></li>
                        <li>Цена: <strong>7000 руб</strong></li>
                    </ul>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <button class="food__btn">
                        Добавить в корзину
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

                filling_categories: [
                    {id: 1, title: "Овощные начинки"},
                    {id: 2, title: "Мясные начинки"},
                    {id: 3, title: "Морские начинки"},
                    {id: 4, title: "Сырные начинки"},
                ],
                filling: [
                    {id: 1, title: "Грибы жаренные", weight: 50, price: 45, category: 1},
                    {id: 2, title: "Грибы стерилизованные", weight: 40, price: 45, category: 1},
                    {id: 3, title: "Грибы свежие", weight: 40, price: 45, category: 1},
                    {id: 4, title: "Ананасы", weight: 40, price: 35, category: 1},
                    {id: 5, title: "Помидоры свежие", weight: 50, price: 30, category: 1},
                    {id: 6, title: "Перец болгарский", weight: 40, price: 30, category: 1},
                    {id: 7, title: "Кукуруза", weight: 40, price: 30, category: 1},
                    {id: 8, title: "Маслины", weight: 30, price: 55, category: 1},
                    {id: 9, title: "Фасоль спаржевая", weight: 50, price: 30, category: 1},
                    {id: 10, title: "Пепперони", weight: 30, price: 26, category: 1},
                    {id: 11, title: "Маринованный лук", weight: 50, price: 12, category: 1},
                    {id: 12, title: "Огурец маринованный", weight: 50, price: 30, category: 1},
                    {id: 13, title: "Зелень петрушки к пицце", weight: 3, price: 12, category: 1},
                    {id: 14, title: "Зелень укропа к пицце", weight: 3, price: 12, category: 1},
                    {id: 15, title: "Балык мясной", weight: 40, price: 50, category: 2},
                    {id: 16, title: "Курица", weight: 50, price: 55, category: 2},
                    {id: 17, title: "Охотничьи колбаски", weight: 50, price: 55, category: 2},
                    {id: 18, title: "Салями", weight: 40, price: 50, category: 2},
                    {id: 19, title: "Бекон", weight: 40, price: 50, category: 2},
                    {id: 20, title: "Салями острая пепперони", weight: 25, price: 55, category: 2},
                    {id: 21, title: "Кальмары", weight: 50, price: 85, category: 3},
                    {id: 22, title: "Крабовые палочки", weight: 50, price: 40, category: 3},
                    {id: 23, title: "Семга", weight: 40, price: 135, category: 3},
                    {id: 24, title: "Ди Маре", weight: 150, price: 135, category: 3},
                    {id: 25, title: "Твердый сыр", weight: 70, price: 55, category: 4},
                    {id: 26, title: "Фета", weight: 50, price: 60, category: 4},
                    {id: 27, title: "Пармезан", weight: 15, price: 40, category: 4},
                    {id: 28, title: "Моцарелла", weight: 60, price: 60, category: 4},
                ]
            }
        },
        methods: {
            getCategory(id) {
                return this.filling_categories.filter(item => item.id === id)[0]
            },
            getFilling(type) {
                return this.filling.filter(item => item.category === type)
            }
        }
    }
</script>
<style lang="scss" scoped>

    hr {
        width: 100%;
        height: 1px;
        /* background: darkred; */
        border-top: 1px darkred solid;
        margin-top: 10px;
        margin-bottom: 10px;
        padding: 10px;
    }


    h2,
    h3 {
        mark {
            color: white;
        }
    }

    .container-wrapper {
        display: flex;
        justify-content: space-between;
    }

    .result {
        ul {
            width: 150px;

            li {
                width: 100%;
                display: flex;
                justify-content: space-between;

            }
        }

        .summary {
            width: 100%;
            display: flex;
            padding: 10px;
            justify-content: space-around;
            align-items: center;

            p {
                padding: 10px;
            }

            .btn-counter {
                width: 50px;
                height: 50px;
                display: flex;
                justify-content: center;
                align-items: center;
                background: darkorange;
                font-size: 20px;
                font-weight: bolder;
                color: #4e3d03;
            }
        }
    }

    .counter-wrapper {
        display: inline-block;

        .counter {
            display: flex;
            justify-content: space-between;
            width: 100px;
            padding: 5px;

            .btn-counter {
                width: 25px;
                height: 25px;
                background: darkorange;
                color: white;
                padding: 0px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
        }
    }
</style>
