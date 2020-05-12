<template>
    <b-container fluid>
        <notifications group="message"/>
        <div class="row">
            <div class="col-lg-4">
                <b-button variant="primary" class="mt-4 mb-4" v-b-modal.new-user>Создать пользователя</b-button>
            </div>
        </div>
        <b-modal id="new-user" title="Создать пользователя">
            <b-form-input
                v-model="new_user.name"
                type="text"
                placeholder="Введите имя пользователя"
                class="mb-2"
                required
            ></b-form-input>
            <b-form-input
                v-model="new_user.phone"
                type="text"
                placeholder="Введите телефон пользователя"
                class="mb-2"
                required
                pattern="[\+]\d{2} [\(]\d{3}[\)] \d{3}[\-]\d{2}[\-]\d{2}"
                maxlength="19"
                v-mask="['+38 (###) ###-##-##']"
            ></b-form-input>
            <b-form-select
                v-model="new_user.user_type"
                :options="types"
                class="mb-2"
            >
            </b-form-select>
            <b-form-select
                v-if="new_user.user_type == 1"
                v-model="new_user.deliveryman_type"
                :options="delivery_types"
                class="mb-2"
            >
            </b-form-select>
            <template v-slot:modal-footer>
                <div class="w-100">

                    <b-button
                        variant="primary"
                        class="float-right"
                        @click="createUser()"
                        :disabled="new_user.name=='' || new_user.phone=='' || (new_user.user_type==1 && new_user.deliveryman_type==0)"
                    >
                       Сохранить
                    </b-button>
                    <b-button
                    variant="primary"
                    class="float-right mr-2"
                    @click="cancel()"
                >
                    Отмена
                </b-button>
                </div>
            </template>
        </b-modal>
        <b-tabs content-class="mt-3">
            <b-tab title="Все" active>
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
                    :items="users"
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
                                          placeholder="Введите имя"></b-form-input>
                        </b-input-group>
                    </template>
                    <template v-slot:cell(phone)="data">
                        <b-input-group size="sm">
                            <b-form-input :disabled="data.item.id===null" :value="data.item.phone"
                                          @blur="save($event.target.value,data.item.id,'phone')"
                                          placeholder="Введите телефон"></b-form-input>
                        </b-input-group>
                    </template>
                    <template v-slot:cell(user_type)="data">
                        <b-input-group size="sm">
                            <b-form-select
                                v-model="data.item.user_type"
                                :disabled="data.item.id===null"
                                :options="types"
                                @change="save(data.item.user_type,data.item.id,'user_type')">
                            </b-form-select>
                        </b-input-group>
                    </template>
                    <template v-slot:cell(bonus)="data">
                        <b-input-group size="sm">
                            <b-form-input :disabled="data.item.id===null" :value="data.item.bonus"
                                          @blur="save($event.target.value,data.item.id,'bonus')"
                                          placeholder="Введите количество бонусов"></b-form-input>
                        </b-input-group>
                    </template>
                    <template v-slot:cell(action)="data">
                        <b-input-group size="sm">
                            <b-button @click="remove(users, data.item.id)" class="btn btn-info mr-1 mb-1"
                                      :disabled="data.item.id===null">
                                <i class="far fa-trash-alt"></i>
                            </b-button>

                            <b-button @click="info(data.item, data.index, $event.target)" class="btn btn-info mr-1 mb-1">
                                <i class="fas fa-info"></i>
                            </b-button>
