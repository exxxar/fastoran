<template>
    <div>
        <notifications group="message"/>
        <div class="row">
            <div class="col-lg-4">
                <b-button variant="primary" class="mt-4 mb-4" target="_blank" href="/admin/statistics">Статистика</b-button>
            </div>
        </div>
        <div class="row">

            <!-- kitchen total count -->
            <div class="col-lg-4">
                <div class="card mb-3 text-center">
                    <div class="card-body">
                        <span class="lw-dashboard-count" style="font-size: 50px;color: black;">{{data.kitchen_count}}</span>
                    </div>
                    <div class="card-footer">
                        <span class="lw-dashboard-label">Кухонь</span>
                    </div>
                </div>
            </div>
            <!-- kitchen total count -->

            <!-- product total count -->
            <div class="col-lg-4">
                <div class="card mb-3 text-center">
                    <div class="card-body">
                        <span class="lw-dashboard-count" style="font-size: 50px;color: black;">{{data.menu_count}}</span>
                    </div>
                    <div class="card-footer">
                        <span class="lw-dashboard-label">Товаров в меню</span>
                    </div>
                </div>
            </div>
            <!-- product total count -->
            <!-- menu category total count -->
            <div class="col-lg-4">
                <div class="card mb-3 text-center">
                    <div class="card-body">
                        <span class="lw-dashboard-count" style="font-size: 50px;color: black;">{{data.menu_category_count}}</span>
                    </div>
                    <div class="card-footer">
                        <span class="lw-dashboard-label">Категорий в меню</span>
                    </div>
                </div>
            </div>
            <!-- menu category total count -->
        </div>
        <div class="row">
            <!-- restoran total count -->
            <div class="col-lg-4">
                <div class="card mb-3 text-center">
                    <div class="card-body">
                        <span class="lw-dashboard-count" style="font-size: 50px;color: black;">{{data.restoran_count}}</span>
                    </div>
                    <div class="card-footer">
                        <span class="lw-dashboard-label">Ресторанов</span>
                    </div>
                </div>
            </div>
            <!-- restoran total count -->

            <!-- order total count -->
            <div class="col-lg-4">
                <div class="card mb-3 text-center">
                    <div class="card-body">
                        <span class="lw-dashboard-count" style="font-size: 50px;color: black;">{{data.orders_count[0]}}</span>
                    </div>
                    <div class="card-footer">
                        <span class="lw-dashboard-label">Заказов</span>
                    </div>
                </div>
            </div>
            <!-- order total count -->

            <!-- user total count -->
            <div class="col-lg-4">
                <div class="card mb-3 text-center">
                    <div class="card-body">
                        <span class="lw-dashboard-count" style="font-size: 50px;color: black;">{{data.users_count[0]}}</span>
                    </div>
                    <div class="card-footer">
                        <span class="lw-dashboard-label">Пользователей</span>
                    </div>
                </div>
            </div>
            <!-- user total count -->

        </div>
        <div class="row">
            <!-- restoran total count -->
            <div class="col-lg-4">
                <div class="card mb-3 text-center">
                    <div class="card-body">
                        <span class="lw-dashboard-count" style="font-size: 50px;color: black;">{{data.orders_sum}}</span>
                    </div>
                    <div class="card-footer">
                        <span class="lw-dashboard-label">Общая сумма заказов</span>
                    </div>
                </div>
            </div>
            <!-- restoran total count -->

            <!-- order total count -->
            <div class="col-lg-4">
                <div class="card mb-3 text-center">
                    <div class="card-body">
                        <span class="lw-dashboard-count" style="font-size: 50px;color: black;">{{data.delivery_range}}</span>
                    </div>
                    <div class="card-footer">
                        <span class="lw-dashboard-label">Общий километраж</span>
                    </div>
                </div>
            </div>
            <!-- order total count -->

            <!-- user total count -->
            <div class="col-lg-4">
                <div class="card mb-3 text-center">
                    <div class="card-body">
                        <span class="lw-dashboard-count" style="font-size: 50px;color: black;">{{data.delivery_price}}</span>
                    </div>
                    <div class="card-footer">
                        <span class="lw-dashboard-label">Общая сумма доставки</span>
                    </div>
                </div>
            </div>
            <!-- user total count -->

        </div>
        <div class="row">
            <!-- product count chart -->
            <div class="col-lg-6">
                <div class="card mb-3">
                    <div class="card-header">

                        <strong>Заказы</strong>
                        <span class="pull-right">
                                <a href="/admin/orders" title="Orders"><i class="fa fa-chevron-circle-right"></i></a>
                            </span>
                    </div>
                    <div class="lw-dashboard-card">
                        <highcharts v-if="data.orders_count[0] > 0" :options="ordersChartOptions"></highcharts>
                        <div class="card-body">
                            <div v-if="data.orders_count[0]==0">
                              Заказы не найдены
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / product count chart -->
            <!-- product count chart -->
            <div class="col-lg-6">
                <div class="card mb-3">
                    <div class="card-header">

                        <strong>Пользователи</strong>
                        <span class="pull-right">
                                <a href="/admin/users" title="Orders"><i class="fa fa-chevron-circle-right"></i></a>
                            </span>
                    </div>
                    <div class="lw-dashboard-card">
                        <highcharts v-if="data.users_count[0] > 0" :options="usersChartOptions"></highcharts>
                        <div class="card-body">
                            <div v-if="data.users_count[0]==0">
                                Пользователи не найдены
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>Рассчитать параметры доставки</strong>
                    </div>
                    <div class="lw-dashboard-card">
                        <div class="row p-4">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-12 mb--20">
                                        <b-form-select v-model="rest_id" :options="restorans" @change="changeRestoran"></b-form-select>
                                    </div>
                                    <div class="col-12 mb--20">
                                        <b-form-select v-model="delivery.city" :options="cities"></b-form-select>
                                    </div>
                                    <div class="col-12 mb--20">
                                        <b-form-input placeholder="Улица" type="text" v-model="delivery.street"></b-form-input>
                                    </div>
                                    <div class="col-md-6 col-12 mb--20">
                                        <b-form-input placeholder="Номер дома" type="text"
                                                      v-model="delivery.home_number"></b-form-input>
                                    </div>

                                    <div class="col-md-6 col-12 mb--20">
                                        <b-form-input placeholder="Номер квартиры" type="text"
                                                      v-model="delivery.flat_number"></b-form-input>
                                    </div>
                                    <div class="col-12 mb--20 text-center m-auto">
                                        <button type="button" class="btn btn-primary" @click="getRangePrice">
                                            Рассчитать параметры доставки
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div v-if="delivery_loading" class="d-flex align-items-center justify-content-center m-auto" style="height: 100%; width: 100%;">
                                    <b-spinner style="width: 3rem; height: 3rem;" label="Large Spinner"></b-spinner>
                                    <h2 style="height: 3rem;" class="mt-auto mb-auto ml-3">
                                        Загрузка...
                                    </h2>
                                </div>
                                <b-list-group v-if="!delivery_loading">
                                    <b-list-group-item class="flex-column align-items-start">
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="mb-1">
                                                   <span class="amount">Километраж: {{delivery_range}}
                                                   </span>
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-1">
                                                   <span class="amount">Цена: {{deliveryPrice| currency}}
                                                   </span>
                                                </p>
                                            </div>
                                        </div>
                                    </b-list-group-item>
                                    <b-list-group-item class="flex-column align-items-start">
                                        <div class="row">
                                            <div class="col-6">
                                                <p class="mb-1">
                                                   <span class="amount">Широта: {{this.coords.latitude}}
                                                   </span>
                                                </p>
                                            </div>
                                            <div class="col-6">
                                                <p class="mb-1">
                                                   <span class="amount">Долгота: {{this.coords.longitude}}
                                                   </span>
                                                </p>
                                            </div>
                                        </div>
                                    </b-list-group-item>
                                </b-list-group>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>Форма смс рассылки</strong>
                    </div>
                    <div class="lw-dashboard-card">
                        <div class="row p-4 m-auto" style="width:100%;overflow: hidden;">
                            <div class="col-md-6">
                                <b-form-radio-group
                                    v-model="message_type"
                                    :options="options"
                                    @change="changeMessageType"
                                    :disabled="loading"
                                ></b-form-radio-group>
                                <div class="text-center ml-auto mr-auto mt-3" v-if="message_type=='one'">
                                    <b-form-input type="text"
                                        placeholder="Введите номер телефона пользователя"
                                        name="phone"
                                        v-model="phone"
                                        required
                                        :disabled="loading"
                                        pattern="[\+]\d{2} [\(]\d{3}[\)] \d{3}[\-]\d{2}[\-]\d{2}"
                                        maxlength="19"
                                        v-mask="['+38 (###) ###-##-##']">
                                    </b-form-input>
                                </div>
                                <div class="ml-auto mr-auto" v-if="message_type=='file'">
                                    <b-row>
                                        <b-col lg="12" class="my-1">
                                            <div class="filezone" v-if="file==null">
                                                <input type="file" id="file" ref="file" v-on:change="handleFiles()" :disabled="loading"/>
                                                <p>
                                                    Перетащите файл сюда <br>или нажмите для поиска
                                                </p>
                                            </div>
                                            <b-list-group-item class="flex-column align-items-start" style="border-radius: 0.25rem;" v-if="file!=null">
                                                <div class="row pt-5 pb-5">
                                                    <div class="col-6">
                                                        <p class="mb-1">
                                                           <span class="amount">Файл: {{this.file.name}}</span>
                                                        </p>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="remove-container" style="float: right;">
                                                            <a class="remove" style="color: red;cursor: pointer;" v-on:click="removeFile()">Удалить</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </b-list-group-item>
                                            <hr>
                                        </b-col>
                                    </b-row>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>Сообщение: </label>
                                <div class="text-center m-auto">
                                    <b-form-textarea
                                        id="textarea"
                                        v-model="message"
                                        placeholder="Введите сообщение..."
                                        rows="8"
                                        max-rows="8"
                                        :disabled="loading">
                                    </b-form-textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center mt-3 mb-4 text-center">
                            <button class="btn btn-primary" @click="sendSms" :disabled="loading">Отправить</button>
                        </div>
