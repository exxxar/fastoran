<template>
    <form v-on:submit.prevent="onSubmit">
        <h3>Что доставить?</h3>
        <h4 class="mt-2"><em><strong>Важно!</strong>Стоимость доставки зависит от типа доставляемой вещи!
            (+{{selected_type.price}} руб.)</em></h4>
        <div class="row mt-2">
            <div class="col-12">
                <select v-model="selected_type" class="form-control">
                    <option v-for="type in delivery_type" :value="type">{{type.title}}</option>
                </select>
            </div>


        </div>

        <div class="row mt-2">
            <div class="col-12">
                <textarea class="form-control" v-model="quest_info" placeholder="Описание задания" required>
                </textarea>
            </div>

        </div>

        <div class="row mt-2">
            <div class="col-sm-12 col-md-6">
                <h3>Откуда забрать?</h3>

                <div class="row mt-2">
                    <div class="col-12">
                        <input class="form-control" type="text" v-model="point_a.name" placeholder="Ваше имя" required>

                    </div>
                    <div class="col-12 mt-2">
                        <input class="form-control" type="text" v-model="point_a.phone" placeholder="Ваш номер телефона"
                               pattern="[\+]\d{2} [\(]\d{3}[\)] \d{3}[\-]\d{2}[\-]\d{2}"
                               maxlength="19"
                               v-mask="['+38 (###) ###-##-##']" required>
                    </div>

                    <div class="col-12 mt-2">
                        <select class="form-control" type="text" v-model="point_a.city" required>
                            <option v-for="city in cities" :value="city">{{city}}</option>
                        </select>
                    </div>

                    <div class="col-12 mt-2">
                        <input class="form-control" type="text" v-model="point_a.street" placeholder="Улица" required>
                    </div>

                </div>

                <div class="row mt-2">
                    <div class="col-md-6 col-sm-6">
                        <input class="form-control" type="text" v-model="point_a.home_number" placeholder="Номер дома"
                               required>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <input class="form-control" type="text" v-model="point_a.flat_number"
                               placeholder="Номер квартиры">
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                <textarea class="form-control" v-model="point_a.more_info" placeholder="Дополнительная информация"
                          required>
                </textarea>
                    </div>

                </div>

            </div>
            <div class="col-sm-12 col-md-6">
                <h3>Куда доставить?</h3>

                <div class="row mt-2">
                    <div class="col-12">
                        <input class="form-control" type="text" v-model="point_b.name"
                               placeholder="Имя принимающей стороны"
                               required>

                    </div>
                    <div class="col-12 mt-2">
                        <input class="form-control" type="text" v-model="point_b.phone"
                               placeholder="Телефон принимающей стороны"
                               pattern="[\+]\d{2} [\(]\d{3}[\)] \d{3}[\-]\d{2}[\-]\d{2}"
                               maxlength="19"
                               v-mask="['+38 (###) ###-##-##']" required>
                    </div>

                    <div class="col-12 mt-2">
                        <select class="form-control" type="text" v-model="point_b.city" required>
                            <option v-for="city in cities" :value="city">{{city}}</option>
                        </select>
                    </div>

                    <div class="col-12 mt-2">
                        <input class="form-control" type="text" v-model="point_b.street" placeholder="Улица" required>
                    </div>

                </div>

                <div class="row mt-2">
                    <div class="col-md-6 col-sm-6">
                        <input class="form-control" type="text" v-model="point_b.home_number" placeholder="Номер дома"
                               required>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <input class="form-control" type="text" v-model="point_b.flat_number"
                               placeholder="Номер квартиры">
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-12">
                <textarea class="form-control" v-model="point_b.more_info" placeholder="Дополнительная информация"
                          required>
                </textarea>
                    </div>

                </div>
            </div>
        </div>


        <div class="row mt-2">
            <div class="col-12"><h4>Цена работы курьера <strong>{{delivery_price + selected_type.price}} руб.</strong>
            </h4>
            </div>
            <div class="col-12 mt-2">
                <button type="button" @click="getRange" class="btn btn-success" style="width:100%">
                    <span>Расчитать цену</span></button>
            </div>
            <div class="col-12 mt-2">
                <button type="submit" class="btn food__btn" style="width:100%" :disabled="!is_valid_address"><span>Заказать доставщика</span>
                </button>
            </div>
        </div>

    </form>
</template>

<script>
    import {mask} from 'vue-the-mask'

    export default {
        data() {
            return {
                point_a: {
                    name: '',
                    phone: '',
                    city: 'Донецк',
                    street: '',
                    home_number: '',
                    flat_number: '',
                    more_info: ''
                },
                point_b: {
                    name: '',
                    phone: '',
                    city: 'Донецк',
                    street: '',
                    home_number: '',
                    flat_number: '',
                    more_info: ''
                },
                quest_info: '',
                delivery_price: 0,
                is_valid_address: false,
                selected_type: {title: "Негабаритные личные вещи", value: 1, price: 50},
                cities: [
                    "Донецк", "Макеевка"
                ],
                delivery_type: [
                    {title: "Негабаритные личные вещи", value: 1, price: 50},
                    {title: "Габаритные личные вещи", value: 2, price: 200},
                    {title: "Личные вещи повышенной ценности", value: 3, price: 500},
                    {title: "Другое", value: 4, price: 50}
                ]


            }
        },

        methods: {
            getRange() {
                axios.post('../api/v1/custom_range', {
                    address_a: "Украина, город " + this.point_a.city + ", " + this.point_a.street + ", " + this.point_a.home_number,
                    address_b: "Украина, город " + this.point_b.city + ", " + this.point_b.street + ", " + this.point_b.home_number
                })
                    .then(resp => {
                        this.is_valid_address = true;
                        this.delivery_price = resp.data.price
                    })
            },
            onSubmit() {

                $('#deliverymanQuestOrderModal').modal('hide')

                this.sendMessage("Заказ успешно отправлен")

                console.log(this.point_a);
                axios
                    .post('../api/v1/fastoran/order/quest', {
                        point_a: this.point_a,
                        point_b: this.point_b,
                        quest_type: this.selected_type.value,
                        description: this.quest_info
                    }).then(resp => {

                })
            },
            sendMessage(message) {
                this.$notify({
                    group: 'info',
                    type: 'success',
                    title: 'Заказ доставщика из Fastoran',
                    text: message
                });
            },
        },
        directives: {mask}
    }
</script>

<style lang="scss" scoped>

    .btn-success {
        text-transform: uppercase;
        font-weight: 800;
    }

    button[disabled] {
        background: #333333;
    }

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
