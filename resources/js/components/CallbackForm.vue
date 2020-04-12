<template>
    <div>
        <form @submit="sendRequest">
            <div class="single-contact-form row">
                <div class="col-md-6 mb-2">
                    <input type="text" name="name" class="form-control" v-model="name" placeholder="Ваше Ф.И.О.">
                </div>
                <div class="col-md-6 mb-2">
                    <input type="text" name="phone" class="form-control" v-model="phone"
                           pattern="[\+]\d{2} [\(]\d{3}[\)] \d{3}[\-]\d{2}[\-]\d{2}"
                           maxlength="19"
                           v-mask="['+38 (###) ###-##-##']"
                           placeholder="Номер телефона">
                </div>
                <div class="col-md-12 mb-2">
                    <input type="email" name="email" class="form-control" v-model="email" placeholder="Ваша почта">
                </div>
            </div>
            <div class="single-contact-form row">
                <div class="col-md-12 mb-2">
                    <select name="question-type" v-model="type" class="form-control" :options="question_types" required>
                        <option v-for="(option,index) in question_types" :value="index">
                            {{option}}
                        </option>
                    </select>
                </div>
            </div>
            <div class="single-contact-form row">
                <div class="col-md-12">
                    <textarea name="message" v-model="message" class="form-control"
                              placeholder="Текст сообщения"></textarea>
                </div>
            </div>
            <div class="contact-btn">
                <button type="submit" class="food__btn" style="width: 100%">Отправить</button>
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
                email: '',
                type: 0,
                message: '',
                question_types: [
                    "Вопросы по заказу",
                    "Стать партнером",
                    "Стать доставщиком"
                ]
            };
        },
        methods: {
            async recaptcha() {
                // (optional) Wait until recaptcha has been loaded.
                await this.$recaptchaLoaded()

                return await this.$recaptcha('message')

                // Do stuff with the received token.
            },
            sendRequest: function (e) {
                e.preventDefault();

                this.recaptcha()
                    .then(() => {
                        axios
                            .post('../api/v1/wish', {
                                from: this.name,
                                email: this.email,
                                phone: this.phone,
                                message: "*" + this.question_types[this.type] + "*:\n" + this.message
                            })
                            .then(response => {
                                this.sendMessage("Сообщение успешно отправлено");
                                $('#contactModalBox').modal('hide')
                                this.name="";
                                this.email = "";
                                this.phone = "";
                                this.message = "";
                            });
                    });


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
