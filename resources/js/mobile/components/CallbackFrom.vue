<template>
    <div class="card mb-3">
        <form @submit="sendRequest" class="card-body">
            <h5 class="card-title">Форма обратной связи</h5>
            <div class="form-group">
                <input type="text" name="name" class="form-control" v-model="name" placeholder="Ваше Ф.И.О." required>
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
            <div class="form-group">
                    <textarea name="message" v-model="message" class="form-control"
                              placeholder="Текст сообщения" required></textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary mr-1 mb-1 w-100">
                    <i class="icon ion-md-mail"></i>
                    Отправить
                </button>
            </div>

            <div class="divider mb-2"></div>
            <div class="form-group mb-2">
                <mobile-voice-callback-form></mobile-voice-callback-form>
            </div>

            <div class="form-group mb-2">

                <button type="button" class="btn btn-link mr-1 mb-1">
                    <i class="icon ion-ios-filing"></i>
                    Пользовательское соглашение!
                </button>

            </div>

        </form>
    </div>
</template>
<script>
    import {mask} from 'vue-the-mask'


    export default {
        data() {
            return {
                name: '',
                phone: '',
                type: 0,
                message: '',
                question_types: [
                    "Вопросы по заказу",
                    "Стать партнером",
                    "Стать доставщиком",
                    "Реклама и продвижение",
                    "Другие вопросы"
                ]
            };
        },
        methods: {

            sendRequest: function (e) {
                e.preventDefault();
                axios
                    .post('../api/v1/wish', {
                        from: this.name,
                        phone: this.phone,
                        message: "*" + this.question_types[this.type] + "*:\n" + this.message
                    })
                    .then(response => {
                        this.sendMessage("Сообщение успешно отправлено");
                        $('#contactModalBox').modal('hide')
                        this.name = "";
                        this.phone = "";
                        this.message = "";
                    })


            },
            sendMessage(message) {
                this.$notify({
                    group: 'info',
                    type: 'success',
                    title: 'Отправка сообщений Fastoran',
                    text: message
                });
            },
        },
        directives: {mask}
    }
</script>
