<template>
    <div>
        <div class="row" v-if="lottery">
            <div class="col-sm-12">
                <h2 class="text-danger">{{lottery.title}} </h2>
                <div v-if="lottery.is_active" class="badge badge-success">
                    Лотерея активна (до {{lottery.date_end}})
                </div>
                <div class="badge badge-danger" v-else>Лотерея не активна</div>
                <p v-if="current_slot_count">Доступное число активаций <strong>{{current_slot_count}}</strong></p>
                <div class="badge badge-danger" v-if="lottery.is_complete">Лотерея окончена</div>
                <p>{{lottery.description}}</p>

                <b-progress class="w-100" :value="lottery.place_count - lottery.free_place_count"
                            :max="lottery.place_count" variant="success" height="30px" animated>

                </b-progress>
            </div>
            <div class="col-sm-4 col-md-3 col-12 lottery-item-wrapper" v-for="n in lottery.place_count">
                <div class="lottery-item" @click="openAuthModal(n)">
                    <img v-lazy="'/img/logo_obed_go.jpg'" alt="" v-if="!isOccuped(n)">
                    <img v-lazy="'/img/logo_obed_go_occuped.jpg'" alt="" v-else>
                    <p> #{{n}}</p>
                </div>
            </div>


        </div>

        <div class="row" v-else>
            <div class="col-sm-12 d-flex justify-content-center align-items-center">
                <img v-lazy="'/img/logo_obed_go.jpg'" class="img-fluid" alt="">
            </div>

        </div>
        <b-modal id="personal-info" hide-footer title="Участие в розыгрыше">
            <form v-on:submit.prevent="pick" class="row d-flex justify-content-center">
                <div class="col-12">
                    <input type="text" class="form-control w-100 mb-2 p-4" placeholder="Промокод"
                           v-model="code"
                           required>
                </div>
                <div class="col-12">
                    <p v-if="message" class="alert alert-danger w-100">{{message}}</p>
                </div>
                <h4 class="col-12 mb-2 mt-2">Для получение <span
                    class="text-danger font-weight-bolder">оповещения</span> о выигрыше Вам необходимо сообщить нам свой
                    номер
                    <span class="text-danger font-weight-bolder">телефона</span> и
                    <span class="text-danger font-weight-bolder">электронную почту</span></h4>
                <div class="col-12">
                    <input type="text" class="form-control w-100 mb-2 p-4" placeholder="Ваше имя" v-model="name">
                </div>
                <div class="col-12">
                    <input type="text" class="form-control w-100 mb-2 p-4" placeholder="Ваш номер телефона"
                           pattern="[\+]\d{2} [\(]\d{3}[\)] \d{3}[\-]\d{2}[\-]\d{2}"
                           maxlength="19"
                           v-model="phone"
                           v-mask="['+38 (071) ###-##-##']"
                           required>
                </div>
                <div class="col-12">
                    <input type="email" class="form-control w-100 mb-2 p-4" placeholder="Ваша почта" v-model="email"
                           required>
                </div>


                <div class="col-12 col-sm-6">
                    <button class="btn btn-outline-success w-100">Занять место</button>
                </div>


            </form>

        </b-modal>

        <b-modal id="accept-lottery" hide-footer hide-header>
            <div class="row d-flex justify-content-center">
                <p v-if="current_slot_count">Доступное число активаций <strong>{{current_slot_count}}</strong></p>
            </div>
            <div class="row d-flex justify-content-center">
                <button class="mt-3 btn btn-danger mr-2"  @click="$bvModal.hide('accept-lottery')">Отменить</button>
                <button class="mt-3 btn btn-success"  @click="pick()">Подтвердить</button>
            </div>

        </b-modal>
    </div>

</template>
<script>
    import {mask} from "vue-the-mask";

    export default {
        directives: {
            mask
        },
        props: ["lottery_id"],
        data() {
            return {
                current_slot_count: null,
                message: null,
                selected_place: null,
                name: '',
                email: '',
                phone: '',
                code: '',
                lottery: null
            }
        },

        mounted() {

            this.loadLottery()

            pusher.subscribe('lottery-chanel').bind('lottery-event', (data) => {
                console.log("startRaffle", data)
                this.loadLottery()
            });
        },
        methods: {

            isOccuped(index) {

                let tmp = JSON.parse(this.lottery.occuped_places)

                if (tmp.length === 0)
                    return false;

                return tmp.find(item => item === index) != null
            },
            loadLottery() {
                axios
                    .get('/api/v2/obedy/lottery/get/' + this.lottery_id).then(resp => {
                    console.log(resp)
                    this.lottery = resp.data
                });
            },
            openAuthModal(index) {
                if (this.isOccuped(index)) {
                    this.sendMessage("Данный слот уже кем-то занят! Попробуйте занять другой!", "error")
                    return;
                }

                if (this.current_slot_count != null) {
                    this.selected_place = index;
                    this.$bvModal.show('accept-lottery')
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

                if (this.selected_place == null) {
                    this.sendMessage("Слот не выбран!", "error")
                    return
                }

                axios
                    .post('/api/v2/obedy/lottery/pick', {
                        lottery_id: this.lottery_id,
                        code: this.code,
                        name: this.name,
                        email: this.email,
                        phone: this.phone,
                        index: this.selected_place
                    }).then(resp => {
                    this.selected_place = null;

                    this.current_slot_count = resp.data.current_slot_count===0?null:resp.data.current_slot_count;

                    this.sendMessage("Спасибо! Слот успешно занят вами!")

                    this.$bvModal.hide('accept-lottery')
                    this.$bvModal.hide('personal-info')
                }).catch((resp) => {

                    this.message = resp.response.data.message

                })


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