<!--                            <b-button @click="setPasswordItem(data.item)" class="btn btn-info mr-1 mb-1"-->
<!--                                      :disabled="data.item.id===null">-->
<!--                                Поменять пароль-->
<!--                            </b-button>-->
                            <b-button @click="sendAuthCode(data.item)" class="btn btn-info mr-1 mb-1"
                                      :disabled="data.item.id===null">
                                Отправить пароль
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
                                        <b-form-input type="text" :disabled="row.item.id===null"
                                                      :value="row.item.auth_code"
                                                      @blur="save($event.target.value,row.item.id,'auth_code')"
                                                      :placeholder="'Введите код доступа'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Тип курьера" label-size="sm"
                                                  class="mb-0">
                                        <b-form-select
                                            v-model="row.item.deliveryman_type"
                                            :disabled="row.item.id===null"
                                            :options="delivery_types"
                                            @change="save(row.item.deliveryman_type,row.item.id,'deliveryman_type')">
                                        </b-form-select>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Телеграм ID" label-size="sm"
                                                  class="mb-0">
                                        <b-form-input type="text" :disabled="row.item.id===null" :value="row.item.telegram_chat_id"
                                                      @blur="save($event.target.value,row.item.id,'telegram_chat_id')"
                                                      :placeholder="'Телеграм ID'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Дата рождения" label-size="sm"
                                                  class="mb-0">
                                        <b-form-input type="date" :disabled="row.item.id===null" :value="row.item.birthday"
                                                      @blur="save($event.target.value,row.item.id,'birthday')"
                                                      :placeholder="'Дата рождения'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Адрес" label-size="sm" class="mb-0">
                                        <b-form-input type="text" :disabled="row.item.id===null" :value="row.item.adress"
                                                      @blur="save($event.target.value,row.item.id,'adress')"
                                                      :placeholder="'Адрес'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Активация" label-size="sm" class="mb-0">
                                        <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary">
                                            <input class="c-switch-input" type="checkbox" :disabled="row.item.id===null"
                                                   name="active" :checked="row.item.active"
                                                   @change="save($event.target.checked?1:0,row.item.id,'active')">
                                            <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                        </label>
                                    </b-form-group>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Бонус" label-size="sm" class="mb-0">
                                        <b-form-input type="number" :disabled="row.item.id===null" :value="row.item.bonus"
                                                      @blur="save($event.target.value,row.item.id,'bonus')"
                                                      :placeholder="'Бонус'">
                                        </b-form-input>
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
            <b-tab title="Активированные">
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
                    :items="active_users"
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
                    <template v-slot:cell(name)="data">
                        <b-input-group size="sm">
                            <b-form-input :disabled="data.item.id===null" :value="data.item.name"
                                          @blur="save($event.target.value,data.item.id,'name')"
                                          placeholder="Введите имя"></b-form-input>
                        </b-input-group>
                    </template>
                    <template v-slot:cell(phone)="data">
                        <b-input-group size="sm">
                            <b-form-input :disabled="data.item.id===null" :value="data.item.phone"
                                          @blur="save($event.target.value,data.item.id,'phone')"
                                          placeholder="Введите телефон"></b-form-input>
                        </b-input-group>
                    </template>
                    <template v-slot:cell(user_type)="data">
                        <b-input-group size="sm">
                            <b-form-select
                                v-model="data.item.user_type"
                                :disabled="data.item.id===null"
                                :options="types"
                                @change="save(data.item.user_type,data.item.id,'user_type')">
                            </b-form-select>
                        </b-input-group>
                    </template>
                    <template v-slot:cell(bonus)="data">
                        <b-input-group size="sm">
                            <b-form-input :disabled="data.item.id===null" :value="data.item.bonus"
                                          @blur="save($event.target.value,data.item.id,'bonus')"
                                          placeholder="Введите количество бонусов"></b-form-input>
                        </b-input-group>
                    </template>
                    <template v-slot:cell(action)="data">
                        <b-input-group size="sm">
                            <b-button @click="remove(active_users, data.item.id)" class="btn btn-info mr-1 mb-1"
                                      :disabled="data.item.id===null">
                                <i class="far fa-trash-alt"></i>
                            </b-button>



                            <b-button @click="info(data.item, data.index, $event.target)" class="btn btn-info mr-1 mb-1">
                                <i class="fas fa-info"></i>
                            </b-button>
                            <!--                            <b-button @click="setPasswordItem(data.item)" class="btn btn-info mr-1 mb-1"-->
                            <!--                                      :disabled="data.item.id===null">-->
                            <!--                                Поменять пароль-->
                            <!--                            </b-button>-->
                            <b-button @click="sendAuthCode(data.item)" class="btn btn-info mr-1 mb-1"
                                      :disabled="data.item.id===null">
                                Отправить пароль
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
                                        <b-form-input type="text" :disabled="row.item.id===null"
                                                      :value="row.item.auth_code"
                                                      @blur="save($event.target.value,row.item.id,'auth_code')"
                                                      :placeholder="'Введите код доступа'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Тип курьера" label-size="sm"
                                                  class="mb-0">
                                        <b-form-select
                                            v-model="row.item.deliveryman_type"
                                            :disabled="row.item.id===null"
                                            :options="delivery_types"
                                            @change="save(row.item.deliveryman_type,row.item.id,'deliveryman_type')">
                                        </b-form-select>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Телеграм ID" label-size="sm"
                                                  class="mb-0">
                                        <b-form-input type="text" :disabled="row.item.id===null" :value="row.item.telegram_chat_id"
                                                      @blur="save($event.target.value,row.item.id,'telegram_chat_id')"
                                                      :placeholder="'Телеграм ID'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Дата рождения" label-size="sm"
                                                  class="mb-0">
                                        <b-form-input type="date" :disabled="row.item.id===null" :value="row.item.birthday"
                                                      @blur="save($event.target.value,row.item.id,'birthday')"
                                                      :placeholder="'Дата рождения'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Адрес" label-size="sm" class="mb-0">
                                        <b-form-input type="text" :disabled="row.item.id===null" :value="row.item.adress"
                                                      @blur="save($event.target.value,row.item.id,'adress')"
                                                      :placeholder="'Адрес'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Активация" label-size="sm" class="mb-0">
                                        <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary">
                                            <input class="c-switch-input" type="checkbox" :disabled="row.item.id===null"
                                                   name="active" :checked="row.item.active"
                                                   @change="save($event.target.checked?1:0,row.item.id,'active')">
                                            <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                        </label>
                                    </b-form-group>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Бонус" label-size="sm" class="mb-0">
                                        <b-form-input type="number" :disabled="row.item.id===null" :value="row.item.bonus"
                                                      @blur="save($event.target.value,row.item.id,'bonus')"
                                                      :placeholder="'Бонус'">
                                        </b-form-input>
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
            <b-tab title="Неактивированные">
                <b-row>
                    <b-col lg="6" class="my-1">
                        <b-form-group
                            label="Сортировка"
                            label-cols-sm="3"
                            label-align-sm="right"
                            label-size="sm"
                            label-for="sortBySelect2"
                            class="mb-0"
                        >
                            <b-input-group size="sm">
                                <b-form-select v-model="sortBy2" id="sortBySelect2" :options="sortOptions" class="w-75">
                                    <template v-slot:first>
                                        <option value="">-- none --</option>
                                    </template>
                                </b-form-select>
                                <b-form-select v-model="sortDesc2" size="sm" :disabled="!sortBy2" class="w-25">
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
                            label-for="filterInput2"
                            class="mb-0"
                        >
                            <b-input-group size="sm">
                                <b-form-input
                                    v-model="filter2"
                                    type="search"
                                    id="filterInput2"
                                    placeholder="Введите для поиска"
                                ></b-form-input>
                                <b-input-group-append>
                                    <b-button :disabled="!filter2" @click="filter2 = ''">Очистить</b-button>
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
                            label-for="perPageSelect2"
                            class="mb-0"
                        >
                            <b-form-select
                                v-model="perPage2"
                                id="perPageSelect2"
                                size="sm"
                                :options="pageOptions"
                            ></b-form-select>
                        </b-form-group>
                    </b-col>
                    <b-col sm="7" md="6" class="my-1">
                        <b-pagination
                            v-model="currentPage2"
                            :total-rows="totalRows2"
                            :per-page="perPage2"
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
                    :items="nonactive_users"
                    :fields="fields"
                    :current-page="currentPage2"
                    :per-page="perPage2"
                    :filter="filter2"
                    :filterIncludedFields="filterOn2"
                    :sort-by.sync="sortBy2"
                    :sort-desc.sync="sortDesc2"
                    :sort-direction="sortDirection2"
                    @filtered="onFiltered2"
                    :busy="loading"
                    empty-text="Нет записей для отображения"
                    empty-filtered-text="Нет записей, соответствующих вашему запросу"
                >
                    <template v-slot:cell(name)="data">
                        <b-input-group size="sm">
                            <b-form-input :disabled="data.item.id===null" :value="data.item.name"
                                          @blur="save($event.target.value,data.item.id,'name')"
                                          placeholder="Введите имя"></b-form-input>
                        </b-input-group>
                    </template>
                    <template v-slot:cell(phone)="data">
                        <b-input-group size="sm">
                            <b-form-input :disabled="data.item.id===null" :value="data.item.phone"
                                          @blur="save($event.target.value,data.item.id,'phone')"
                                          placeholder="Введите телефон"></b-form-input>
                        </b-input-group>
                    </template>
                    <template v-slot:cell(user_type)="data">
                        <b-input-group size="sm">
                            <b-form-select
                                v-model="data.item.user_type"
                                :disabled="data.item.id===null"
                                :options="types"
                                @change="save(data.item.user_type,data.item.id,'user_type')">
                            </b-form-select>
                        </b-input-group>
                    </template>
                    <template v-slot:cell(bonus)="data">
                        <b-input-group size="sm">
                            <b-form-input :disabled="data.item.id===null" :value="data.item.bonus"
                                          @blur="save($event.target.value,data.item.id,'bonus')"
                                          placeholder="Введите количество бонусов"></b-form-input>
                        </b-input-group>
                    </template>
                    <template v-slot:cell(action)="data">
                        <b-input-group size="sm">
                            <b-button @click="remove(nonactive_users, data.item.id)" class="btn btn-info mr-1 mb-1"
                                      :disabled="data.item.id===null">
                                <i class="far fa-trash-alt"></i>
                            </b-button>

                            <b-button @click="info(data.item, data.index, $event.target)" class="btn btn-info mr-1 mb-1">
                                <i class="fas fa-info"></i>
                            </b-button>
                            <!--                            <b-button @click="setPasswordItem(data.item)" class="btn btn-info mr-1 mb-1"-->
                            <!--                                      :disabled="data.item.id===null">-->
                            <!--                                Поменять пароль-->
                            <!--                            </b-button>-->
                            <b-button @click="sendAuthCode(data.item)" class="btn btn-info mr-1 mb-1"
                                      :disabled="data.item.id===null">
                                Отправить пароль
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
                                        <b-form-input type="text" :disabled="row.item.id===null"
                                                      :value="row.item.auth_code"
                                                      @blur="save($event.target.value,row.item.id,'auth_code')"
                                                      :placeholder="'Введите код доступа'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Тип курьера" label-size="sm"
                                                  class="mb-0">
                                        <b-form-select
                                            v-model="row.item.deliveryman_type"
                                            :disabled="row.item.id===null"
                                            :options="delivery_types"
                                            @change="save(row.item.deliveryman_type,row.item.id,'deliveryman_type')">
                                        </b-form-select>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Телеграм ID" label-size="sm"
                                                  class="mb-0">
                                        <b-form-input type="text" :disabled="row.item.id===null" :value="row.item.telegram_chat_id"
                                                      @blur="save($event.target.value,row.item.id,'telegram_chat_id')"
                                                      :placeholder="'Телеграм ID'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Дата рождения" label-size="sm"
                                                  class="mb-0">
                                        <b-form-input type="date" :disabled="row.item.id===null" :value="row.item.birthday"
                                                      @blur="save($event.target.value,row.item.id,'birthday')"
                                                      :placeholder="'Дата рождения'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Адрес" label-size="sm" class="mb-0">
                                        <b-form-input type="text" :disabled="row.item.id===null" :value="row.item.adress"
                                                      @blur="save($event.target.value,row.item.id,'adress')"
                                                      :placeholder="'Адрес'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Активация" label-size="sm" class="mb-0">
                                        <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary">
                                            <input class="c-switch-input" type="checkbox" :disabled="row.item.id===null"
                                                   name="active" :checked="row.item.active"
                                                   @change="save($event.target.checked?1:0,row.item.id,'active')">
                                            <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                        </label>
                                    </b-form-group>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Бонус" label-size="sm" class="mb-0">
                                        <b-form-input type="number" :disabled="row.item.id===null" :value="row.item.bonus"
                                                      @blur="save($event.target.value,row.item.id,'bonus')"
                                                      :placeholder="'Бонус'">
                                        </b-form-input>
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
                            label-for="sortBySelect3"
                            class="mb-0"
                        >
                            <b-input-group size="sm">
                                <b-form-select v-model="sortBy3" id="sortBySelect3" :options="sortOptions" class="w-75">
                                    <template v-slot:first>
                                        <option value="">-- none --</option>
                                    </template>
                                </b-form-select>
                                <b-form-select v-model="sortDesc3" size="sm" :disabled="!sortBy" class="w-25">
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
                            label-for="filterInput3"
                            class="mb-0"
                        >
                            <b-input-group size="sm">
                                <b-form-input
                                    v-model="filter3"
                                    type="search"
                                    id="filterInput3"
                                    placeholder="Введите для поиска"
                                ></b-form-input>
                                <b-input-group-append>
                                    <b-button :disabled="!filter3" @click="filter3 = ''">Очистить</b-button>
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
                            label-for="perPageSelect3"
                            class="mb-0"
                        >
                            <b-form-select
                                v-model="perPage3"
                                id="perPageSelect3"
                                size="sm"
                                :options="pageOptions"
                            ></b-form-select>
                        </b-form-group>
                    </b-col>

                    <b-col sm="7" md="6" class="my-1">
                        <b-pagination
                            v-model="currentPage3"
                            :total-rows="totalRows3"
                            :per-page="perPage3"
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
                    :items="deleted_users"
                    :fields="fields"
                    :current-page="currentPage3"
                    :per-page="perPage3"
                    :filter="filter3"
                    :filterIncludedFields="filterOn3"
                    :sort-by.sync="sortBy3"
                    :sort-desc.sync="sortDesc3"
                    :sort-direction="sortDirection3"
                    @filtered="onFiltered3"
                    :busy="loading"
                    empty-text="Нет записей для отображения"
                    empty-filtered-text="Нет записей, соответствующих вашему запросу"
                >
                    <template v-slot:cell(name)="data">
                        <b-input-group size="sm">
                            <b-form-input :disabled="data.item.id===null" :value="data.item.name"
                                          @blur="save($event.target.value,data.item.id,'name')"
                                          placeholder="Введите имя"></b-form-input>
                        </b-input-group>
                    </template>
                    <template v-slot:cell(phone)="data">
                        <b-input-group size="sm">
                            <b-form-input :disabled="data.item.id===null" :value="data.item.phone"
                                          @blur="save($event.target.value,data.item.id,'phone')"
                                          placeholder="Введите телефон"></b-form-input>
                        </b-input-group>
                    </template>
                    <template v-slot:cell(user_type)="data">
                        <b-input-group size="sm">
                            <b-form-select
                                v-model="data.item.user_type"
                                :disabled="data.item.id===null"
                                :options="types"
                                @change="save(data.item.user_type,data.item.id,'user_type')">
                            </b-form-select>
                        </b-input-group>
                    </template>
                    <template v-slot:cell(bonus)="data">
                        <b-input-group size="sm">
                            <b-form-input :disabled="data.item.id===null" :value="data.item.bonus"
                                          @blur="save($event.target.value,data.item.id,'bonus')"
                                          placeholder="Введите количество бонусов"></b-form-input>
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
                            <!--                            <b-button @click="setPasswordItem(data.item)" class="btn btn-info mr-1 mb-1"-->
                            <!--                                      :disabled="data.item.id===null">-->
                            <!--                                Поменять пароль-->
                            <!--                            </b-button>-->
                            <b-button @click="sendAuthCode(data.item)" class="btn btn-info mr-1 mb-1"
                                      :disabled="data.item.id===null">
                                Отправить пароль
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
                                        <b-form-input type="text" :disabled="row.item.id===null"
                                                      :value="row.item.auth_code"
                                                      @blur="save($event.target.value,row.item.id,'auth_code')"
                                                      :placeholder="'Введите код доступа'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Тип курьера" label-size="sm"
                                                  class="mb-0">
                                        <b-form-select
                                            v-model="row.item.deliveryman_type"
                                            :disabled="row.item.id===null"
                                            :options="delivery_types"
                                            @change="save(row.item.deliveryman_type,row.item.id,'deliveryman_type')">
                                        </b-form-select>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Телеграм ID" label-size="sm"
                                                  class="mb-0">
                                        <b-form-input type="text" :disabled="row.item.id===null" :value="row.item.telegram_chat_id"
                                                      @blur="save($event.target.value,row.item.id,'telegram_chat_id')"
                                                      :placeholder="'Телеграм ID'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Дата рождения" label-size="sm"
                                                  class="mb-0">
                                        <b-form-input type="date" :disabled="row.item.id===null" :value="row.item.birthday"
                                                      @blur="save($event.target.value,row.item.id,'birthday')"
                                                      :placeholder="'Дата рождения'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Адрес" label-size="sm" class="mb-0">
                                        <b-form-input type="text" :disabled="row.item.id===null" :value="row.item.adress"
                                                      @blur="save($event.target.value,row.item.id,'adress')"
                                                      :placeholder="'Адрес'">
                                        </b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Активация" label-size="sm" class="mb-0">
                                        <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary">
                                            <input class="c-switch-input" type="checkbox" :disabled="row.item.id===null"
                                                   name="active" :checked="row.item.active"
                                                   @change="save($event.target.checked?1:0,row.item.id,'active')">
                                            <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                        </label>
                                    </b-form-group>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-4 mb-2">
                                    <b-form-group label-cols-lg="4" label="Бонус" label-size="sm" class="mb-0">
                                        <b-form-input type="number" :disabled="row.item.id===null" :value="row.item.bonus"
                                                      @blur="save($event.target.value,row.item.id,'bonus')"
                                                      :placeholder="'Бонус'">
                                        </b-form-input>
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
        <b-modal :id="infoModal.id" :title="infoModal.title" ok-only @hide="resetInfoModal">
            <pre>{{ infoModal.content }}</pre>
        </b-modal>
