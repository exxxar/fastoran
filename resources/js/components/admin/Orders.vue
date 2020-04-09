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
                        <template v-slot:cell(status)="data">
                            <b-input-group size="sm">
                                <b-form-select
                                    v-model="data.item.status"
                                    :options="statuses"
                                    @change="save(data.item.status,data.item.id,'status')">
                                </b-form-select>
                            </b-input-group>
                        </template>
                        <template v-slot:cell(action)="data">
                            <b-input-group size="sm">
                                <b-button @click="remove(data.item.id)" class="btn btn-info mr-1 mb-1"
                                          :disabled="data.item.id===null">
                                    <i class="far fa-trash-alt"></i>
                                </b-button>
                                <b-button @click="info(data.item, data.index, $event.target)" class="btn btn-info mr-1 mb-1">
                                    <i class="fas fa-info"></i>
                                </b-button>
                                <b-button @click="details(data.item, data.index, $event.target)" class="btn btn-info mr-1 mb-1">
                                    Загрузить детали
                                </b-button>
                                <b-button @click="data.toggleDetails" class="btn btn-info mr-1 mb-1">
                                    {{ data.detailsShowing ? 'Скрыть' : 'Показать' }}
                                </b-button>
                                <div v-if="details_loading && detailsModal.content==data.item.id">
                                    <b-spinner small label="Loading..."></b-spinner> Загрузка...
                                </div>
                            </b-input-group>
                        </template>

                        <template v-slot:row-details="row">
                            <b-card>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Цена доставки" label-class="font-weight-bold" label-size="sm" class="mb-0">
