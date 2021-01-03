<template>
    <div>
          <div class="itemCitiesList">
            <a  :href="'/m/restoran/cities/'+item.city" class="city-item-mobile mb-1" v-for="item in cities">
                <h6 class="title">{{item.city}} <span class="badge badge-danger">{{item.count}}</span></h6>
            </a>
        </div>
    </div>
</template>
<script>
    export default {
        props: ["cities"],

    }
</script>
<style lang="scss">
    .itemCitiesList {
       .city-item-mobile {
           width: 100%;
           display: flex;
           justify-content: center;
           align-items: center;
           flex-wrap: wrap;
           /* border: 1px red solid; */
           padding: 15px;
           border-radius: 5px;
           border: 1px #e7e7e7 solid;
           .title {
               width: 100%;
               text-align: center;
           }
       }
    }
</style>