<!--                        <div class="row p-4" style="width:100%;">-->
<!--                            <div class="col-md-6 text-center ml-auto mr-auto mb-3" v-if="message_type=='one'">-->
<!--                                <b-form-input type="text"-->
<!--                                              placeholder="Введите номер телефона пользователя"-->
<!--                                              name="phone"-->
<!--                                              v-model="phone"-->
<!--                                              required-->
<!--                                              pattern="[\+]\d{2} [\(]\d{3}[\)] \d{3}[\-]\d{2}[\-]\d{2}"-->
<!--                                              maxlength="19"-->
<!--                                              v-mask="['+38 (###) ###-##-##']">-->
<!--                                </b-form-input>-->
<!--                            </div>-->
<!--                            <div class="col-md-8 text-center ml-auto mr-auto mb-3" v-if="message_type=='file'">-->
<!--                                <b-row>-->
<!--                                    <b-col lg="12" class="my-1">-->
<!--                                        <div class="large-12 medium-12 small-12 filezone" >-->
<!--                                            <input type="file" id="files" ref="files" v-on:change="handleFiles()" :disabled="loading"/>-->
<!--                                            <p>-->
<!--                                                Перетащите файл сюда <br>или нажмите для поиска-->
<!--                                            </p>-->
<!--                                        </div>-->
<!--                                        <hr>-->
<!--                                    </b-col>-->
<!--                                </b-row>-->
<!--                            </div>-->
<!--                            <div class="col-md-8 text-center m-auto">-->
<!--                                <b-form-textarea-->
<!--                                    id="textarea"-->
<!--                                    v-model="message"-->
<!--                                    placeholder="Введите сообщение..."-->
<!--                                    rows="8"-->
<!--                                    max-rows="10">-->
<!--                                </b-form-textarea>-->
<!--                            </div>-->
<!--                        </div>-->
                    </div>
                </div>
            </div>
        </div>
        <!-- / product count chart -->
    </div>
