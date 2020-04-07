<template>
    <div>
        {{cartProducts.length}}
    </div>
</template>
<script>
    export default {
        mounted() {

            let callback = (val, oldVal, uri) => {
                this.$store.dispatch("getProductList")
            }

            Vue.ls.on('store', callback) //watch change foo key and triggered callbac

            this.$store.dispatch("getProductList")
        },
        activated() {
            this.$store.dispatch("getProductList")
        },
        computed: {
            cartProducts: function () {
                return this.$store.getters.cartProducts;
            }
        },
    }
</script>
<style lang="scss">
</style>
