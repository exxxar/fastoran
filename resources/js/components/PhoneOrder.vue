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

        <div class="row mb-2">
            <div class="col-sm-12">
                <button type="submit" class="btn food__btn" style="width:100%"><span>Заказать товар</span></button>
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

            }
        },
        computed: {},
        methods: {
            onSubmit() {
                ym(61797661, 'reachGoal', 'phone');

                $('#customPhoneModal').modal('hide')

                this.sendMessage("Заказ успешно отправлен")

                axios
                    .post('../api/v1/fastoran/order/phone', {
                        name: this.name,
                        phone: this.phone,
                    }).then(resp => {

                    this.sendMessage("Заявка на перезвон успешно отправлена!")

                })
            },
            sendMessage(message) {
                this.$notify({
                    group: 'info',
                    type: 'success',
                    title: 'Заказ по телефону Fastoran',
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