<!--                                            <b-form-input type="text" disabled-->
<!--                                                          :value="row.item.delivery_price"-->
<!--                                                          @blur="save($event.target.value,row.item.id,'delivery_price')"-->
<!--                                                          :placeholder="'Введите цену доставки'">-->
<!--                                            </b-form-input>-->
                                            {{row.item.delivery_price}}
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Диапозон доставки" label-class="font-weight-bold" label-size="sm" class="mb-0">
<!--                                            <b-form-input type="text" disabled-->
<!--                                                          :value="row.item.delivery_range"-->
<!--                                                          @blur="save($event.target.value,row.item.id,'delivery_range')"-->
<!--                                                          :placeholder="'Введите диапозон доставки'">-->
<!--                                            </b-form-input>-->
                                            {{row.item.delivery_range}}
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Примечание доставки" label-class="font-weight-bold" label-size="sm" class="mb-0">
<!--                                            <b-form-input type="text" disabled-->
<!--                                                          :value="row.item.delivery_note"-->
<!--                                                          @blur="save($event.target.value,row.item.id,'delivery_note')"-->
<!--                                                          :placeholder="'Введите примечание доставки'">-->
<!--                                            </b-form-input>-->
                                            {{row.item.delivery_note}}
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Идентификатор получателя" label-class="font-weight-bold" label-size="sm" class="mb-0">
<!--                                            <b-form-input type="text" disabled-->
<!--                                                          :value="row.item.receiver_name"-->
<!--                                                          @blur="save($event.target.value,row.item.id,'receiver_name')"-->
<!--                                                          :placeholder="'Введите имя получателя'">-->
<!--                                            </b-form-input>-->
                                            {{row.item.user_id}}
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Телефон получателя" label-class="font-weight-bold" label-size="sm" class="mb-0">
<!--                                            <b-form-input type="text" disabled-->
<!--                                                          :value="row.item.receiver_phone"-->
<!--                                                          @blur="save($event.target.value,row.item.id,'receiver_phone')"-->
<!--                                                          :placeholder="'Введите телефон получателя'">-->
<!--                                            </b-form-input>-->
                                           {{row.item.receiver_phone}}
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Время доставки к получателю" label-class="font-weight-bold" label-size="sm" class="mb-0">
<!--                                            <b-form-input type="text" disabled-->
<!--                                                          :value="row.item.receiver_delivery_time"-->
<!--                                                          @blur="save($event.target.value,row.item.id,'receiver_delivery_time')"-->
<!--                                                          :placeholder="'Введите время доставки к получателю'">-->
<!--                                            </b-form-input>-->
                                            {{row.item.receiver_delivery_time}}
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Адрес получателя" label-class="font-weight-bold" label-size="sm" class="mb-0">
<!--                                            <b-form-input type="text" disabled-->
<!--                                                          :value="row.item.receiver_address"-->
<!--                                                          @blur="save($event.target.value,row.item.id,'receiver_address')"-->
<!--                                                          :placeholder="'Введите адрес получателя'">-->
<!--                                            </b-form-input>-->
                                            {{row.item.receiver_address}}
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Примечание получателя" label-class="font-weight-bold" label-size="sm" class="mb-0">
<!--                                            <b-form-input type="text" disabled-->
<!--                                                          :value="row.item.receiver_order_note"-->
<!--                                                          @blur="save($event.target.value,row.item.id,'receiver_order_note')"-->
<!--                                                          :placeholder="'Введите примечание получателя'">-->
<!--                                            </b-form-input>-->
                                            {{row.item.receiver_order_note}}
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Домофон получателя" label-class="font-weight-bold" label-size="sm" class="mb-0">
<!--                                            <b-form-input type="text" disabled-->
<!--                                                          :value="row.item.receiver_domophone"-->
<!--                                                          @blur="save($event.target.value,row.item.id,'receiver_domophone')"-->
<!--                                                          :placeholder="'Введите домофон получателя'">-->
<!--                                            </b-form-input>-->
                                            {{row.item.receiver_domophone}}
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Итоговое кол-во" label-class="font-weight-bold" label-size="sm" class="mb-0">
<!--                                            <b-form-input type="text" disabled-->
<!--                                                          :value="row.item.summary_count"-->
<!--                                                          @blur="save($event.target.value,row.item.id,'summary_count')"-->
<!--                                                          :placeholder="'Введите итоговое кол-во'">-->
<!--                                            </b-form-input>-->
                                            {{row.item.summary_count}}
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Текст статуса" label-class="font-weight-bold" label-size="sm" class="mb-0">
<!--                                            <b-form-input type="text" disabled-->
<!--                                                          :value="row.item.status_text"-->
<!--                                                          @blur="save($event.target.value,row.item.id,'status_text')"-->
<!--                                                          :placeholder="'Введите статус'">-->
<!--                                            </b-form-input>-->
                                            {{row.item.status_text}}
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Идентификатор курьера" label-class="font-weight-bold" label-size="sm" class="mb-0">
                                            {{row.item.deliveryman_id}}
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Широта" label-class="font-weight-bold" label-size="sm" class="mb-0">
<!--                                            <b-form-input type="text" disabled-->
<!--                                                          :value="row.item.latitude"-->
<!--                                                          @blur="save($event.target.value,row.item.id,'latitude')"-->
<!--                                                          :placeholder="'Введите широту'">-->
<!--                                            </b-form-input>-->
                                            {{row.item.latitude}}
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Долгота" label-class="font-weight-bold" label-size="sm" class="mb-0">
<!--                                            <b-form-input type="text" disabled-->
<!--                                                          :value="row.item.longitude"-->
<!--                                                          @blur="save($event.target.value,row.item.id,'longitude')"-->
<!--                                                          :placeholder="'Введите долготу'">-->
<!--                                            </b-form-input>-->
                                            {{row.item.longitude}}
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
                        <template v-slot:cell(status)="data">
                            <b-input-group size="sm">
                                <b-form-select
                                    v-model="data.item.status"
                                    disabled
                                    :options="statuses"
                                    @change="save(data.item.status,data.item.id,'status')">
                                </b-form-select>
                            </b-input-group>
                        </template>
                        <template v-slot:cell(action)="data">
                            <b-input-group size="sm">
                                <b-button @click="restore(data.item.id)" class="btn btn-info mr-1 mb-1"
                                          :disabled="data.item.id===null">
                                    <i class="fas fa-plus"></i>
                                </b-button>
                                <b-button @click="info(data.item, data.index, $event.target)" class="btn btn-info mr-1 mb-1">
                                    <i class="fas fa-info"></i>
                                </b-button>
                                <b-button @click="details(data.item, data.index, $event.target)" class="btn btn-info mr-1 mb-1">
                                    Загрузить детали
                                </b-button>
                                <b-button @click="data.toggleDetails" class="btn btn-info mr-1 mb-1">
                                    {{ data.detailsShowing ? 'Скрыть' : 'Показать' }}
                                </b-button>
                                <div v-if="details_loading && detailsModal.content==data.item.id">
                                    <b-spinner small label="Loading..."></b-spinner> Загрузка...
                                </div>
                            </b-input-group>
                        </template>
                        <template v-slot:row-details="row">
                            <b-card>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Цена доставки" label-class="font-weight-bold" label-size="sm" class="mb-0">
                                            <!--                                            <b-form-input type="text" disabled-->
                                            <!--                                                          :value="row.item.delivery_price"-->
                                            <!--                                                          @blur="save($event.target.value,row.item.id,'delivery_price')"-->
                                            <!--                                                          :placeholder="'Введите цену доставки'">-->
                                            <!--                                            </b-form-input>-->
                                            {{row.item.delivery_price}}
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Диапозон доставки" label-class="font-weight-bold" label-size="sm" class="mb-0">
                                            <!--                                            <b-form-input type="text" disabled-->
                                            <!--                                                          :value="row.item.delivery_range"-->
                                            <!--                                                          @blur="save($event.target.value,row.item.id,'delivery_range')"-->
                                            <!--                                                          :placeholder="'Введите диапозон доставки'">-->
                                            <!--                                            </b-form-input>-->
                                            {{row.item.delivery_range}}
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Примечание доставки" label-class="font-weight-bold" label-size="sm" class="mb-0">
                                            <!--                                            <b-form-input type="text" disabled-->
                                            <!--                                                          :value="row.item.delivery_note"-->
                                            <!--                                                          @blur="save($event.target.value,row.item.id,'delivery_note')"-->
                                            <!--                                                          :placeholder="'Введите примечание доставки'">-->
                                            <!--                                            </b-form-input>-->
                                            {{row.item.delivery_note}}
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Идентификатор получателя" label-class="font-weight-bold" label-size="sm" class="mb-0">
                                            <!--                                            <b-form-input type="text" disabled-->
                                            <!--                                                          :value="row.item.receiver_name"-->
                                            <!--                                                          @blur="save($event.target.value,row.item.id,'receiver_name')"-->
                                            <!--                                                          :placeholder="'Введите имя получателя'">-->
                                            <!--                                            </b-form-input>-->
                                            {{row.item.user_id}}
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Телефон получателя" label-class="font-weight-bold" label-size="sm" class="mb-0">
                                            <!--                                            <b-form-input type="text" disabled-->
                                            <!--                                                          :value="row.item.receiver_phone"-->
                                            <!--                                                          @blur="save($event.target.value,row.item.id,'receiver_phone')"-->
                                            <!--                                                          :placeholder="'Введите телефон получателя'">-->
                                            <!--                                            </b-form-input>-->
                                            {{row.item.receiver_phone}}
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Время доставки к получателю" label-class="font-weight-bold" label-size="sm" class="mb-0">
                                            <!--                                            <b-form-input type="text" disabled-->
                                            <!--                                                          :value="row.item.receiver_delivery_time"-->
                                            <!--                                                          @blur="save($event.target.value,row.item.id,'receiver_delivery_time')"-->
                                            <!--                                                          :placeholder="'Введите время доставки к получателю'">-->
                                            <!--                                            </b-form-input>-->
                                            {{row.item.receiver_delivery_time}}
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Адрес получателя" label-class="font-weight-bold" label-size="sm" class="mb-0">
                                            <!--                                            <b-form-input type="text" disabled-->
                                            <!--                                                          :value="row.item.receiver_address"-->
                                            <!--                                                          @blur="save($event.target.value,row.item.id,'receiver_address')"-->
                                            <!--                                                          :placeholder="'Введите адрес получателя'">-->
                                            <!--                                            </b-form-input>-->
                                            {{row.item.receiver_address}}
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Примечание получателя" label-class="font-weight-bold" label-size="sm" class="mb-0">
                                            <!--                                            <b-form-input type="text" disabled-->
                                            <!--                                                          :value="row.item.receiver_order_note"-->
                                            <!--                                                          @blur="save($event.target.value,row.item.id,'receiver_order_note')"-->
                                            <!--                                                          :placeholder="'Введите примечание получателя'">-->
                                            <!--                                            </b-form-input>-->
                                            {{row.item.receiver_order_note}}
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Домофон получателя" label-class="font-weight-bold" label-size="sm" class="mb-0">
                                            <!--                                            <b-form-input type="text" disabled-->
                                            <!--                                                          :value="row.item.receiver_domophone"-->
                                            <!--                                                          @blur="save($event.target.value,row.item.id,'receiver_domophone')"-->
                                            <!--                                                          :placeholder="'Введите домофон получателя'">-->
                                            <!--                                            </b-form-input>-->
                                            {{row.item.receiver_domophone}}
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Итоговое кол-во" label-class="font-weight-bold" label-size="sm" class="mb-0">
                                            <!--                                            <b-form-input type="text" disabled-->
                                            <!--                                                          :value="row.item.summary_count"-->
                                            <!--                                                          @blur="save($event.target.value,row.item.id,'summary_count')"-->
                                            <!--                                                          :placeholder="'Введите итоговое кол-во'">-->
                                            <!--                                            </b-form-input>-->
                                            {{row.item.summary_count}}
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Текст статуса" label-class="font-weight-bold" label-size="sm" class="mb-0">
                                            <!--                                            <b-form-input type="text" disabled-->
                                            <!--                                                          :value="row.item.status_text"-->
                                            <!--                                                          @blur="save($event.target.value,row.item.id,'status_text')"-->
                                            <!--                                                          :placeholder="'Введите статус'">-->
                                            <!--                                            </b-form-input>-->
                                            {{row.item.status_text}}
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Идентификатор курьера" label-class="font-weight-bold" label-size="sm" class="mb-0">
                                            {{row.item.deliveryman_id}}
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Широта" label-class="font-weight-bold" label-size="sm" class="mb-0">
                                            <!--                                            <b-form-input type="text" disabled-->
                                            <!--                                                          :value="row.item.latitude"-->
                                            <!--                                                          @blur="save($event.target.value,row.item.id,'latitude')"-->
                                            <!--                                                          :placeholder="'Введите широту'">-->
                                            <!--                                            </b-form-input>-->
                                            {{row.item.latitude}}
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <b-form-group label-cols-lg="4" label="Долгота" label-class="font-weight-bold" label-size="sm" class="mb-0">
                                            <!--                                            <b-form-input type="text" disabled-->
                                            <!--                                                          :value="row.item.longitude"-->
                                            <!--                                                          @blur="save($event.target.value,row.item.id,'longitude')"-->
                                            <!--                                                          :placeholder="'Введите долготу'">-->
                                            <!--                                            </b-form-input>-->
                                            {{row.item.longitude}}
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
                </b-tab>
            </b-tabs>
            <!-- Info modal -->
            <b-modal :id="infoModal.id" :title="infoModal.title" ok-only @hide="resetInfoModal">
                <pre>{{ infoModal.content }}</pre>
            </b-modal>
            <b-modal :id="detailsModal.id" :title="detailsModal.title" ok-only @hide="resetDetailsModal">
                <div v-for="detail in detailsModal.details">
                    <div class="row" >
                        <div class="col-sm-12 col-md-5 mb-2">
                            <b-form-group label-cols-lg="5" label="Кол-во" label-class="font-weight-bold" label-size="sm" class="mb-0">
                                {{detail.count}}
                            </b-form-group>
                        </div>
                        <div class="col-sm-12 col-md-5 mb-2">
                            <b-form-group label-cols-lg="5" label="Цена" label-class="font-weight-bold" label-size="sm" class="mb-0">
                                {{detail.price}} руб.
                            </b-form-group>
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-sm-12 col-md-10 mb-2">
                            <b-form-group label-cols-lg="4" label="Название продукта" label-class="font-weight-bold" label-size="sm" class="mb-0">
                                <b-form-textarea
                                    id="textarea"
                                    :value="detail.product.food_name"
                                    disabled
                                    rows="3"
                                    max-rows="6"
                                ></b-form-textarea>
                            </b-form-group>
                       </div>
                    </div>

                </div>

            </b-modal>
        </b-container>


    </div>