</template>

<script>
    import {mask} from 'vue-the-mask'
    export default {
        props: ['data'],
        data() {
            return {
                ordersChartOptions: {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: 'Всего: '+this.data.orders_count[0] + ' шт.; Удалено: '+this.data.orders_count[1] + ' шт.'
                    },
                    tooltip: {
                        pointFormat: 'Кол-во: <b>{point.y} шт</b>; В процентах: <b>{point.percentage:.1f}%</b>'
                    },
                    accessibility: {
                        point: {
                            valueSuffix: 'шт'
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: false
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                        name: 'Заказы',
                        colorByPoint: true,
                        data: [{
                            name: 'В обработке',
                            y: this.data.orders_counts[0],
                            sliced: true,
                            selected: true
                        }, {
                            name: 'Готовится',
                            y: this.data.orders_counts[1]
                        }, {
                            name: 'В процессе доставки',
                            y: this.data.orders_counts[2]
                        }, {
                            name: 'Доставлен',
                            y: this.data.orders_counts[3]
                        }, {
                            name: 'Отклонен администратором',
                            y: this.data.orders_counts[4]
                        }]
                    }]
                },
                usersChartOptions: {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    title: {
                        text: 'Всего: '+this.data.users_count[0] + ' шт.; Удалено: '+this.data.users_count[1] + ' шт.'
                    },
                    tooltip: {
                        pointFormat: 'Кол-во: <b>{point.y} шт</b>; В процентах: <b>{point.percentage:.1f}%</b>'
                    },
                    accessibility: {
                        point: {
                            valueSuffix: 'шт'
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: false
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                        name: 'Пользователи',
                        colorByPoint: true,
                        data: [{
                            name: 'Активированные',
                            y: this.data.users_counts[1],
                            sliced: true,
                            selected: true
                        }, {
                            name: 'Неактивированные',
                            y: this.data.users_counts[0]
                        }]
                    }]
                },
                rest_id: null,
                delivery_range: 0,
                deliveryPrice: 0,
                restorans:[],
                cities: [
                    { value: null, text: 'Выберете город' },
                    { value: "Донецк", text: "Донецк" },
                    { value: "Макеевка", text: "Макеевка" },
                ],
                delivery: {
                    city: null,
                    street: '',
                    // first_name: '',
                    home_number: '',
                    flat_number: '',
                    // more_info: '',
                    // money_type: '0',
                },
                coords: {
                    latitude: 0,
                    longitude: 0
                },
                loading: false,
                delivery_loading: false,
                message_type: 'all',
                options: [
                    { text: 'Всем пользователям', value: 'all' },
                    { text: 'Одному пользователю', value: 'one' },
                    { text: 'Пользователям из файла', value: 'file' }
                ],
                phone:'',
                phones: [],
                file: null,
                message: 'Сообщение от сервиса Fastoran: ',
            }
        },
        created() {
            this.getRestorans();
            // this.loadData()
        },
        methods: {
            changeRestoran() {
                this.delivery_range = 0;
                this.deliveryPrice = 0;
                this.coords.latitude = 0;
                this.coords.longitude = 0;
            },
            async getRestorans() {
                this.loading = true;
                const response = await axios
                    .get(`/admin/restorans/getRestorans`)
                    .then(resp => {
                        this.restorans = resp.data.restorans;
                        this.restorans.push({ value: null, text: 'Выберете ресторан' })
                        this.loading = false;
                    });
            },
            // async loadData() {
            //
            // },
            getRangePrice() {
                if (this.rest_id != null) {
                    this.delivery_loading = true;
                    if (this.delivery.city != null && this.delivery.street != '' && this.delivery.home_number != '') {
                        let address = `г. ${this.delivery.city}, ${this.delivery.street}, ${this.delivery.home_number}`;
                        axios
                            .post("/admin/orders/range/" + this.rest_id, {
                                "address": address
                            }).then(resp => {
                            this.delivery_range = resp.data.range;
                            this.deliveryPrice = resp.data.price;
                            this.coords.latitude = resp.data.latitude;
                            this.coords.longitude = resp.data.longitude;
                            this.delivery_loading = false;
                        });
                    }
                }
            },
            changeMessageType(){
                this.phones=[];
                this.file = null;
            },
            handleFiles() {
                let uploadedFiles = this.$refs.file.files;
                if (/\.(xlsx|xls)$/i.test(uploadedFiles[0].name))
                {
                    this.file = uploadedFiles[0];
                }
                else
                {
                    this.sendMessage('Неверный формат файла', 'error')
                }

            },
            removeFile(){
                this.file = null;
            },
            sendMessage(message, type='success') {
                this.$notify({
                    group: 'message',
                    type: type,
                    title: 'Панель администратора',
                    text: message
                });
            },
            sendSms() {
                this.loading = true;
                if(this.phones !== [] && this.message !== '')
                {
                    if(this.message_type === 'all'){
                        axios
                            .get(`/admin/users/getPhones`)
                            .then(resp => {
                                this.phones = resp.data.phones;
                                this.sendMessage(resp.data.message);
                            });
                    }
                    if(this.message_type === 'one'){
                        this.phones = [];
                        this.phones.push(this.phone);
                    }
                    if(this.message_type === 'file'){
                        let formData = new FormData();
                        formData.append('file', this.file);
                        axios.post(`/admin/uploadPhones`,
                            formData,
                            {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            })
                            .then(resp => {
                                this.sendMessage(resp.data.message);
                                this.phones = resp.data.phones;
                                console.log(this.phones)
                            });
                    }
                    // axios.post(`/admin/sendMessage`, {
                    //     message: this.message,
                    //     phones: this.phones
                    // }).then(resp => {
                    //     this.sendMessage(resp.data.message);
                    // });
                }
                this.loading = false;
            },
        },
        directives: {mask}
    }
</script>

<style>
    .custom-control {
        margin-bottom: 13px;
    }
    input[type="file"]{
        opacity: 0;
        width: 100%;
        height: 150px;
        position: absolute;
        cursor: pointer;
    }
    .filezone {
        outline: 2px dashed grey;
        outline-offset: -10px;
        background: #ccc;
        color: dimgray;
        padding: 10px 10px;
        /*min-height: 200px;*/
        position: relative;
        cursor: pointer;
        border-radius: 0.25rem;
    }
    .filezone:hover {
        background: #c0c0c0;
    }

    .filezone p {
        font-size: 1.2em;
        text-align: center;
        padding: 50px 50px 50px 50px;
    }
</style>