<!--        Change Password Modal-->

<!--        <b-modal-->
<!--            id="passwordModal"-->
<!--            ref="passwordModal"-->
<!--            title="Изменение пароля"-->
<!--            @show="resetModal"-->
<!--            @hidden="resetModal"-->
<!--            @ok="handleOk"-->
<!--        >-->
<!--            <form ref="form" @submit.stop.prevent="handleSubmit">-->
<!--                <b-form-group-->
<!--                    :state="passwordState"-->
<!--                    label="Пароль"-->
<!--                    label-for="password-input"-->
<!--                    invalid-feedback="Введите пароль"-->
<!--                >-->
<!--                    <b-form-input-->
<!--                        id="password-input"-->
<!--                        type="password"-->
<!--                        v-model="password"-->
<!--                        :state="passwordState"-->
<!--                        required-->
<!--                    ></b-form-input>-->
<!--                </b-form-group>-->
<!--                <b-form-group-->
<!--                    :state="confirmPasswordState"-->
<!--                    label="Подтвердите пароль"-->
<!--                    label-for="password-input"-->
<!--                    invalid-feedback="Данное поле должно совпадать с полем Пароль"-->
<!--                >-->
<!--                    <b-form-input-->
<!--                        id="password-input"-->
<!--                        type="password"-->
<!--                        v-model="confirmPassword"-->
<!--                        :state="confirmPasswordState"-->
<!--                        required-->
<!--                    ></b-form-input>-->
<!--                </b-form-group>-->
<!--            </form>-->
<!--        </b-modal>-->
    </b-container>
