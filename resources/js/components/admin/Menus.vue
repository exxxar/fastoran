<template>
    <div>
        <notifications group="message"/>

        <div class="row">
            <div class="col-md-2 col-sm-12 mb-2"><b-button v-b-toggle.collapse-1 variant="primary" >Добавить меню</b-button></div>
            <div class="col-md-2 col-sm-12 mb-2"><b-button variant="primary">Загрузить из ВК</b-button></div>
        </div>
        <b-collapse id="collapse-1" class="mt-2">
            <b-container fluid>
                <!-- User Interface controls -->
                <b-row>
                    <b-col lg="12" class="my-1">
                        <b-form @submit="onSubmit" class="mb-2">
                            <div class="row">
                                <div class="col-sm-12 col-md-4  mt-2">
                                    <b-form-group label-cols-lg="4" label="Наименование продукта" label-size="sm"
                                                  class="mb-0">
                                        <b-form-input v-model="form.food_name"
                                                      placeholder="Введите наименование продукта"></b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4  mt-2">
                                    <b-form-group label-cols-lg="4" label="Описание продукта" label-size="sm"
                                                  class="mb-0">
                                        <b-form-input v-model="form.food_remark"
                                                      placeholder="Введите описание продукта"></b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4  mt-2">
                                    <b-form-group label-cols-lg="4" label="Вес продутка" label-size="sm" class="mb-0">
                                        <b-form-input type="number" v-model="form.food_ext"
                                                      placeholder="Введите массу продукта"></b-form-input>
                                    </b-form-group>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-4  mt-2">
                                    <b-form-group label-cols-lg="4" label="Цена продукта" label-size="sm" class="mb-0">
                                        <b-form-input type="number" v-model="form.food_price"
                                                      placeholder="Введите цену продукта"></b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4  mt-2">
                                    <b-form-group label-cols-lg="4" label="Идентификатор рубрики" label-size="sm"
                                                  class="mb-0">
                                        <b-form-input type="number" v-model="form.food_rubr_id"
                                                      placeholder="Идентификатор рубрики"></b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4  mt-2">
                                    <b-form-group label-cols-lg="4" label="Идентификатор раздела" label-size="sm"
                                                  class="mb-0">
                                        <b-form-input type="number" v-model="form.food_razdel_id"
                                                      placeholder="Идентификатор раздела"></b-form-input>
                                    </b-form-group>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-12 col-md-4  mt-2">
                                    <b-form-group label-cols-lg="4" label="Идентификатор категории" label-size="sm"
                                                  class="mb-0">
                                        <b-form-input type="number" v-model="form.food_category_id"
                                                      placeholder="Идентификатор категории"></b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4  mt-2">
                                    <b-form-group label-cols-lg="4" label="Изображение продукта" label-size="sm"
                                                  class="mb-0">
                                        <b-form-input v-model="form.food_img"
                                                      placeholder="Изображение продукта"></b-form-input>
                                    </b-form-group>
                                </div>
                                <div class="col-sm-12 col-md-4  mt-2">
                                    <b-form-group label-cols-lg="4" label="Бонус" label-size="sm" class="mb-0">
                                        <b-form-input type="number" v-model="form.bonus"
                                                      placeholder="Бонус"></b-form-input>
                                    </b-form-group>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12 col-md-4 mt-2">
                                    <b-form-group label-cols-lg="4" label="Продукт в стоп листе" label-size="sm"
                                                  class="mb-0">
                                        <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary">
                                            <input class="c-switch-input" type="checkbox" v-model="form.stop_list">
                                            <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                                        </label>
                                    </b-form-group>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-2  mt-2">
                                    <button type="submit" class="btn btn-info">Добавить</button>
                                </div>
                            </div>
                        </b-form>
                    </b-col>
                </b-row>
            </b-container>
        </b-collapse>
        <hr>
        <b-container fluid>
            <!-- User Interface controls -->
            <b-row>
                <b-col lg="6" class="my-1">
                    <b-form-group
                        label="Sort"
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
                        label="Filter"
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
                                placeholder="Type to Search"
                            ></b-form-input>
                            <b-input-group-append>
                                <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                            </b-input-group-append>
                        </b-input-group>
                    </b-form-group>
                </b-col>


                <b-col sm="5" md="6" class="my-1">
                    <b-form-group
                        label="Per page"
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
            >
                <template v-slot:cell(food_name)="data">
                    <b-input-group size="sm">
                        <b-form-input :disabled="data.item.id===null" :value="data.item.food_name"
                                      @blur="save($event.target.value,data.item.id,'food_name')"
                                      placeholder="Введите название кухни"></b-form-input>
                    </b-input-group>
                </template>

                <template v-slot:cell(food_remark)="data">
                    <b-input-group size="sm">
                        <b-form-input :disabled="data.item.id===null" :value="data.item.food_remark"
                                      @blur="save($event.target.value,data.item.id,'food_remark')"
                                      placeholder="Введите ссылку на картинку"></b-form-input>
                    </b-input-group>
                </template>

                <template v-slot:cell(food_ext)="data">
                    <b-input-group size="sm">
                        <b-form-input :disabled="data.item.id===null" :value="data.item.food_ext"
                                      @blur="save($event.target.value,data.item.id,'food_ext')"
                                      placeholder="Введите ссылку на картинку"></b-form-input>
                    </b-input-group>
                </template>

                <template v-slot:cell(stop_list)="data">
                    <b-input-group size="sm">
                        <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary">
                            <input class="c-switch-input" type="checkbox" :disabled="data.item.id===null"
                                   name="is_active" :checked="data.item.stop_list"
                                   @change="save($event.target.checked?1:0,data.item.id,'view')">
                            <span class="c-switch-slider" data-checked="✓" data-unchecked="✕"></span>
                        </label>
                    </b-input-group>
                </template>

                <template v-slot:cell(action)="data">
                    <b-input-group size="sm">
                        <b-button @click="remove(data.item.id)" class="btn btn-info mr-1"
                                  :disabled="data.item.id===null">
                            <i class="far fa-trash-alt"></i>
                        </b-button>

                        <b-button target="_blank" :href="'/rest-list/kitchen/'+data.item.id"
                                  :disabled="data.item.id===null" class="btn btn-info mr-1"><i
                            class="fas fa-eye"></i></b-button>

                        <b-button @click="info(data.item, data.index, $event.target)" class="btn btn-info mr-1">
                            <i class="fas fa-info"></i>
                        </b-button>
                        <b-button @click="data.toggleDetails" class="btn btn-info mr-1">

                            {{ data.detailsShowing ? 'Скрыть' : 'Показать' }}
                        </b-button>

                    </b-input-group>


                </template>

                <template v-slot:row-details="row">
                    <b-card>

                        <div class="row">
                            <div class="col-sm-12 col-md-4 mb-2">
                                <b-form-group label-cols-lg="4" label="Цена продукта" label-size="sm" class="mb-0">
                                    <b-form-input type="number" :disabled="row.item.id===null"
                                                  :value="row.item.food_price"
                                                  @blur="save($event.target.value,row.item.id,'food_price')"
                                                  :placeholder="'Введите цену продукта'">
                                    </b-form-input>
                                </b-form-group>
                            </div>
                            <div class="col-sm-12 col-md-4 mb-2">
                                <b-form-group label-cols-lg="4" label="Идентификатор рубрики" label-size="sm"
                                              class="mb-0">
                                    <b-form-input type="number" :disabled="row.item.id===null"
                                                  :value="row.item.food_rubr_id"
                                                  @blur="save($event.target.value,row.item.id,'food_rubr_id')"
                                                  :placeholder="'Идентификатор рубрики'">
                                    </b-form-input>
                                </b-form-group>
                            </div>
                            <div class="col-sm-12 col-md-4 mb-2">
                                <b-form-group label-cols-lg="4" label="Идентификатор раздел" label-size="sm"
                                              class="mb-0">
                                    <b-form-input type="number" :disabled="row.item.id===null"
                                                  :value="row.item.food_razdel_id"
                                                  @blur="save($event.target.value,row.item.id,'food_razdel_id')"
                                                  :placeholder="'Идентификатор раздела'">
                                    </b-form-input>
                                </b-form-group>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-4 mb-2">
                                <b-form-group label-cols-lg="4" label="Идентификатор ресторана" label-size="sm"
                                              class="mb-0">
                                    <b-form-input type="number" :disabled="row.item.id===null" :value="row.item.rest_id"
                                                  @blur="save($event.target.value,row.item.id,'rest_id')"
                                                  :placeholder="'Идентификатор ресторана'">
                                    </b-form-input>
                                </b-form-group>
                            </div>
                            <div class="col-sm-12 col-md-4 mb-2">
                                <b-form-group label-cols-lg="4" label="Идентификатор категории" label-size="sm"
                                              class="mb-0">
                                    <b-form-input type="number" :disabled="row.item.id===null"
                                                  :value="row.item.food_category_id"
                                                  @blur="save($event.target.value,row.item.id,'food_category_id')"
                                                  :placeholder="'Идентификатор категории'">
                                    </b-form-input>
                                </b-form-group>
                            </div>
                            <div class="col-sm-12 col-md-4 mb-2">
                                <b-form-group label-cols-lg="4" label="Изображение продукта" label-size="sm"
                                              class="mb-0">
                                    <b-form-input :disabled="row.item.id===null" :value="row.item.food_img"
                                                  @blur="save($event.target.value,row.item.id,'food_img')"
                                                  :placeholder="'Изображение продукта'">
                                    </b-form-input>
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
            </b-table>

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
                exclude: ['id', 'created_at', 'updated_at', '_showDetails'],
                fields: [

                    {key: 'food_name', label: 'Название кухни', sortable: true, sortDirection: 'desc'},
                    {key: 'food_remark', label: 'Описание кухни', sortable: true, sortDirection: 'desc'},
                    {key: 'food_ext', label: 'Масса на выходе', sortable: true, sortDirection: 'desc'},
                    {key: 'stop_list', label: 'В стоп листе', sortable: true, sortDirection: 'desc'},
                    {key: 'action', label: 'Действие'},
                ],
                items: [],
                form: {
                    food_name: '',
                    food_remark: '',
                    food_ext: 0,
                    food_price: 0,
                    food_rubr_id: 0,
                    food_razdel_id: 0,
                    rest_id: 0,
                    food_category_id: 0,
                    food_img: '',
                    bonus: 0,
                    stop_list: false,
                },
                totalRows: 1,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15],
                sortDirection: 'asc',
                filter: null,
                filterOn: [],
                infoModal: {
                    id: 'info-modal',
                    title: '',
                    content: ''
                }
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
        mounted() {

            this.loadData()
        },
        methods: {
            isExclude(key) {
                console.log(key)
                return !this.exclude.includes(key);
            },
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
            remove(id) {

                let foundIndex = this.items.findIndex(x => x.id === id);
                this.items[foundIndex].id = null;

                axios
                    .delete(`/api/v1/fastoran/menus/${id}`)
                    .then(() => {
                        this.loadData()
                    });
            },
            save(value, id, key) {
                axios
                    .put(`/api/v1/fastoran/menus/${id}`, {
                        param: key,
                        value: value
                    }).then(() => {
                    this.loadData()
                });

            },

            loadData() {
                axios
                    .get('/api/v1/fastoran/menus')
                    .then(resp => {
                        this.items = resp.data.menus
                        this.totalRows = this.items.length
                    });
            },
            sendMessage(message) {
                this.$notify({
                    group: 'message',
                    type: 'success',
                    title: 'Кухни',
                    text: message
                });
            },
            onSubmit(e) {
                e.preventDefault()

                this.items.push({
                    id: null,
                    food_name: this.form.food_name,
                    food_remark: this.form.food_remark,
                    food_ext: this.form.food_ext,
                    food_price: this.form.food_price,
                    food_rubr_id: this.form.food_rubr_id,
                    food_razdel_id: this.form.food_razdel_id,
                    rest_id: this.form.rest_id,
                    food_category_id: this.form.food_category_id,
                    food_img: this.form.food_img,
                    bonus: this.form.bonus,
                    stop_list: this.form.stop_list,
                })

                axios
                    .post('/api/v1/fastoran/menus', {
                        food_name: this.form.food_name,
                        food_remark: this.form.food_remark,
                        food_ext: this.form.food_ext,
                        food_price: this.form.food_price,
                        food_rubr_id: this.form.food_rubr_id,
                        food_razdel_id: this.form.food_razdel_id,
                        rest_id: this.form.rest_id,
                        food_category_id: this.form.food_category_id,
                        food_img: this.form.food_img,
                        bonus: this.form.bonus,
                        stop_list: this.form.stop_list,
                    }).then((resp) => {

                    this.sendMessage(resp.data.message)
                    this.form.food_name = "";
                    this.form.food_remark = "";
                    this.form.food_ext = 0;
                    this.form.food_price = 0;
                    this.form.food_rubr_id = 0;
                    this.form.food_razdel_id = 0;
                    this.form.rest_id = 0;
                    this.form.food_category_id = 0;
                    this.form.food_img = "";
                    this.form.bonus = 0;
                    this.form.stop_list = false;
                    this.loadData()
                });
            }
        }
    }
</script>
