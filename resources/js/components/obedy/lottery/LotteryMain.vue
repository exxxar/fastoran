<template>
    <div>
        <div class="row">
            <div class="col-sm-12">
                <h2 class="text-danger">{{title}} </h2>
                <div v-if="is_active" class="badge badge-success">
                    Лотерея активна (до {{date_end}})
                </div>
                <div class="badge badge-danger" v-else>Лотерея не активна</div>
                <div class="badge badge-danger" v-if="is_complete">Лотерея окончена</div>
                <p>{{description}}</p>
            </div>
            <div class="col-sm-6 col-md-4 lottery-item-wrapper" v-for="n in place_count">
                <div class="lottery-item" @click="openAuthModal(n)">
                    <img v-lazy="'/img/logo_obed_go.jpg'" alt="" v-if="!isOccuped(n)">
                    <img v-lazy="'/img/logo_obed_go_occuped.jpg'" alt="" v-else>
                    <p> #{{n}}</p>
                </div>
            </div>

        </div>
        <b-modal id="personal-info" hide-footer title="Участие в розыгрыше">
            <from v-on:submit.prevent="pick" class="row d-flex justify-content-center">
                <div class="col-12">
                    <input type="text" class="form-control w-100 mb-2 p-4" placeholder="Промокод"
                           pattern="[\+]\d{2} [\(]\d{3}[\)] \d{3}[\-]\d{2}[\-]\d{2}"
                           maxlength="20"
                           v-mask="['##-##-##-##-##-##-##']"
                           required>
                </div>
                <h4 class="col-12 mb-2 mt-2">Для получение <span
                    class="text-danger font-weight-bolder">оповещения</span> о выигрыше Вам необходимо сообщить нам свой
                    номер
                    <span class="text-danger font-weight-bolder">телефона</span> и
                    <span class="text-danger font-weight-bolder">электронную почту</span></h4>
                <div class="col-12">
                    <input type="text" class="form-control w-100 mb-2 p-4" placeholder="Ваше имя">
                </div>
                <div class="col-12">
                    <input type="text" class="form-control w-100 mb-2 p-4" placeholder="Ваш номер телефона"
                           pattern="[\+]\d{2} [\(]\d{3}[\)] \d{3}[\-]\d{2}[\-]\d{2}"
                           maxlength="19"
                           v-mask="['+38 (071) ###-##-##']"
                           required>
                </div>
                <div class="col-12">

                    <input type="email" class="form-control w-100 mb-2 p-4" placeholder="Ваша почта" required>
                </div>


                <div class="col-12 col-sm-6">
                    <button class="btn btn-outline-success w-100" @click="pick">Занять место</button>
                </div>


            </from>

        </b-modal>
    </div>

</template>
<script>
    import {mask} from "vue-the-mask";

    export default {
        props: ["lottery_id"],
        data() {
            return {
                selected_place: null,
                image: '/img/go/lottery/lottery_1.png',
                occuped_places: [1, 3, 7, 10, 15],
                place_count: 20,
                title: 'Праздничная лотерея',
                is_active: true,
                is_complete: false,
                date_end: '25.12.2020',
                description: 'Simple description'
            }
        },
        mounted() {
            //Subscribe to the channel we specified in our Adonis Application
            pusher.subscribe('lottery-chanel').bind('lottery-event', (data) => {
                console.log("startRaffle", data)
            });
        },
        methods: {
            isOccuped(index) {
                return this.occuped_places.find(item => item === index) != null
            },
            openAuthModal(index) {
                if (this.isOccuped(index)) {
                    this.sendMessage("Данный слот уже кем-то занят! Попробуйте занять другой!", "error")
                    return;
                }
                this.selected_place = index;
                this.$bvModal.show('personal-info')

            },
            pick() {

                if (this.isOccuped(this.selected_place)) {
                    this.sendMessage("Данный слот уже кем-то занят! Попробуйте занять другой!", "error")
                    return
                }

                this.occuped_places.push(this.selected_place)

                axios
                    .post('/api/v2/obedy/lottery/pick', {
                        lottery_id: this.lottery_id,
                        place_id: this.selected_place
                    }).then(resp => {
                    console.log(resp)
                    this.sendMessage("Занятый слот успешно подверждено!")
                    this.$bvModal.hide('personal-info')
                }).catch(() => {
                    this.sendMessage("Ошибка занятия слота, попробуйте еще!", "error")
                    this.$bvModal.hide('personal-info')
                })

                this.selected_place = null;

            },
            sendMessage(message, type = 'success') {
                this.$notify({
                    group: 'info',
                    type: type,
                    title: 'Оповещение ОбедыGO',
                    text: message
                });
            },
        }
    }
</script>
<style lang="scss">
    .lottery-item-wrapper {
        padding: 15px;

        .lottery-item {
            width: 100%;
            display: flex;
            justify-content: center;
            position: relative;
            align-items: flex-end;
            box-shadow: 1px 1px 2px 0px #000000;
            border-radius: 5px;

            img {
                width: inherit;

            }

            p {
                position: absolute;
                font-family: fantasy;
                color: #cb3728;
            }


        }
    }

    #personal-info {
        h4 {
            font-size: 14px;
            line-height: 150%;
            font-family: 'Open Sans';
            text-align: justify;
        }
    }

</style>
