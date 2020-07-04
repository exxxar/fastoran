<template>
    <div class="mobile-tags-cloud">
        <div class="row mb-2">
            <div class="col-12">
                <input type="search" class="form-control" v-model="search" placeholder="Найди нужное">
            </div>
        </div>
        <div class="row d-flex flex-wrap">
            <a :href="'/m/category/'+category.id" class="col-6 text-left text-lowercase tag-item"
               v-for="category in tmp_categories">
                <strong>{{category.name}}</strong>
            </a>
        </div>
    </div>
</template>
<script>


    export default {
        data() {
            return {
                search:'',
                categories: [],
                tmp_categories:[],
            }
        },
        mounted() {
            this.loadCategories()
        },
        watch:{
          search:function (newVal) {
              this.tmp_categories = this.categories.filter(item=>item.name.indexOf(this.search)!==-1)
          }
        },
        methods: {
            loadCategories() {
                axios
                    .get("/api/v1/fastoran/menu_categories")
                    .then(resp => {
                        this.categories = resp.data.menu_categories.sort((a, b) => a.sort_index - b.sort_index);
                        this.tmp_categories = this.categories
                    })
            },


        }

    }
</script>
<style lang="scss">
    .mobile-tags-cloud {
        position: relative;
    }


    .tag-item {


        strong {
            font-weight: bolder;
            padding: 6px 10px;
            box-sizing: border-box;
            border: 1px #ececec solid;
            display: block;
            margin: 2px 0px;
            overflow: hidden;
            text-overflow: ellipsis;
            color: #3d3d3d;
        }

    }

</style>
