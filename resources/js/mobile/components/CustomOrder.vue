<template>
    <form v-on:submit.prevent="onSubmit">
        <div class="row mb-2">
            <div class="col-12">
                <input class="form-control" type="text" v-model="name" placeholder="Ваше имя" required>
            </div>

        </div>
        <div class="row mb-2">
            <div class="col-12">
                <input class="form-control" type="text" v-model="phone" placeholder="Ваш номер телефона"
                       pattern="[\+]\d{2} [\(]\d{3}[\)] \d{3}[\-]\d{2}[\-]\d{2}"
                       maxlength="19"
                       v-mask="['+38 (###) ###-##-##']" required>
            </div>

        </div>
        <hr>
        <h6><em>Цена доставки <strong>159
            руб.</strong></em></h6>
        <hr>
        <div class="row mb-2">
            <div class="col-12">
                <input class="form-control" type="text" v-model="address" minlength="5" placeholder="Адрес доставки"
                       required>
            </div>

        </div>

        <div class="row mb-2">
            <div class="col-12">
                <textarea class="form-control" type="text" v-model="more_info" placeholder="Дополнительная информация">
                </textarea>
            </div>

        </div>
        <hr>
        <h6>На текущий момент мы доставляем товары стоимостью <strong>до 1500</strong> рублей. При
            заказе укажите
            <strong>максимальную</strong> цену товара! </h6>
        <hr>


        <div class="row" v-for="(product, index) in products">
            <div class="col-12 mb-1">
                <input class="form-control" type="text" v-model="product.name" minlength="5"
                       placeholder="Описание и кол-во товара" required></div>
            <div class="col-12 mb-1">
                <input class="form-control" type="number" v-model="product.price" min="10" max="1000"
                       placeholder="Цена, руб." required></div>
            <div class="col-12 mb-1"><a @click="removeProduct(index)" class="btn-food-link"><i
                class="fas fa-trash"></i></a></div>
        </div>

        <div class="row">
            <div class="col-12">
                <button type="button" @click="addProduct" class="btn btn-success" style="width:100%">
                    <span>Добавить</span></button>
            </div>
        </div>
        <hr>
        <div class="row mb-2">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary" style="width:100%"><span>Заказать товар</span></button>
            </div>

        </div>
        <hr>
        <div class="row">
            <div class="col-sm-12">
                <a href="../terms" target="_blank">Перед началом работы советуем ознакомиться с соглашением на обработку
                    пользовательских данных.</a>
            </div>
        </div>

    </form>
</template>

<script>
    import {mask} from 'vue-the-mask'

    export default {
        data() {
            return {
                name: localStorage.getItem("food_first_name", ""),
                phone: localStorage.getItem("phone", ""),
                address: this.getAddress(),
                more_info: '',
                products: [
                    {
                        name: "", price: null
                    }
                ]

            }
        },
        computed: {

        },
        methods: {
            getAddress() {
                let city = localStorage.getItem("food_city", "");
                let street = localStorage.getItem("food_street", "")
                let home_number = localStorage.getItem("food_home_number", "")

                return (city == null ? '' : city+", ")
                    + (street == null ? '' : street+", ")
                    + (home_number == null ? '' : home_number);
            },
            removeProduct(id) {
                if (this.products.length > 1) {
                    this.products = this.products.filter((item, index) => index !== id)
                    this.sendMessage("Товар удален")
                    return;
                }
                this.products[0].name = "";
                this.products[0].price = null;
                this.sendMessage("Товаров больше нет в корзине")

            },
            addProduct() {
                this.products.push({
                    name: "",
                    price: null
                })
            },
            onSubmit() {
                ym(61797661,'reachGoal','restorany');

                $('#customCartModal').modal('hide')

                this.sendMessage("Заказ успешно отправлен")

                axios
                    .post('../api/v1/fastoran/order/custom', {
                        name: this.name,
                        phone: this.phone,
                        address: this.address,
                        more_info: this.info,
                        order_details: this.products
                    }).then(resp => {

                    this.products = [{name: '', price: null}];

                    localStorage.getItem("food_first_name", this.name)
                    localStorage.getItem("phone", this.phone)


                })
            },
            sendMessage(message) {
                this.$notify({
                    group: 'info',
                    type: 'success',
                    title: 'Пользовательский заказ Fastoran',
                    text: message
                });
            },
        },
        directives: {mask}
    }
</script>

<style lang="scss">
    .btn-food-link {
        display: flex;
        justify-content: center;
        align-items: center;
        color: #afafaf;
        height: 100%;
        padding: 10px 0px;

        &:hover {
            color: darkgray;
        }
    }
</style>
