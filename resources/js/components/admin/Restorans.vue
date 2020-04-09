<template>
    <div>
        <notifications group="message"/>

        <b-button v-b-toggle.collapse-1 variant="primary" class="mt-4 mb-4">Загрузить рестораны</b-button>
        <b-collapse id="collapse-1" class="mb-4">
            <b-container fluid>
                <!-- User Interface controls -->
                <b-row>
                    <b-col lg="12" class="my-1">
                        <div class="large-12 medium-12 small-12 filezone" >
                            <input type="file" id="files" ref="files" v-on:change="handleFiles()" :disabled="loading"/>
                            <p>
                                Перетащите файл сюда <br>или нажмите для поиска
                            </p>
                        </div>
                        <hr>
                    </b-col>
                </b-row>
            </b-container>
        </b-collapse>

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
                        <template v-slot:cell(name)="data">
                            <b-input-group size="sm">
                                <b-form-input :disabled="data.item.id===null" :value="data.item.name"
                                              @blur="save($event.target.value,data.item.id,'name')"
                                              placeholder="Введите название заведения"></b-form-input>
                            </b-input-group>
                        </template>
                        <template v-slot:cell(adress)="data">
                            <b-input-group size="sm">
                                <b-form-input :disabled="data.item.id===null" :value="data.item.adress"
                                              @blur="save($event.target.value,data.item.id,'adress')"
                                              placeholder="Введите адрес"></b-form-input>
                            </b-input-group>
                        </template>
                        <template v-slot:cell(min_sum)="data">
                            <b-input-group size="sm">
                                <b-form-input :disabled="data.item.id===null" :value="data.item.min_sum"
                                              @blur="save($event.target.value,data.item.id,'min_sum')"
                                              placeholder="Введите мин.сумму заказа"></b-form-input>
                            </b-input-group>
                        </template>
                        <template v-slot:cell(price_delivery)="data">
                            <b-input-group size="sm">
                                <b-form-input :disabled="data.item.id===null" :value="data.item.price_delivery"
                                              @blur="save($event.target.value,data.item.id,'price_delivery')"
                                              placeholder="Введите цену доставки"></b-form-input>
                            </b-input-group>
                        </template>

                        <template v-slot:cell(action)="data">
                            <b-input-group size="sm">
                                <b-button @click="remove(data.item.id)" class="btn btn-info mr-1 mb-1"
                                          :disabled="data.item.id===null">
                                    <i class="far fa-trash-alt"></i>
                                </b-button>

                                <b-button target="_blank" :href="'/rest/'+data.item.url"
                                          :disabled="data.item.id===null" class="btn btn-info mr-1 mb-1">
                                    <i class="fas fa-eye"></i>
                                </b-button>

                                <b-button @click="info(data.item, data.index, $event.target)" class="btn btn-info mr-1 mb-1">
                                    <i class="fas fa-info"></i>
                                </b-button>
                                <b-button target="_blank" :href="'/admin/restorans/stop-list/'+data.item.id" class="btn btn-info mr-1 mb-1">
                                    Стоп лист
                                </b-button>
                                <b-button @click="data.toggleDetails" class="btn btn-info mr-1 mb-1">
                                    {{ data.detailsShowing ? 'Скрыть' : 'Показать' }}
                                </b-button>
                            </b-input-group>
                        </template>
                        <template v-slot:row-details="row">
                            <b-card>
                                <div class="row">
<!--                                    <div class="col-sm-12 col-md-4  mt-2">-->
<!--                                        <b-form-group label-cols-lg="4" label="Название заведения" label-size="sm"-->
<!--                                                      class="mb-0">-->
<!--                                            <b-form-input type="text" :disabled="row.item.id===null"-->
<!--                                                        :value="row.item.name"-->
<!--                                                          @blur="save($event.target.value,row.item.id,'name')"-->
<!--                                                        :placeholder="'Введите название заведения'">-->
<!--                                           </b-form-input>-->
<!--                                        </b-form-group>-->
<!--                                    </div>-->
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Описание" label-size="sm"
                                                      class="mb-0">
                                            <b-form-textarea
                                                id="textarea"
                                                :value="row.item.description"
                                                @blur="save($event.target.value,row.item.id,'description')"
                                                placeholder="Введите описание"
                                                rows="3"
                                                max-rows="6"
                                            ></b-form-textarea>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Деньги Фасторана" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.fastoran_money"
                                                          @blur="save($event.target.value,row.item.id,'fastoran_money')"
                                                          :placeholder="'Введите деньги фасторана'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
