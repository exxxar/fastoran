<template>
    <div class="item">
        <div class="image">
            <img :src="product.food_img" :alt="product.food_name">
        </div>
        <div class="text">
            <h4 class="title">{{product.food_name}}</h4>
            <div class="text-muted">Цена {{product.food_price}} руб.</div>
            <div class="controls">
                <mobile-product-controls :product="product"></mobile-product-controls>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["product"]
    }
</script>
<style lang="scss" scoped>


</style>
