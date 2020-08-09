<template>
    <span class="badge badge-danger">
        {{likesProducts.length}}
    </span>
</template>
<script>
    export default {
        mounted() {
            let callback = (val, oldVal, uri) => {
                this.$store.dispatch("getLikesProductList")
            }

            Vue.ls.on('store_likes', callback)
            this.$store.dispatch("getLikesProductList")
        },
        activated() {
            this.$store.dispatch("getLikesProductList")
        },
        computed: {
            likesProducts: function () {
                return this.$store.getters.likesProducts;
            }
        },
    }
</script>
<style lang="scss">
</style>