</template>

<script>
    export default {
        data() {
            return {
                sortBy: 'name',
                sortDesc: false,
                sortBy1: 'name',
                sortDesc1: false,
                sortBy2: 'name',
                sortDesc2: false,
                sortBy3: 'name',
                sortDesc3: false,

                fields: [
                    {key: 'name', label: 'Имя', sortable: true, sortDirection: 'desc'},
                    {key: 'phone', label: 'Телефон', sortable: true, sortDirection: 'desc'},
                    {key: 'user_type', label: 'Тип', sortable: true, sortDirection: 'desc'},
                    {key: 'bonus', label: 'Бонусы', sortable: true, sortDirection: 'desc'},
                    {key: 'action', label: 'Действие'},
                ],
                users: [],
                active_users: [],
                nonactive_users: [],
                deleted_users: [],
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
                totalRows: 1,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15, 25, 50, 100],
                sortDirection: 'asc',
                filter: null,
                filterOn: [],

                totalRows1: 1,
                currentPage1: 1,
                perPage1: 5,
                sortDirection1: 'asc',
                filter1: null,
                filterOn1: [],

                totalRows2: 1,
                currentPage2: 1,
                perPage2: 5,
                sortDirection2: 'asc',
                filter2: null,
                filterOn2: [],

                totalRows3: 1,
                currentPage3: 1,
                perPage3: 5,
                sortDirection3: 'asc',
                filter3: null,
                filterOn3: [],

                infoModal: {
                    id: 'info-modal',
                    title: '',
                    content: ''
                },
                loading: false,

                new_user: {
                    name:'',
                    phone:'',
                    user_type: 0,
                    deliveryman_type: 0
                }
                // password: '',
                // passwordItem: null,
                // passwordState: null,
                // confirmPassword: '',
                // confirmPasswordState: null,
            }
        },
        computed: {
            sortOptions() {
                return this.fields
                    .filter(f => f.sortable)
                    .map(f => {
                        return {text: f.label, value: f.key}
                    })
            }
        },
        mounted() {
            this.loadData();
        },
        methods: {
            info(item, index, button) {
                this.infoModal.title = `Row index: ${index}`
                this.infoModal.content = JSON.stringify(item, null, 2)
                this.$root.$emit('bv::show::modal', this.infoModal.id, button)
            },
            resetInfoModal() {
                this.infoModal.title = '';
                this.infoModal.content = '';
            },
            onFiltered(filteredItems) {
                this.totalRows = filteredItems.length;
                this.currentPage = 1
            },
            onFiltered1(filteredItems) {
                this.totalRows1 = filteredItems.length;
                this.currentPage1 = 1
            },
            onFiltered2(filteredItems) {
                this.totalRows2 = filteredItems.length;
                this.currentPage2 = 1
            },
            onFiltered3(filteredItems) {
                this.totalRows3 = filteredItems.length;
                this.currentPage3 = 1
            },
            async remove(arr, id) {
                let foundIndex = arr.findIndex(x => x.id === id);

                const response = await axios
                    .delete(`/admin/users/destroy/${id}`)
                    .then(resp => {
                        this.deleted_users.push(arr[foundIndex]);
                        arr.splice(foundIndex, 1);
                        this.sendMessage(resp.data.message)
                    });
            },
            async restore(id) {
                const response = await axios
                    .post(`/admin/users/restore/${id}`)
                    .then(resp => {
                        this.sendMessage(resp.data.message)
                        this.loadData()
                    });
            },
            async save(value, id, key) {
                const response = await axios
                    .put(`/admin/users/update/${id}`, {
                        param: key,
                        value: value
                    }).then(resp => {
                    this.sendMessage(resp.data.message)
                });
            },
            async loadData() {
                this.loading = true;
                const response = await axios
                    .get('/admin/users/get')
                    .then(resp => {
                        this.users = resp.data.users;
                        this.totalRows = this.users.length;

                        this.active_users = this.users.filter(user => user.active == 1);
                        this.totalRows1 = this.active_users.length;

                        this.nonactive_users = this.users.filter(user => user.active == 0);
                        this.totalRows2 = this.nonactive_users.length;

                        this.deleted_users = resp.data.deleted_users;
                        this.totalRows3 = this.deleted_users.length;

                        this.loading = false;
                    });
            },
            async loadDeletedUsers() {
                this.loading = true;
                const response = await axios
                    .get('/admin/users')
                    .then(resp => {
                        this.deleted_users = resp.data.deleted_users;
                        this.totalRows2 = this.deleted_users.length;
                        this.loading = false;
                    });
            },
            sendMessage(message) {
                this.$notify({
                    group: 'message',
                    type: 'success',
                    title: 'Пользователи',
                    text: message
                });
            },

            //Change Password Function and Modal
            // setPasswordItem(item) {
            //    this.passwordItem = item;
            //    this.$refs['passwordModal'].show();
            // },
            // checkFormValidity() {
            //     const valid = this.$refs.form.checkValidity()
            //     this.passwordState = valid
            //     return valid
            // },
            // checkConfirmPassword() {
            //     const validForm = this.$refs.form.checkValidity();
            //     if(validForm == true){
            //         if(this.password == this.confirmPassword)
            //         {
            //             const valid = true;
            //             this.confirmPasswordState = valid;
            //             return valid;
            //         }
            //         else
            //         {
            //             const valid = false;
            //             this.confirmPasswordState = valid;
            //             return valid;
            //         }
            //     }
            //     else{
            //         this.confirmPasswordState = validForm;
            //         return validForm;
            //     }
            //
            //     // const valid = this.$refs.form.checkValidity()
            //     // this.confirmPasswordState = valid
            //     // return valid
            // },
            // resetModal() {
            //     this.password = ''
            //     this.passwordState = null
            //     this.confirmPassword = ''
            //     this.confirmPasswordState = null
            //     // this.passwordItem = null
            // },
            // handleOk(bvModalEvt) {
            //     bvModalEvt.preventDefault();
            //     this.handleSubmit();
            // },
            // handleSubmit() {
            //     if (!this.checkFormValidity()) {
            //         return
            //     }
            //     if (!this.checkConfirmPassword()) {
            //         return
            //     }
            //     var data = {
            //         id: this.passwordItem.id,
            //         password: this.password
            //     }
            //     axios
            //         .post('/admin/users/changePassword', data)
            //         .then(resp => {
            //             this.sendMessage('Новый пароль пользователя успешно сохранен')
            //         });
            //     this.$nextTick(() => {
            //         this.$bvModal.hide('passwordModal')
            //     })
            // },

            sendAuthCode(item) {
                var data = {
                    id: item.id,
                }
                axios
                    .post('/admin/users/sendAuthCode', data)
                    .then(() => {
                        this.sendMessage('Новый пароль пользователя успешно отправлен')
                    });
            },
            createUser() {
                console.log(this.new_user)
                if(this.new_user.user_type!=1) {
                    this.new_user.deliveryman_type=0;
                }
                axios.post('/admin/users/store', this.new_user)
                    .then(resp => {
                        this.users.push(resp.data.user);
                        this.new_user.name='';
                        this.new_user.phone='';
                        this.new_user.user_type=0;
                        this.new_user.deliveryman_type=0;
                        this.$bvModal.hide("new-user");
                        this.sendMessage(resp.data.message)
                    });
            },
            cancel() {
                this.new_user.name='';
                this.new_user.phone='';
                this.new_user.user_type=0;
                this.new_user.deliveryman_type=0;
                this.$bvModal.hide("new-user");
            },

        }
    }
</script>

<style scoped>

</style>
