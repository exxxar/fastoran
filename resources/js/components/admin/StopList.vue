<template>
    <div>
        <notifications group="message"/>
        <div class="search-wrapper">
            <input type="text" class="mb-4 mt-4" v-model="search" placeholder="Поиск"/>
        </div>
        <div v-if="loading" class="d-flex justify-content-center mb-3">
            <b-spinner style="width: 3rem; height: 3rem;" label="Large Spinner"></b-spinner>
            <h2 style="height: 3rem;" class="mt-auto mb-auto ml-3">
                Загрузка...
            </h2>
        </div>
        <b-card-group deck class="mb-4" v-for="chunk in productChunks" v-bind:key="chunk.id">
            <b-card
                v-for="item in chunk"
                v-bind:key="item.id"
                :border-variant="item.stop_list==0 ? 'success':'danger'"
                :header="item.stop_list==0 ? 'В меню':'В стоп листе'"
                :header-bg-variant="item.stop_list==0 ? 'success':'danger'"
                header-text-variant="white"
                align="center"
                style="max-width: 198px; cursor: pointer;"
                @click="save(item)"
            >
                <template v-slot:header>
                    <b-spinner small v-if="card_loading && in_process.includes(item.id)"></b-spinner>
                </template>

                <b-card-img :src="item.food_img" alt="Image"></b-card-img>
                <b-card-text>
                    {{item.food_name}}
                </b-card-text>
            </b-card>
        </b-card-group>
    </div>
</template>

<script>
    export default {
        props: ['restoran'],
        data() {
            return {
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
                search: '',
                items: [],
                in_process:[],
                // filteredList: [],
                // productChunks:[],
                loading: false,
                card_loading: false,
            }
        },
        computed: {
            filteredList() {
                return this.items.filter(item => {
                    return item.food_name.toLowerCase().includes(this.search.toLowerCase())
                })
            },
            productChunks(){
                return _.chunk(Object.values(this.items.filter(item => {
                    return item.food_name.toLowerCase().includes(this.search.toLowerCase())
                })), 5);
            }
        },
        created() {
            this.loadData()
        },
        methods: {
            async save(item) {
                this.card_loading = true;
                this.in_process.push(item.id)
                const response = await axios
                    .put(`/admin/menus/update/${item.id}`, {
                        param:'stop_list',
                        value: !item.stop_list
                    }).then(resp => {
                        let foundIndex = this.items.findIndex(x => x.id === item.id);
                        this.items[foundIndex].stop_list = !item.stop_list;
                        this.in_process = this.in_process.filter(x => x !== item.id);
                        // this.loadData()
                        this.sendMessage(resp.data.message)
                });
                this.card_loading = false;
            },

            async loadData() {
                this.loading = true;
                const response = await axios
                    .get(`/admin/menus/show/${this.restoran.id}`)
                    .then(resp => {
                        this.items = resp.data.menu;
                        this.loading = false;
                    });
            },
            sendMessage(message) {
                this.$notify({
                    group: 'message',
                    type: 'success',
                    title: 'Рестораны',
                    text: message
                });
            },
            onSubmit(e) {
                e.preventDefault();

                // this.items.push({
                //     id: null,
                //     name: this.form.name,
                //     img: this.form.img,
                //     view: 0
                // });

                // axios
                //     .post('/admin/restorans/store', {
                //         : this.form.,
                //         : this.form.
                //     }).then((resp) => {
                //     this.items.push(resp.data.restoran)
                //     this.sendMessage(resp.data.message)
                //     this.form. = '';
                //     this.form. = '';
                //     this.loadData()
                // });
            },
            handleFiles() {
                let uploadedFiles = this.$refs.files.files;

                for(var i = 0; i < uploadedFiles.length; i++) {
                    if (/\.(xlsx|xls)$/i.test(uploadedFiles[i].name))
                    {
                        // this.files.push(uploadedFiles[i]);
                        // this.getImagePreviews();
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
                        this.sendMessage('error')
                        // this.error = 'The file has wrong format'
                        // this.dialog = true;
                        break;
                    }

                }

            },
        }
    }
</script>

<style scoped lang="scss">
    .search-wrapper {
        position: relative;
    label {
        position: absolute;
        font-size: 12px;
        color: rgba(0,0,0,.50);
        top: 8px;
        left: 12px;
        z-index: -1;
        transition: .15s all ease-in-out;
    }
    input {
        padding: 4px 12px;
        color: rgba(0,0,0,.70);
        border: 1px solid rgba(0,0,0,.12);
        transition: .15s all ease-in-out;
        background: white;
    &:focus {
         outline: none;
         transform: scale(1.05);
    & + label  {
          font-size: 10px;
          transform: translateY(-24px) translateX(-12px);
      }
    }
    &::-webkit-input-placeholder {
         font-size: 12px;
         color: rgba(0,0,0,.50);
         font-weight: 100;
     }
    }
    }
</style>
