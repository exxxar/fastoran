<template>
    <div>
        <notifications group="message"/>

        <b-button v-b-toggle.collapse-1 variant="primary">Форма добавления ресторана</b-button>
        <b-collapse id="collapse-1" class="mt-2">
            <b-container fluid>
                <!-- User Interface controls -->
                <b-row>
                    <b-col lg="12" class="my-1">


                        <b-form @submit="onSubmit" class="mb-2">

                            <div class="row">
                                <div class="col-sm-12 col-md-4  mt-2" v-for="field in included_fields">
                                    <b-form-group label-cols-lg="4" label="field" label-size="sm"
                                                  class="mb-0">
                                        <b-form-input :name="field"
                                                      placeholder="Введите наименование продукта"></b-form-input>
                                    </b-form-group>
                                </div>
                            </div>



                        </b-form>
                        <hr>

                    </b-col>
                </b-row>
            </b-container>
        </b-collapse>

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
                <template v-slot:cell(name)="data">
                    <b-input-group size="sm">
                        <b-form-input :disabled="data.item.id===null" :value="data.item.name"
                                      @blur="save($event.target.value,data.item.id,'name')"
                                      placeholder="Введите название кухни"></b-form-input>
                    </b-input-group>
                </template>

                <template v-slot:cell(img)="data">
                    <b-input-group size="sm">
                        <b-form-input :disabled="data.item.id===null" :value="data.item.img"
                                      @blur="save($event.target.value,data.item.id,'img')"
                                      placeholder="Введите ссылку на картинку"></b-form-input>
                    </b-input-group>
                </template>

                <template v-slot:cell(view)="data">
                    <b-input-group size="sm">
                        <label class="c-switch c-switch-label c-switch-pill c-switch-opposite-primary">
                            <input class="c-switch-input" type="checkbox" :disabled="data.item.id===null"
                                   name="is_active" :checked="data.item.view"
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
                        <ul>
                            <li v-for="(value, key) in row.item" :key="key">
                                {{ key }}: {{ value }}
                            </li>
                        </ul>
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
                included_fields: [
                    'name',
                    'category',
                    'adress',
                    'orientir',
                    'city',
                    'region_id',
                    'phone1',
                    'phone2',
                    'www',
                    'mail',
                    'tim',
                    'checkout',
                    'dance',
                    'karaoke',
                    'wifi',
                    'bussines',
                    'parking',
                    'children',
                    'remark',
                    'cont_face',
                    'cont_phone',
                    'vk_page',
                    'odn_page',
                    'inst_page',
                    'manager',
                    'logo',
                    'money',
                    'rating',
                    'seo_domen',
                    'seo_title',
                    'seo_h1',
                    'seo_description',
                    'url',
                    'view',
                    'comments',
                    'images',
                    'reg_dat',
                    'rest_like',
                    'rest_antilike',
                    'rest_img',
                    'moderation',
                    'tarif',
                    'fav',
                    'count_people',
                    'special',
                    'discount',
                    'dir_mail',
                    'bron_phone',
                    'discount_text',
                    'phone_view',
                    'child',
                    'min_sum',
                    'price_delivery',
                    'time_delivery',
                    'filters',
                    'fastoran_money',
                    'sms',
                    'start_lanch',
                    'end_lanch',
                    'telegram_channel'
                ],
                fields: [
                    {key: 'name', label: 'Название кухни', sortable: true, sortDirection: 'desc'},
                    {key: 'img', label: 'Картинка', sortable: true, sortDirection: 'desc'},
                    {key: 'view', label: 'Отображение', sortable: true, sortDirection: 'desc'},
                    {key: 'action', label: 'Действие'},
                ],
                items: [],
                form: {
                    name: '',
                    img: ''
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
                    .delete(`/api/v1/fastoran/restorans/${id}`)
                    .then(() => {
                        this.loadData()
                    });
            },
            save(value, id, key) {
                axios
                    .put(`/api/v1/fastoran/restorans/${id}`, {
                        param: key,
                        value: value
                    }).then(() => {
                    this.loadData()
                });

            },

            loadData() {
                axios
                    .get('/api/v1/fastoran/restorans')
                    .then(resp => {
                        this.items = resp.data.restorans
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
                    name: this.form.name,
                    img: this.form.img,
                    view: 0
                })

                axios
                    .post('/api/v1/fastoran/restorans', {
                        name: this.form.name,
                        img: this.form.img
                    }).then((resp) => {
                    this.sendMessage(resp.data.message)
                    this.form.name = '';
                    this.form.img = '';
                    this.loadData()
                });
            }
        }
    }
</script>
