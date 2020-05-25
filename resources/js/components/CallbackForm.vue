<template>
    <div>
        <form @submit="sendRequest">
            <div class="single-contact-form row">
                <div class="col-md-12 mb-2">
                    <input type="text" name="name" class="form-control" v-model="name" placeholder="Ваше Ф.И.О."
                           required>
                </div>
                <div class="col-md-12 mb-2">
                    <input type="text" name="phone" class="form-control" v-model="phone"
                           pattern="[\+]\d{2} [\(]\d{3}[\)] \d{3}[\-]\d{2}[\-]\d{2}"
                           maxlength="19"
                           v-mask="['+38 (###) ###-##-##']"
                           placeholder="Номер телефона" required>
                </div>
                <!-- <div class="col-md-12 mb-2">
                     <input type="email" name="email" class="form-control" v-model="email" placeholder="Ваша почта">
                 </div>-->
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
            <div class="single-contact-form row" v-if="is_partner">
                <div class="col-md-12 mb-2">
                    <h4>Вы...</h4>
                    <select name="partner-type" v-model="partner" class="form-control" :options="partner_types"
                            required>
                        <option v-for="(option,index) in partner_types" :value="index">
                            {{option}}
                        </option>
                    </select>
                </div>
            </div>

            <div class="single-contact-form row" v-if="is_delivery_man">
                <div class="col-md-12 mb-2">
                    <h4>Способ доставки</h4>
                    <select name="partner-type" v-model="deliveryman" class="form-control" :options="deliveryman_types"
                            required>
                        <option v-for="(option,index) in deliveryman_types" :value="index">
                            {{option}}
                        </option>
                    </select>
                </div>
            </div>
            <div class="single-contact-form row">
                <div class="col-md-12">
                    <textarea name="message" v-model="message" class="form-control"
                              placeholder="Текст сообщения" required></textarea>
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
                type: null,
                partner: 0,
                deliveryman: 0,
                is_partner: false,
                is_delivery_man: false,
                message: '',
                partner_types: [
                    "Владелец ресторна",
                    "Владелец магазина",
                    "Предоставляете услуги",
                    "Другое",

                ],
                deliveryman_types: [
                    "На машине",
                    "Пешком",
                    "Велосипед",
                    "Мопед",
                    "Другое",
                ],
                question_types: [
                    "Вопросы по заказу",
                    "Стать партнером",
                    "Стать доставщиком",
                    "Реклама и продвижение",
                    "Другие вопросы"
                ]
            };
        },
        watch: {
            type: function (val) {
                this.is_partner = false;
                this.is_delivery_man = false;
                switch (val) {
                    case 1:
                        this.is_partner = true;
                        break;
                    case 2:
                        this.is_delivery_man = true;
                        break;
                }
            }
        },
        methods: {

            sendRequest: function (e) {
                e.preventDefault();
                axios
                    .post('../api/v1/wish', {
                        from: this.name,
                        phone: this.phone,
                        message: "*" + this.question_types[this.type] + "*:\n" + this.message + "\n"
                            + (this.is_partner ? this.partner_types[this.partner] + "\n" : "")
                            + (this.is_delivery_man ? this.deliveryman_types[this.deliveryman] : "")
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
