<template>
    <div>
        <notifications group="message"/>

        <b-container fluid>
            <b-tabs content-class="mt-3">
                <b-tab title="Все" active>
                    <!-- User Interface controls -->
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

                    <!-- Main table element -->
                    <b-table
                        show-empty
                        small
                        stacked="md"
                        :items="items"
                        :fields="fields"
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
                        <template v-slot:cell(action)="data">
                            <b-input-group size="sm">
                                <b-button @click="info(data.item, data.index, $event.target)" class="btn btn-info mr-1">
                                    <i class="fas fa-info"></i>
                                </b-button>
        <!--                        <b-button @click="data.toggleDetails" class="btn btn-info mr-1">-->
        <!--                            {{ data.detailsShowing ? 'Скрыть' : 'Показать' }}-->
        <!--                        </b-button>-->
                            </b-input-group>
                        </template>
                        <template v-slot:table-busy>
                            <div class="text-center text-primary my-2">
                                <b-spinner class="align-middle"></b-spinner>
                                <strong>Загрузка...</strong>
                            </div>
                        </template>
        <!--                <template v-slot:row-details="row">-->
        <!--                    <b-card>-->
        <!--                        <ul>-->
        <!--                            <li v-for="(value, key) in row.item" :key="key">-->
        <!--                                {{ key }}: {{ value }}-->
        <!--                            </li>-->
        <!--                        </ul>-->
        <!--                    </b-card>-->
        <!--                </template>-->
                    </b-table>
                </b-tab>
                <b-tab title="Удаленные">
                <b-row>
                    <b-col lg="6" class="my-1">
                        <b-form-group
                            label="Сортировка"
                            label-cols-sm="3"
                            label-align-sm="right"
                            label-size="sm"
                            label-for="sortBySelect1"
                            class="mb-0"
                        >
                            <b-input-group size="sm">
                                <b-form-select v-model="sortBy1" id="sortBySelect1" :options="sortOptions" class="w-75">
                                    <template v-slot:first>
                                        <option value="">-- none --</option>
                                    </template>
                                </b-form-select>
                                <b-form-select v-model="sortDesc1" size="sm" :disabled="!sortBy" class="w-25">
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
                            label-for="filterInput1"
                            class="mb-0"
                        >
                            <b-input-group size="sm">
                                <b-form-input
                                    v-model="filter1"
                                    type="search"
                                    id="filterInput1"
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
                            label-for="perPageSelect1"
                            class="mb-0"
                        >
                            <b-form-select
                                v-model="perPage1"
                                id="perPageSelect1"
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
                    :items="deleted_items"
                    :fields="fields"
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
<!--                            <b-button @click="restore(data.item.id)" class="btn btn-info mr-1 mb-1"-->
<!--                                      :disabled="data.item.id===null">-->
<!--                                <i class="fas fa-plus"></i>-->
<!--                            </b-button>-->
                            <b-button @click="info(data.item, data.index, $event.target)" class="btn btn-info mr-1 mb-1">
                                <i class="fas fa-info"></i>
                            </b-button>
                        </b-input-group>
                    </template>

                    <template v-slot:table-busy>
                        <div class="text-center text-primary my-2">
                            <b-spinner class="align-middle"></b-spinner>
                            <strong>Загрузка...</strong>
                        </div>
                    </template>
                </b-table>
            </b-tab>
            </b-tabs>
            <!-- Info modal -->
            <b-modal :id="infoModal.id" :title="infoModal.title" ok-only @hide="resetInfoModal">
                <pre>{{ infoModal.content }}</pre>
            </b-modal>
        </b-container>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                sortBy: 'order_id',
                sortDesc: true,
                fields: [
                    {key: 'order_id', label: 'Идентификатор заказа', sortable: true, sortDirection: 'desc'},
                    {key: 'product_id', label: 'Идентификатор продутка', sortable: true, sortDirection: 'desc'},
                    {key: 'count', label: 'Количество', sortable: true, sortDirection: 'desc'},
                    {key: 'price', label: 'К оплате', sortable: true, sortDirection: 'desc'},
                    {key: 'action', label: 'Действие'},
                ],
                items: [],
                deleted_items: [],

                totalRows: 1,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15, 25, 50, 100],
                sortDirection: 'asc',
                filter: null,
                filterOn: [],
                infoModal: {
                    id: 'info-modal',
                    title: '',
                    content: ''
                },
                loading: false,

                sortBy1: 'order_id',
                sortDesc1: true,
                totalRows1: 1,
                currentPage1: 1,
                perPage1: 5,
                sortDirection1: 'asc',
                filter1: null,
                filterOn1: [],
            }
        },
        computed: {
            sortOptions() {
                // Create an options list from our fields
                return this.fields
                    .filter(f => f.sortable)
                    .map(f => {
                        return {text: f.label, value: f.key}
                    })
            }
        },
        created() {
            this.loadData()
        },
        methods: {
            info(item, index, button) {
                this.infoModal.title = `Row index: ${index}`
                this.infoModal.content = JSON.stringify(item, null, 2)
                this.$root.$emit('bv::show::modal', this.infoModal.id, button)
            },
            resetInfoModal() {
                this.infoModal.title = ''
                this.infoModal.content = ''
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems ? filteredItems.length : 0
                this.currentPage = 1
            },
            onFiltered1(filteredItems) {
                this.totalRows1 = filteredItems ? filteredItems.length : 0
                this.currentPage1 = 1
            },

            async loadData() {
                this.loading = true;
                const response = await axios
                    .get('/admin/order_details/get')
                    .then(resp => {
                        this.items = resp.data.order_details;
                        this.totalRows = this.items ? this.items.length : 0;
                        this.deleted_items = resp.data.deleted_order_details;
                        this.totalRows1 = this.deleted_items ? this.deleted_items.length : 0;
                        this.loading = false;
                    });
            },
        }
    }
</script>