<!--                                    <div class="col-sm-12 col-md-4  mt-2">-->
<!--                                        <b-form-group label-cols-lg="4" label="Адрес" label-size="sm"-->
<!--                                                      class="mb-0">-->
<!--                                            <b-form-input type="text" :disabled="row.item.id===null"-->
<!--                                                          :value="row.item.adress"-->
<!--                                                          @blur="save($event.target.value,row.item.id,'adress')"-->
<!--                                                          :placeholder="'Введите адрес'">-->
<!--                                            </b-form-input>-->
<!--                                        </b-form-group>-->
<!--                                    </div>-->
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Широта" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.latitude"
                                                          @blur="save($event.target.value,row.item.id,'latitude')"
                                                          :placeholder="'Введите широту'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Долгота" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.longitude"
                                                          @blur="save($event.target.value,row.item.id,'longitude')"
                                                          :placeholder="'Введите долготу'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Ориентир" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.orientir"
                                                          @blur="save($event.target.value,row.item.id,'orientir')"
                                                          :placeholder="'Введите ориентир'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Город" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.city"
                                                          @blur="save($event.target.value,row.item.id,'city')"
                                                          :placeholder="'Введите город'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                     <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Район" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.region"
                                                          @blur="save($event.target.value,row.item.id,'region')"
                                                          :placeholder="'Введите район'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Логотип заведения" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.logo"
                                                          @blur="save($event.target.value,row.item.id,'logo')"
                                                          :placeholder="'Введите логотип заведения'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Телефон1" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.phone1"
                                                          @blur="save($event.target.value,row.item.id,'phone1')"
                                                          :placeholder="'Введите телефон1'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Телефон2" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.phone2"
                                                          @blur="save($event.target.value,row.item.id,'phone2')"
                                                          :placeholder="'Введите телефон2'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Сайт" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.site"
                                                          @blur="save($event.target.value,row.item.id,'site')"
                                                          :placeholder="'Введите сайт'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Короткий адрес заведения" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.url"
                                                          @blur="save($event.target.value,row.item.id,'url')"
                                                          :placeholder="'Введите короткий адрес заведения'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Email" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.email"
                                                          @blur="save($event.target.value,row.item.id,'email')"
                                                          :placeholder="'Введите email'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Время работы" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.work_time"
                                                          @blur="save($event.target.value,row.item.id,'work_time')"
                                                          :placeholder="'Введите время работы'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Канал в телеграм" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.telegram_channel"
                                                          @blur="save($event.target.value,row.item.id,'telegram_channel')"
                                                          :placeholder="'Введите канал в телеграм'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Контактное лицо" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.cont_face"
                                                          @blur="save($event.target.value,row.item.id,'cont_face')"
                                                          :placeholder="'Введите контактное лицо'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Контактный телефон" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.cont_phone"
                                                          @blur="save($event.target.value,row.item.id,'cont_phone')"
                                                          :placeholder="'Введите контактный телефон'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Страница Вконтакте" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.vk_page"
                                                          @blur="save($event.target.value,row.item.id,'vk_page')"
                                                          :placeholder="'Введите страницу Вконтакте'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Старница Однокласники" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.odn_page"
                                                          @blur="save($event.target.value,row.item.id,'odn_page')"
                                                          :placeholder="'Введите старницу Однокласники'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Страница Инстаграмм" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.inst_page"
                                                          @blur="save($event.target.value,row.item.id,'inst_page')"
                                                          :placeholder="'Введите страницу Инстаграмм'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Идентификатор рейтинга" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.rating_id"
                                                          @blur="save($event.target.value,row.item.id,'rating_id')"
                                                          :placeholder="'Введите идентификатор рейтинга'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Рейтинг заведения" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.rest_rating"
                                                          @blur="save($event.target.value,row.item.id,'rest_rating')"
                                                          :placeholder="'Введите рейтинг заведения'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Домен заведения" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.seo_domain"
                                                          @blur="save($event.target.value,row.item.id,'seo_domain')"
                                                          :placeholder="'Введите домен заведения'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Seo title заведения" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.seo_title"
                                                          @blur="save($event.target.value,row.item.id,'seo_title')"
                                                          :placeholder="'Введите seo title заведения'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Seo h1 заведения" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.seo_h1"
                                                          @blur="save($event.target.value,row.item.id,'seo_h1')"
                                                          :placeholder="'Введите seo h1 заведения'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Seo description заведения" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.seo_description"
                                                          @blur="save($event.target.value,row.item.id,'seo_description')"
                                                          :placeholder="'Введите seo description заведения'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Кол-во просмотров" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.view_count"
                                                          @blur="save($event.target.value,row.item.id,'view_count')"
                                                          :placeholder="'Введите кол-во просмотров'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Картинка ресторана" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.rest_img"
                                                          @blur="save($event.target.value,row.item.id,'rest_img')"
                                                          :placeholder="'Введите картинку ресторана'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Модерация" label-size="sm"
                                                      class="mb-0">
                                            <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary m-auto">
                                                <input class="c-switch-input m-auto" type="checkbox" :disabled="row.item.id===null"
                                                       name="is_active" :checked="row.item.moderation"
                                                       @change="save($event.target.checked?1:0,row.item.id,'moderation')">
                                                <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                            </label>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Тариф" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.tarif"
                                                          @blur="save($event.target.value,row.item.id,'tarif')"
                                                          :placeholder="'Введите тариф'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Скидка" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.discount"
                                                          @blur="save($event.target.value,row.item.id,'discount')"
                                                          :placeholder="'Введите скидку'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Текст скидки" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" :disabled="row.item.id===null"
                                                          :value="row.item.discount_text"
                                                          @blur="save($event.target.value,row.item.id,'discount_text')"
                                                          :placeholder="'Введите текст скидки'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                </div>