</template>

<script>
    export default {
        data() {
            return {
                sortBy: 'created_at',
                sortDesc: true,
                fields: [
                    {key: 'created_at', label: 'Дата', sortable: true, sortDirection: 'desc'},
                    {key: 'rest_name', label: 'Ресторан', sortable: true, sortDirection: 'desc'},
                    {key: 'receiver_name', label: 'Пользователь', sortable: true, sortDirection: 'desc'},
                    {key: 'deliveryman_phone', label: 'Курьер', sortable: true, sortDirection: 'desc'},
                    {key: 'summary_price', label: 'Итоговая цена', sortable: true, sortDirection: 'desc'},
                    {key: 'status', label: 'Статус', sortable: true, sortDirection: 'desc'},
                    {key: 'action', label: 'Действие'},
                ],
                items: [],
                deleted_items: [],
                statuses: [
                    { value: 0, text: 'В обработке' },
                    { value: 1, text: 'Готовится' },
                    { value: 2, text: 'В процессе доставки' },
                    { value: 3, text: 'Доставлен' },
                    { value: 4, text: 'Отклонен администратором' }
                ],
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
                detailsModal: {
                    id: 'details-modal',
                    title: '',
                    content: '',
                    details:[]
                },
                loading: false,
                details_loading: false,

                sortBy1: 'created_at',
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
            async details(item, index, button) {
                this.detailsModal.content = item.id;
                this.details_loading = true;
                const response = await axios
                    .get(`/admin/orders/getDetails/${item.id}`)
                    .then(resp => {
                        this.detailsModal.details = resp.data.details;
                    });
                this.detailsModal.title = `Details index: ${index}`;
                this.detailsModal.content = item.id;

                this.$root.$emit('bv::show::modal', this.detailsModal.id, button)
                this.details_loading = false;
            },
            resetDetailsModal() {
                this.detailsModal.title = ''
                this.detailsModal.content = ''
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
            async remove(id) {
                let foundIndex = this.items.findIndex(x => x.id === id);

                const response = await axios
                    .delete(`/admin/orders/destroy/${id}`)
                    .then(resp => {
                        this.deleted_items.push(this.items[foundIndex]);
                        this.items.splice(foundIndex, 1);
                        this.sendMessage(resp.data.message)
                    });
            },
            async restore(id) {
                const response = await axios
                    .post(`/admin/orders/restore/${id}`)
                    .then(resp => {
                        this.sendMessage(resp.data.message)
                        this.loadData()

                    });
            },
            async save(value, id, key) {
                const response = await axios
                    .put(`/admin/orders/update/${id}`, {
                        param: key,
                        value: value
                    }).then(resp => {
                        this.sendMessage(resp.data.message)
                        // this.loadData()
                    });
            },
            async loadData() {
                this.loading = true;
                const response = await axios
                    .get('/admin/orders/get')
                    .then(resp => {
                        this.items = resp.data.orders;
                        this.totalRows = this.items ? this.items.length : 0;

                        this.deleted_items = resp.data.deleted_orders;
                        this.totalRows1 = this.deleted_items ? this.deleted_items.length : 0;

                        this.loading = false;
                    });
            },
            sendMessage(message) {
                this.$notify({
                    group: 'message',
                    type: 'success',
                    title: 'Заказы',
                    text: message
                });
            },
        }
    }
</script>
