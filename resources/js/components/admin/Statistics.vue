<template>
    <div>
        <div class="single-accordion" style="width: 100%;">
            <a class="accordion-head" href="#" aria-expanded="true" style="background-color: #3490dc;">Работа курьеров</a>
            <div class="accordion-body fix text-center">
                <b-row>
                    <b-col lg="6" class="my-1">
                        <b-form-group
                            label="Сортировка"
                            label-cols-sm="3"
                            label-align-sm="right"
                            label-size="sm"
                            label-for="sortBySelect"
                            class="mb-0"
                        >
                            <b-input-group size="sm">
                                <b-form-select v-model="sortBy" id="sortBySelect" :options="sortOptions" class="w-75">
                                    <template v-slot:first>
                                        <option value="">-- none --</option>
                                    </template>
                                </b-form-select>
                                <b-form-select v-model="sortDesc" size="sm" :disabled="!sortBy" class="w-25">
                                    <option :value="false">Asc</option>
                                    <option :value="true">Desc</option>
                                </b-form-select>
                            </b-input-group>
                        </b-form-group>
                    </b-col>

                    <b-col lg="6" class="my-1">
                        <b-form-group
                            label="Поиск"
                            label-cols-sm="3"
                            label-align-sm="right"
                            label-size="sm"
                            label-for="filterInput"
                            class="mb-0"
                        >
                            <b-input-group size="sm">
                                <b-form-input
                                    v-model="filter"
                                    type="search"
                                    id="filterInput"
                                    placeholder="Введите для поиска"
                                ></b-form-input>
                                <b-input-group-append>
                                    <b-button :disabled="!filter" @click="filter = ''">Очистить</b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </b-form-group>
                    </b-col>

                    <b-col sm="5" md="6" class="my-1">
                        <b-form-group
                            label="На странице"
                            label-cols-sm="6"
                            label-cols-md="4"
                            label-cols-lg="3"
                            label-align-sm="right"
                            label-size="sm"
                            label-for="perPageSelect"
                            class="mb-0"
                        >
                            <b-form-select
                                v-model="perPage"
                                id="perPageSelect"
                                size="sm"
                                :options="pageOptions"
                            ></b-form-select>
                        </b-form-group>
                    </b-col>

                    <b-col sm="7" md="6" class="my-1">
                        <b-pagination
                            v-model="currentPage"
                            :total-rows="totalRows"
                            :per-page="perPage"
                            align="fill"
                            size="sm"
                            class="my-0"
                        ></b-pagination>
                    </b-col>
                </b-row>
                <b-table
                    show-empty
                    small
                    stacked="md"
                    :items="deliverymans"
                    :fields="deliverymans_fields"
                    :current-page="currentPage"
                    :per-page="perPage"
                    :filter="filter"
                    :filterIncludedFields="filterOn"
                    :sort-by.sync="sortBy"
                    :sort-desc.sync="sortDesc"
                    :sort-direction="sortDirection"
                    @filtered="onFiltered"
                    :busy="loading"
                    empty-text="Нет записей для отображения"
                    empty-filtered-text="Нет записей, соответствующих вашему запросу"
                >
                    <template v-slot:cell(deliveryman_type)="data">
                            <b-form-select
                                v-model="data.item.deliveryman_type"
                                disabled
                                :options="delivery_types">
                            </b-form-select>
                    </template>
                    <template v-slot:cell(action)="data">
                        <b-input-group size="sm">
                            <b-button @click="info(data.item, data.index, $event.target)" class="btn btn-info mr-1 mb-1">
                                <i class="fas fa-info"></i>
                            </b-button>
                            <b-button @click="data.toggleDetails" class="btn btn-info mr-1 mb-1">

                                {{ data.detailsShowing ? 'Скрыть' : 'Показать' }}
                            </b-button>
                        </b-input-group>
                    </template>
                    <template v-slot:row-details="row">
                        <b-card>
                            <div class="row">
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Код доступа" label-size="sm" class="mb-0">
                                        <b-form-input type="text" disabled
                                                      :value="row.item.auth_code"
                                                      :placeholder="'Введите код доступа'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Телеграм ID" label-size="sm"
                                                  class="mb-0">
                                        <b-form-input type="text" disabled :value="row.item.telegram_chat_id"
                                                      @blur="save($event.target.value,row.item.id,'telegram_chat_id')"
                                                      :placeholder="'Телеграм ID'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Бонус" label-size="sm" class="mb-0">
                                        <b-form-input type="number" disabled :value="row.item.bonus"
                                                      @blur="save($event.target.value,row.item.id,'bonus')"
                                                      :placeholder="'Бонус'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Дата рождения" label-size="sm"
                                                  class="mb-0">
                                        <b-form-input type="date" disabled :value="row.item.birthday"
                                                      :placeholder="'Дата рождения'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Адрес" label-size="sm" class="mb-0">
                                        <b-form-input type="text" disabled :value="row.item.adress"
                                                      :placeholder="'Адрес'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Активация" label-size="sm" class="mb-0">
                                        <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary">
                                            <input class="c-switch-input" type="checkbox" disabled
                                                   name="active" :checked="row.item.active">
                                            <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                        </label>
                                    </b-form-group>
                                </div>
                            </div>
                        </b-card>
                    </template>

                    <template v-slot:table-busy>
                        <div class="text-center text-primary my-2">
                            <b-spinner class="align-middle"></b-spinner>
                            <strong>Загрузка...</strong>
                        </div>
                    </template>
                </b-table>
            </div>
        </div>
        <div class="single-accordion" style="width: 100%;">
            <a class="accordion-head" href="#" aria-expanded="true" style="background-color: #3490dc;">Пользователи</a>
            <div class="accordion-body fix text-center">
                <b-row>
                    <b-col lg="6" class="my-1">
                        <b-form-group
                            label="Сортировка"
                            label-cols-sm="3"
                            label-align-sm="right"
                            label-size="sm"
                            label-for="sortBySelect"
                            class="mb-0"
                        >
                            <b-input-group size="sm">
                                <b-form-select v-model="sortBy1" id="sortBySelect" :options="sortOptions1" class="w-75">
                                    <template v-slot:first>
                                        <option value="">-- none --</option>
                                    </template>
                                </b-form-select>
                                <b-form-select v-model="sortDesc1" size="sm" :disabled="!sortBy1" class="w-25">
                                    <option :value="false">Asc</option>
                                    <option :value="true">Desc</option>
                                </b-form-select>
                            </b-input-group>
                        </b-form-group>
                    </b-col>

                    <b-col lg="6" class="my-1">
                        <b-form-group
                            label="Поиск"
                            label-cols-sm="3"
                            label-align-sm="right"
                            label-size="sm"
                            label-for="filterInput"
                            class="mb-0"
                        >
                            <b-input-group size="sm">
                                <b-form-input
                                    v-model="filter1"
                                    type="search"
                                    id="filterInput"
                                    placeholder="Введите для поиска"
                                ></b-form-input>
                                <b-input-group-append>
                                    <b-button :disabled="!filter1" @click="filter1 = ''">Очистить</b-button>
                                </b-input-group-append>
                            </b-input-group>
                        </b-form-group>
                    </b-col>


                    <b-col sm="5" md="6" class="my-1">
                        <b-form-group
                            label="На странице"
                            label-cols-sm="6"
                            label-cols-md="4"
                            label-cols-lg="3"
                            label-align-sm="right"
                            label-size="sm"
                            label-for="perPageSelect"
                            class="mb-0"
                        >
                            <b-form-select
                                v-model="perPage1"
                                id="perPageSelect"
                                size="sm"
                                :options="pageOptions"
                            ></b-form-select>
                        </b-form-group>
                    </b-col>

                    <b-col sm="7" md="6" class="my-1">
                        <b-pagination
                            v-model="currentPage1"
                            :total-rows="totalRows1"
                            :per-page="perPage1"
                            align="fill"
                            size="sm"
                            class="my-0"
                        ></b-pagination>
                    </b-col>
                </b-row>
                <b-table
                    show-empty
                    small
                    stacked="md"
                    :items="users"
                    :fields="users_fields"
                    :current-page="currentPage1"
                    :per-page="perPage1"
                    :filter="filter1"
                    :filterIncludedFields="filterOn1"
                    :sort-by.sync="sortBy1"
                    :sort-desc.sync="sortDesc1"
                    :sort-direction="sortDirection1"
                    @filtered="onFiltered1"
                    :busy="loading"
                    empty-text="Нет записей для отображения"
                    empty-filtered-text="Нет записей, соответствующих вашему запросу"
                >
                    <template v-slot:cell(action)="data">
                        <b-input-group size="sm">
                            <b-button @click="info(data.item, data.index, $event.target)" class="btn btn-info mr-1 mb-1">
                                <i class="fas fa-info"></i>
                            </b-button>
                            <b-button @click="data.toggleDetails" class="btn btn-info mr-1 mb-1">
                                {{ data.detailsShowing ? 'Скрыть' : 'Показать' }}
                            </b-button>
                        </b-input-group>
                    </template>
                    <template v-slot:row-details="row">
                        <b-card>
                            <div class="row">
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Код доступа" label-size="sm" class="mb-0">
                                        <b-form-input type="text" disabled
                                                      :value="row.item.auth_code"
                                                      :placeholder="'Введите код доступа'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Телеграм ID" label-size="sm"
                                                  class="mb-0">
                                        <b-form-input type="text" disabled :value="row.item.telegram_chat_id"
                                                      @blur="save($event.target.value,row.item.id,'telegram_chat_id')"
                                                      :placeholder="'Телеграм ID'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Бонус" label-size="sm" class="mb-0">
                                        <b-form-input type="number" disabled :value="row.item.bonus"
                                                      @blur="save($event.target.value,row.item.id,'bonus')"
                                                      :placeholder="'Бонус'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Дата рождения" label-size="sm"
                                                  class="mb-0">
                                        <b-form-input type="date" disabled :value="row.item.birthday"
                                                      :placeholder="'Дата рождения'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Адрес" label-size="sm" class="mb-0">
                                        <b-form-input type="text" disabled :value="row.item.adress"
                                                      :placeholder="'Адрес'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Активация" label-size="sm" class="mb-0">
                                        <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary">
                                            <input class="c-switch-input" type="checkbox" disabled
                                                   name="active" :checked="row.item.active">
                                            <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                        </label>
                                    </b-form-group>
                                </div>
                            </div>
                        </b-card>
                    </template>

                    <template v-slot:table-busy>
                        <div class="text-center text-primary my-2">
                            <b-spinner class="align-middle"></b-spinner>
                            <strong>Загрузка...</strong>
                        </div>
                    </template>
                </b-table>
            </div>
        </div>
        <div class="single-accordion" style="width: 100%;">
            <a class="accordion-head" href="#" aria-expanded="true" style="background-color: #3490dc;">Заказы</a>
            <div class="accordion-body fix text-center">
                <div class="row align-items-center">
                    <div class="col-sm-12 col-md-4 mb-2">
                        <label for="start-datepicker">Выберете начальную дату:</label>
                        <b-form-datepicker id="start-datepicker" v-model="startDate" locale="ru" close-button label-close-button="Закрыть"></b-form-datepicker>
                    </div>
                    <div class="col-sm-12 col-md-4 mb-2">
                        <label for="end-datepicker">Выберете конечную дату:</label>
                        <b-form-datepicker id="end-datepicker" v-model="endDate" :max="max" locale="ru" close-button label-close-button="Закрыть"></b-form-datepicker>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <b-button variant="primary" class="mt-4" style="float:left" @click="getOrdersByDate">Показать</b-button>
                    </div>
                </div>
                <highcharts :options="ordersChartOptions"></highcharts>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                deliverymans:[],
                deliverymans_fields: [
                    {key: 'name', label: 'Имя', sortable: true, sortDirection: 'desc'},
                    {key: 'phone', label: 'Телефон', sortable: true, sortDirection: 'desc'},
                    {key: 'deliveryman_type', label: 'Тип курьера', sortable: true, sortDirection: 'desc'},
                    {key: 'orders_count', label: 'Кол-во заказов', sortable: true, sortDirection: 'desc'},
                    {key: 'delivery_range', label: 'Общий километраж', sortable: true, sortDirection: 'desc'},
                    {key: 'delivery_price', label: 'Общая сумма доставки', sortable: true, sortDirection: 'desc'},
                    {key: 'summary_price', label: 'Сумма заказов', sortable: true, sortDirection: 'desc'},
                    {key: 'action', label: 'Действие'},
                ],
                users: [],
                users_fields: [
                    {key: 'name', label: 'Имя', sortable: true, sortDirection: 'desc'},
                    {key: 'phone', label: 'Телефон', sortable: true, sortDirection: 'desc'},
                    {key: 'orders_count', label: 'Кол-во заказов', sortable: true, sortDirection: 'desc'},
                    {key: 'summary_price', label: 'Сумма заказов', sortable: true, sortDirection: 'desc'},
                    {key: 'action', label: 'Действие'},
                ],
                types: [
                    { value: 0, text: 'Пользователь' },
                    { value: 1, text: 'Курьер' },
                    { value: 2, text: 'Администратор' },
                ],
                delivery_types: [
                    { value: 0, text: 'Не установлено' },
                    { value: 1, text: 'Пеший' },
                    { value: 2, text: 'Велосипед' },
                    { value: 3, text: 'Мотоцикл' },
                    { value: 4, text: 'Машина' },
                ],

                sortBy: 'name',
                sortDesc: false,
                totalRows: 1,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15, 25, 50, 100],
                sortDirection: 'asc',
                filter: null,
                filterOn: [],

                sortBy1: 'name',
                sortDesc1: false,
                totalRows1: 1,
                currentPage1: 1,
                perPage1: 5,
                sortDirection1: 'asc',
                filter1: null,
                filterOn1: [],

                loading: false,

                ordersChartOptions: {
                    chart: {
                        type: 'column'
                    },
                    lang: {
                        drillUpText: '◁ Назад к {series.name}'
                    },
                    title: {
                        text: 'Статистика заказов'
                    },
                    subtitle: {
                        text: 'Нажмите на колонку, чтобы посмотреть кол-во заказов по месяцам/по дням'
                    },
                    accessibility: {
                        announceNewData: {
                            enabled: true
                        }
                    },
                    xAxis: {
                        type: 'category',
                        title: {
                            text: 'Год/Месяц/День'
                        }
                    },
                    yAxis: {
                        title: {
                            text: 'Количество заказов'
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    plotOptions: {
                        series: {
                            borderWidth: 0,
                            dataLabels: {
                                enabled: true,
                                format: '{point.y} шт'
                            }
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y} шт</b><br/>'
                    },
                    series: [
                        {
                            name: "Заказов в год",
                            colorByPoint: true,
                            data: [
                            ]
                        }
                    ],
                    drilldown: {
                        series: [
                            {
                            },
                        ]
                    }
                },

                startDate: '',
                endDate: '',
                max: '',
            }
        },
        computed: {
            sortOptions() {
                return this.deliverymans_fields
                    .filter(f => f.sortable)
                    .map(f => {
                        return {text: f.label, value: f.key}
                    })
            },
            sortOptions1() {
                return this.users_fields
                    .filter(f => f.sortable)
                    .map(f => {
                        return {text: f.label, value: f.key}
                    })
            }
        },
        created() {
            // const now = new Date()
            // const today = new Date(now.getFullYear(), now.getMonth(), now.getDate())
            this.max = new Date();
            this.endDate = new Date();
            var year = new Date().getFullYear();
            this.startDate = new Date(year-2, 0, 1);
            var start = this.startDate.getFullYear() +'-'+(this.startDate.getMonth()+1)+'-'+ this.startDate.getDate();
            var end = this.endDate.getFullYear() +'-'+(this.endDate.getMonth()+1)+'-'+ this.endDate.getDate();
            this.endDate = end;
            this.startDate = start;
            // 15th two months prior
            // const minDate = new Date(today)
            // minDate.setMonth(minDate.getMonth() - 2)
            // minDate.setDate(15)
            // 15th in two months
            // this.startDate = new Date().setFullYear(new Date().getFullYear()-2, 0, 1);
            // const maxDate = new Date(today)
            // maxDate.setMonth(maxDate.getMonth() + 2)
            // maxDate.setDate(15)
            this.loadData()
        },
        methods: {
            async loadData() {
                this.loading = true;
                const response = await axios.get('/admin/getStatistics');
                this.deliverymans  = response.data.deliverymans;
                this.users = response.data.users;
                this.ordersChartOptions.series[0].data = response.data.series;
                this.ordersChartOptions.drilldown.series = response.data.drilldown;
                console.log(this.ordersChartOptions);
                this.loading = false;
            },
            onFiltered(filteredItems) {
                this.totalRows = filteredItems.length;
                this.currentPage = 1
            },
            onFiltered1(filteredItems) {
                this.totalRows1 = filteredItems.length;
                this.currentPage1 = 1
            },
            async getOrdersByDate() {
                // var start = this.startDate.getFullYear() +'-'+this.startDate.getMonth()+'-'+ this.startDate.getDate();
                // var end = this.endDate.getFullYear() +'-'+this.endDate.getMonth()+'-'+ this.endDate.getDate();

                const response = await axios.get(`/admin/getOrdersByDate/` + this.startDate + '/' + this.endDate);
                this.ordersChartOptions.series[0].data = response.data.series;
                this.ordersChartOptions.drilldown.series = response.data.drilldown;
            }
        }
    }
</script>

<style scoped>

</style>
