<template>
    <div class="itemList">
        <a :href="'/m/restoran/'+rest.url" class="item" v-for="rest in restorans">
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
</template>
<script>
    export default {
       props:["restorans"]
    }
</script>