<!--                                <div class="row">-->
<!--                                    <div class="col-sm-12 col-md-4  mt-2">-->
<!--                                        <b-form-group label-cols-lg="4" label="Мин.сумма заказа" label-size="sm"-->
<!--                                                      class="mb-0">-->
<!--                                            <b-form-input type="text" :disabled="row.item.id===null"-->
<!--                                                          :value="row.item.min_sum"-->
<!--                                                          @blur="save($event.target.value,row.item.id,'min_sum')"-->
<!--                                                          :placeholder="'Введите мин.сумму заказа'">-->
<!--                                            </b-form-input>-->
<!--                                        </b-form-group>-->
<!--                                    </div>-->
<!--                                    <div class="col-sm-12 col-md-4  mt-2">-->
<!--                                        <b-form-group label-cols-lg="4" label="Цена доставки" label-size="sm"-->
<!--                                                      class="mb-0">-->
<!--                                            <b-form-input type="text" :disabled="row.item.id===null"-->
<!--                                                          :value="row.item.price_delivery"-->
<!--                                                          @blur="save($event.target.value,row.item.id,'price_delivery')"-->
<!--                                                          :placeholder="'Введите цену доставки'">-->
<!--                                            </b-form-input>-->
<!--                                        </b-form-group>-->
<!--                                    </div>-->
<!--                                    <div class="col-sm-12 col-md-4  mt-2">-->
<!--                                        <b-form-group label-cols-lg="4" label="Деньги Фасторана" label-size="sm"-->
<!--                                                      class="mb-0">-->
<!--                                            <b-form-input type="text" :disabled="row.item.id===null"-->
<!--                                                          :value="row.item.fastoran_money"-->
<!--                                                          @blur="save($event.target.value,row.item.id,'fastoran_money')"-->
<!--                                                          :placeholder="'Введите деньги фасторана'">-->
<!--                                            </b-form-input>-->
<!--                                        </b-form-group>-->
<!--                                    </div>-->
<!--                                </div>-->
                                <div class="row">
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Танцпол" label-size="sm"
                                                      class="mb-0">
                                            <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary m-auto">
                                                <input class="c-switch-input m-auto" type="checkbox" :disabled="row.item.id===null"
                                                       name="is_active" :checked="row.item.has_dance"
                                                       @change="save($event.target.checked?1:0,row.item.id,'has_dance')">
                                                <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                            </label>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Караоке" label-size="sm"
                                                      class="mb-0">
                                            <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary m-auto">
                                                <input class="c-switch-input m-auto" type="checkbox" :disabled="row.item.id===null"
                                                       name="is_active" :checked="row.item.has_karaoke"
                                                       @change="save($event.target.checked?1:0,row.item.id,'has_karaoke')">
                                                <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                            </label>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="wifi" label-size="sm"
                                                      class="mb-0">
                                            <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary m-auto">
                                                <input class="c-switch-input m-auto" type="checkbox" :disabled="row.item.id===null"
                                                       name="is_active" :checked="row.item.has_wifi"
                                                       @change="save($event.target.checked?1:0,row.item.id,'has_wifi')">
                                                <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                            </label>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-3  mt-2">
                                        <b-form-group label-cols-lg="9" label="Парковка" label-size="sm"
                                                      class="mb-0">
                                            <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary m-auto">
                                                <input class="c-switch-input m-auto" type="checkbox" :disabled="row.item.id===null"
                                                       name="is_active" :checked="row.item.has_parking"
                                                       @change="save($event.target.checked?1:0,row.item.id,'has_parking')">
                                                <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                            </label>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-3  mt-2">
                                        <b-form-group label-cols-lg="9" label="Бизнес ланчи" label-size="sm"
                                                      class="mb-0">
                                            <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary m-auto">
                                                <input class="c-switch-input m-auto" type="checkbox" :disabled="row.item.id===null"
                                                       name="is_active" :checked="row.item.has_business"
                                                       @change="save($event.target.checked?1:0,row.item.id,'has_business')">
                                                <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                            </label>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-3 mt-2">
                                        <b-form-group label-cols-lg="9" label="Детское меню" label-size="sm"
                                                      class="mb-0">
                                            <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary m-auto">
                                                <input class="c-switch-input m-auto" type="checkbox" :disabled="row.item.id===null"
                                                       name="is_active" :checked="row.item.has_children"
                                                       @change="save($event.target.checked?1:0,row.item.id,'has_children')">
                                                <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                            </label>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-3  mt-2">
                                        <b-form-group label-cols-lg="9" label="Спец. предложение" label-size="sm"
                                                      class="mb-0">
                                            <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary m-auto">
                                                <input class="c-switch-input m-auto" type="checkbox" :disabled="row.item.id===null"
                                                       name="is_active" :checked="row.item.has_special"
                                                       @change="save($event.target.checked?1:0,row.item.id,'has_special')">
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
                                <b-button @click="restore(data.item.id)" class="btn btn-info mr-1 mb-1"
                                          :disabled="data.item.id===null">
                                    <i class="fas fa-plus"></i>
                                </b-button>
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
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Название заведения" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.name"
                                                          @blur="save($event.target.value,row.item.id,'name')"
                                                          :placeholder="'Введите название заведения'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Описание" label-size="sm"
                                                      class="mb-0">
                                            <b-form-textarea
                                                id="textarea"
                                                :value="row.item.description"
                                                disabled
                                                placeholder="Введите описание"
                                                rows="3"
                                                max-rows="6"
                                            ></b-form-textarea>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Адрес" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.adress"
                                                          @blur="save($event.target.value,row.item.id,'adress')"
                                                          :placeholder="'Введите адрес'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Широта" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.latitude"
                                                          @blur="save($event.target.value,row.item.id,'latitude')"
                                                          :placeholder="'Введите широту'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Долгота" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.longitude"
                                                          @blur="save($event.target.value,row.item.id,'longitude')"
                                                          :placeholder="'Введите долготу'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Ориентир" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.orientir"
                                                          @blur="save($event.target.value,row.item.id,'orientir')"
                                                          :placeholder="'Введите ориентир'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Город" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.city"
                                                          @blur="save($event.target.value,row.item.id,'city')"
                                                          :placeholder="'Введите город'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Район" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.region"
                                                          @blur="save($event.target.value,row.item.id,'region')"
                                                          :placeholder="'Введите район'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Логотип заведения" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.logo"
                                                          @blur="save($event.target.value,row.item.id,'logo')"
                                                          :placeholder="'Введите логотип заведения'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Телефон1" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.phone1"
                                                          @blur="save($event.target.value,row.item.id,'phone1')"
                                                          :placeholder="'Введите телефон1'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Телефон2" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.phone2"
                                                          @blur="save($event.target.value,row.item.id,'phone2')"
                                                          :placeholder="'Введите телефон2'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Сайт" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.site"
                                                          @blur="save($event.target.value,row.item.id,'site')"
                                                          :placeholder="'Введите сайт'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Короткий адрес заведения" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.url"
                                                          @blur="save($event.target.value,row.item.id,'url')"
                                                          :placeholder="'Введите короткий адрес заведения'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Email" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.email"
                                                          @blur="save($event.target.value,row.item.id,'email')"
                                                          :placeholder="'Введите email'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Время работы" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.work_time"
                                                          @blur="save($event.target.value,row.item.id,'work_time')"
                                                          :placeholder="'Введите время работы'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Канал в телеграм" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.telegram_channel"
                                                          @blur="save($event.target.value,row.item.id,'telegram_channel')"
                                                          :placeholder="'Введите канал в телеграм'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Контактное лицо" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.cont_face"
                                                          @blur="save($event.target.value,row.item.id,'cont_face')"
                                                          :placeholder="'Введите контактное лицо'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Контактный телефон" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.cont_phone"
                                                          @blur="save($event.target.value,row.item.id,'cont_phone')"
                                                          :placeholder="'Введите контактный телефон'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Страница Вконтакте" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.vk_page"
                                                          @blur="save($event.target.value,row.item.id,'vk_page')"
                                                          :placeholder="'Введите страницу Вконтакте'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Старница Однокласники" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.odn_page"
                                                          @blur="save($event.target.value,row.item.id,'odn_page')"
                                                          :placeholder="'Введите старницу Однокласники'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Страница Инстаграмм" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.inst_page"
                                                          @blur="save($event.target.value,row.item.id,'inst_page')"
                                                          :placeholder="'Введите страницу Инстаграмм'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Идентификатор рейтинга" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.rating_id"
                                                          @blur="save($event.target.value,row.item.id,'rating_id')"
                                                          :placeholder="'Введите идентификатор рейтинга'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Рейтинг заведения" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.rest_rating"
                                                          @blur="save($event.target.value,row.item.id,'rest_rating')"
                                                          :placeholder="'Введите рейтинг заведения'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Домен заведения" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.seo_domain"
                                                          @blur="save($event.target.value,row.item.id,'seo_domain')"
                                                          :placeholder="'Введите домен заведения'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Seo title заведения" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.seo_title"
                                                          @blur="save($event.target.value,row.item.id,'seo_title')"
                                                          :placeholder="'Введите seo title заведения'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Seo h1 заведения" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.seo_h1"
                                                          @blur="save($event.target.value,row.item.id,'seo_h1')"
                                                          :placeholder="'Введите seo h1 заведения'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Seo description заведения" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.seo_description"
                                                          @blur="save($event.target.value,row.item.id,'seo_description')"
                                                          :placeholder="'Введите seo description заведения'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Кол-во просмотров" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.view_count"
                                                          @blur="save($event.target.value,row.item.id,'view_count')"
                                                          :placeholder="'Введите кол-во просмотров'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Картинка ресторана" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.rest_img"
                                                          @blur="save($event.target.value,row.item.id,'rest_img')"
                                                          :placeholder="'Введите картинку ресторана'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Модерация" label-size="sm"
                                                      class="mb-0">
                                            <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary m-auto">
                                                <input class="c-switch-input m-auto" type="checkbox" disabled
                                                       name="is_active" :checked="row.item.moderation"
                                                       @change="save($event.target.checked?1:0,row.item.id,'moderation')">
                                                <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                            </label>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Тариф" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.tarif"
                                                          @blur="save($event.target.value,row.item.id,'tarif')"
                                                          :placeholder="'Введите тариф'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Скидка" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.discount"
                                                          @blur="save($event.target.value,row.item.id,'discount')"
                                                          :placeholder="'Введите скидку'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Текст скидки" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.discount_text"
                                                          @blur="save($event.target.value,row.item.id,'discount_text')"
                                                          :placeholder="'Введите текст скидки'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Мин. сумма заказа" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.min_sum"
                                                          @blur="save($event.target.value,row.item.id,'min_sum')"
                                                          :placeholder="'Введите мин.сумму заказа'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Цена доставки" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.price_delivery"
                                                          @blur="save($event.target.value,row.item.id,'price_delivery')"
                                                          :placeholder="'Введите цену доставки'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Деньги Фасторана" label-size="sm"
                                                      class="mb-0">
                                            <b-form-input type="text" disabled
                                                          :value="row.item.fastoran_money"
                                                          @blur="save($event.target.value,row.item.id,'fastoran_money')"
                                                          :placeholder="'Введите деньги фасторана'">
                                            </b-form-input>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Танцпол" label-size="sm"
                                                      class="mb-0">
                                            <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary m-auto">
                                                <input class="c-switch-input m-auto" type="checkbox" disabled
                                                       name="is_active" :checked="row.item.has_dance"
                                                       @change="save($event.target.checked?1:0,row.item.id,'has_dance')">
                                                <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                            </label>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="Караоке" label-size="sm"
                                                      class="mb-0">
                                            <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary m-auto">
                                                <input class="c-switch-input m-auto" type="checkbox" disabled
                                                       name="is_active" :checked="row.item.has_karaoke"
                                                       @change="save($event.target.checked?1:0,row.item.id,'has_karaoke')">
                                                <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                            </label>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-4  mt-2">
                                        <b-form-group label-cols-lg="4" label="wifi" label-size="sm"
                                                      class="mb-0">
                                            <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary m-auto">
                                                <input class="c-switch-input m-auto" type="checkbox" disabled
                                                       name="is_active" :checked="row.item.has_wifi"
                                                       @change="save($event.target.checked?1:0,row.item.id,'has_wifi')">
                                                <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                            </label>
                                        </b-form-group>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12 col-md-3  mt-2">
                                        <b-form-group label-cols-lg="9" label="Парковка" label-size="sm"
                                                      class="mb-0">
                                            <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary m-auto">
                                                <input class="c-switch-input m-auto" type="checkbox" disabled
                                                       name="is_active" :checked="row.item.has_parking"
                                                       @change="save($event.target.checked?1:0,row.item.id,'has_parking')">
                                                <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                            </label>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-3  mt-2">
                                        <b-form-group label-cols-lg="9" label="Бизнес ланчи" label-size="sm"
                                                      class="mb-0">
                                            <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary m-auto">
                                                <input class="c-switch-input m-auto" type="checkbox" disabled
                                                       name="is_active" :checked="row.item.has_business"
                                                       @change="save($event.target.checked?1:0,row.item.id,'has_business')">
                                                <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                            </label>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-3 mt-2">
                                        <b-form-group label-cols-lg="9" label="Детское меню" label-size="sm"
                                                      class="mb-0">
                                            <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary m-auto">
                                                <input class="c-switch-input m-auto" type="checkbox" disabled
                                                       name="is_active" :checked="row.item.has_children"
                                                       @change="save($event.target.checked?1:0,row.item.id,'has_children')">
                                                <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                            </label>
                                        </b-form-group>
                                    </div>
                                    <div class="col-sm-12 col-md-3  mt-2">
                                        <b-form-group label-cols-lg="9" label="Спец. предложение" label-size="sm"
                                                      class="mb-0">
                                            <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary m-auto">
                                                <input class="c-switch-input m-auto" type="checkbox" disabled
                                                       name="is_active" :checked="row.item.has_special"
                                                       @change="save($event.target.checked?1:0,row.item.id,'has_special')">
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
                sortBy: 'name',
                sortDesc: false,
                included_fields: [
                    'name',
                    'description',

                    'latitude',
                    'longitude',

                    'adress',
                    'orientir',

                    'city',

                    'region',

                    'phone1',
                    'phone2',

                    'site',
                    'email',
                    'work_time',

                    'has_dance',
                    'has_karaoke',
                    'has_wifi',
                    'has_parking',
                    'has_business',
                    'has_children',
                    'has_special',


                    'telegram_channel',
                    'cont_face',
                    'cont_phone',
                    'vk_page',
                    'odn_page',
                    'inst_page',

                    'logo',

                    'rest_rating',
                    'seo_domain',
                    'seo_title',
                    'seo_h1',
                    'seo_description',
                    'url',
                    'view_count',
                    'rest_img',
                    'moderation',
                    'tarif',
                    'discount',
                    'discount_text',
                    'min_sum',
                    'price_delivery',
                    'fastoran_money',
                    'rating_id',
                ],
                fields: [
                    {key: 'name', label: 'Название ресторана', sortable: true, sortDirection: 'desc'},
                    {key: 'adress', label: 'Адрес', sortable: true, sortDirection: 'desc'},
                    {key: 'min_sum', label: 'Мин. сумма заказа', sortable: true, sortDirection: 'desc'},
                    {key: 'price_delivery', label: 'Доставка', sortable: true, sortDirection: 'desc'},
                    {key: 'action', label: 'Действие'},
                ],
                items: [],
                deleted_items:[],
                files:[],
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

                sortBy1: 'name',
                sortDesc1: false,
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
                this.totalRows = filteredItems.length
                this.currentPage = 1
            },
            onFiltered1(filteredItems) {
                this.totalRows1 = filteredItems.length
                this.currentPage1 = 1
            },
            remove(id) {

                let foundIndex = this.items.findIndex(x => x.id === id);
                // this.items[foundIndex].id = null;

                axios
                    .delete(`/admin/restorans/destroy/${id}`)
                    .then(() => {
                        this.deleted_items.push(this.items[foundIndex]);
                        this.items.splice(foundIndex, 1);
                        this.sendMessage(resp.data.message)
                        // this.loadData()
                    });
            },
            async restore(id) {
                const response = await axios
                    .post(`/admin/restorans/restore/${id}`)
                    .then(resp => {
                        this.loadData()
                        this.sendMessage(resp.data.message)
                    });
            },
            save(value, id, key) {
                axios
                    .put(`/admin/restorans/update/${id}`, {
                        param: key,
                        value: value
                    }).then(resp => {
                    // this.loadData()
                    this.sendMessage(resp.data.message)
                });
            },

            async loadData() {
                this.loading = true;
                const response = await axios
                    .get('/admin/restorans/get')
                    .then(resp => {
                        this.items = resp.data.restorans;
                        this.totalRows = this.items.length;

                        this.deleted_items = resp.data.deleted_restorans;
                        this.totalRows1 = this.deleted_items.length;

                        this.loading = false;
                    });
            },
            sendMessage(message, type='success') {
                this.$notify({
                    group: 'message',
                    type: type,
                    title: 'Рестораны',
                    text: message
                });
            },
            handleFiles() {
                let uploadedFiles = this.$refs.files.files;

                for(var i = 0; i < uploadedFiles.length; i++) {
                    if (/\.(xlsx|xls)$/i.test(uploadedFiles[i].name))
                    {
                        let formData = new FormData();
                        formData.append('file', uploadedFiles[i]);
                        axios.post(`/admin/restorans/upload`,
                            formData,
                            {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            })
                        .then(resp => {
                            this.sendMessage(resp.data.message)
                            this.loadData()
                        });
                    }
                    else
                    {
                        this.sendMessage('Неверный формат файла', 'error')
                        break;
                    }
                }
            },
        }
    }
</script>
<style scoped>
    input[type="file"]{
        opacity: 0;
        width: 100%;
        height: 200px;
        position: absolute;
        cursor: pointer;
    }
    .filezone {
        outline: 2px dashed grey;
        outline-offset: -10px;
        background: #ccc;
        color: dimgray;
        padding: 10px 10px;
        min-height: 200px;
        position: relative;
        cursor: pointer;
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
