<template>
    <div class="mobile-tags-cloud">

        <div class="row d-flex flex-wrap">
            <a :href="'/m/category/'+category.id" class="col-6 text-left text-lowercase"
               v-for="category in sortedArray()">
                <strong>{{category.name}}</strong>
            </a>
        </div>
    </div>
</template>
<script>


    export default {
        data() {
            return {
                categories: [],
            }
        },
        mounted() {
            this.loadCategories()
        },
        methods: {
            sortedArray() {
                return this.categories.sort((a, b) => a.sort_index - b.sort_index);
            },
            loadCategories() {
                this.preloader = true;
                axios
                    .get("../api/v1/fastoran/menu_categories")
                    .then(resp => {
                        console.log(this.categories)
                        this.categories = resp.data.menu_categories
                        this.preloader = false;
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
        padding: 5px;
        border: 1px lightgray solid;
        margin: 5px;
    }

</style>
