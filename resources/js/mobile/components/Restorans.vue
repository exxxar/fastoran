<template>
    <div>
        <div class="row mb-2">
            <div class="col-12">
                <input type="search" class="form-control" v-model="search" placeholder="Найди нужное">
            </div>
        </div>

        <div class="itemList">
            <a :href="'/m/restoran/'+rest.url" class="item" v-for="rest in tmp_restorans">
                <div class="image">
                    <img :src="rest.logo" alt="image">
                </div>
                <div class="text">
                    <h4 class="title">{{rest.name}}</h4>
                    <div class="text-muted">
                        Заказ от {{rest.min_sum| currency}}
                    </div>

                    <div class="text-muted">
                        Доставка от {{rest.price_delivery| currency}}
                    </div>
                    <div class="text-muted">
                        Время работы {{rest.work_time}} <i class="far fa-clock"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
</template>
<script>
    export default {
        props: ["restorans"],
        data() {
            return {
                search: '',
                tmp_restorans: [],
            }
        },
        watch: {
            search: function (newVal) {
                this.tmp_restorans = this.restorans.filter(item => item.name.toLowerCase().indexOf(this.search.toLowerCase()) !== -1)
            }
        },
        mounted() {
            this.tmp_restorans = this.restorans
        }
    }
</script>
