<template>

        <div class="card mb-3 obedy-callback-card">
            <form @submit="sendRequest" class="card-body">
                <h5 class="card-title">{{dialog_titles[type]}}</h5>
                <div class="form-group">
                    <input type="text" name="name" class="form-control" v-model="name" placeholder="Ваше Ф.И.О."
                           required>
                </div>
                <div class="form-group">
                    <input type="text" name="phone" class="form-control" v-model="phone"
                           pattern="[\+]\d{2} [\(]\d{3}[\)] \d{3}[\-]\d{2}[\-]\d{2}"
                           maxlength="19"
                           v-mask="['+38 (###) ###-##-##']"
                           placeholder="Номер телефона" required>
                </div>
                <div class="form-group">
                    <select name="question-type" v-model="type" class="form-control" required>
                        <option v-for="(option,index) in question_types" :value="index">
                            {{option}}
                        </option>
                    </select>
                </div>
                <div class="form-group" v-if="type===0">
                    <input type="text" name="address" class="form-control" v-model="address"
                           placeholder="Адрес доставки">
                </div>
                <div class="form-group">
                    <textarea name="message" v-model="message" class="form-control"
                              placeholder="Текст сообщения"></textarea>
                </div>


                <div class="form-group mb-2">
                    <obedy-voice-callback :phone="phone" :name="name" :cansend="cansend"></obedy-voice-callback>
                </div>
                <div class="form-group">
                    <button type="submit"
                            class="btn btn-danger w-100 p-3 text-uppercase font-weight-bold mr-1 mb-1 w-100">
                        <i class="icon ion-md-mail"></i>
                        Отправить
                    </button>
                </div>
                <div class="form-group mb-2 d-flex justify-content-center">

                    <a v-b-modal.delivery class="btn btn-link mr-1 mb-1" title="Подробности о доставке"
                       aria-label="Подробности о доставке">
                        <i class="icon ion-ios-filing"></i>
                        Подробности о доставке!
                    </a>

                </div>


            </form>
        </div>

</template>
<script>
    import {mask} from 'vue-the-mask'
    import ObedyVoiceCallback from './ObedyVoiceCallback'

    export default {
        props: {
            selected_type: {
                type: Number,
                default: function () {
                    return 0;
                }
            },
        },
        mounted() {
            this.type = this.selected_type
        },
        data() {
            return {
                name: localStorage.getItem("food_first_name", ''),
                phone: localStorage.getItem("fastoran_phone", ''),
                type: 0,
                message: '',
                address: '',
                cansend: false,
                question_types: [
                    "Оформление заказа",
                    "Проблемы с заказом",
                    "Стать партнером",
                    "Стать доставщиком",
                    "Реклама и продвижение",
                    "Другие вопросы"
                ],
                dialog_titles: [
                    "Оформить заказ голосом",
                    "Опиши свои проблемы",
                    "Давай совместно работать",
                    "Давай совместно работать",
                    "Давай совместно работать",
                    "Что-то другое..."
                ]
            };
        },
        methods: {

            sendRequest: function (e) {
                e.preventDefault();
                this.cansend = true;
                axios
                    .post('../api/v2/obedy/wish', {
                        from: this.name,
                        phone: this.phone,
                        address: this.address,
                        message: "<b>" + this.question_types[this.type] + "</b>:\n" + this.message
                    })
                    .then(response => {
                        this.sendMessage("Сообщение успешно отправлено");
                        $('#contactModalBox').modal('hide')
                        this.name = "";
                        this.phone = "";
                        this.message = "";
                        this.cansend = false;
                    })


            },
            sendMessage(message) {
                this.$notify({
                    group: 'info',
                    type: 'success',
                    title: 'Отправка сообщений ОбедыGo',
                    text: message
                });
            },
        },
        directives: {mask},
        components:{
            ObedyVoiceCallback
        }
    }
</script>

<style lang="scss">
    .obedy-callback-card {

    }
</style>
