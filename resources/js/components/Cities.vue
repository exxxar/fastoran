<template>
    <div class="food__category__wrapper mt-5">
        <div class="row d-flex justify-content-center align-items-center">

            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 col-12" v-for="item in cities">
                <div class="food__item foo" style="; visibility: visible;  -webkit-transform: translateY(0) scale(1); opacity: 1;transform: translateY(0) scale(1); opacity: 1;-webkit-transition: -webkit-transform 0.7s cubic-bezier(0.6, 0.2, 0.1, 1) 0s, opacity 0.7s cubic-bezier(0.6, 0.2, 0.1, 1) 0s; transition: transform 0.7s cubic-bezier(0.6, 0.2, 0.1, 1) 0s, opacity 0.7s cubic-bezier(0.6, 0.2, 0.1, 1) 0s; ">
                    <div class="food__thumb">
                        <a :href="'/restoran/cities/'+item.city">
                        <img src="/img/city.png" :alt="item.city">
                        </a>
                    </div>
                    <div class="food__title">
                        <h2><a :href="'/restoran/cities/'+item.city">{{item.city}}</a></h2>
                    </div>
                    <div class="food__label">
                        <p>{{item.count}} заведений</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
    export default {
        data(){
          return {
              cities:[]
          }
        },
        mounted(){
          this.loadCities()

        },
        methods: {
            loadCities(){
                axios
                .get('/api/v1/restoran/cities')
                .then(resp=>{
                    this.cities = resp.data.cities
                })
            }

        }
    }
</script>
<style lang="scss">
 .city-item {
     width:100%;
     height: 100%;
     min-height: 200px;
     max-height: 200px;
     background: white;
     display: flex;
     justify-content: center;
     align-items: center;
     border-radius: 5px;
     box-shadow:2px 2px 2px 2px black;
 }
</style>
