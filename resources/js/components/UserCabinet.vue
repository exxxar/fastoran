<template>
    <div class="cart-main-area section-padding--lg bg--white">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="table-content table-responsive">
                        <table>
                            <thead>
                            <tr class="title-top">
                                <th class="product-thumbnail">Изображение</th>
                                <th class="product-name">Товар</th>
                                <th class="product-price">Цена</th>
                                <th class="product-quantity">Количество</th>
                                <th class="product-subtotal">Всего</th>
                                <th class="product-remove">Дата заказа</th>
                                <th class="product-remove">Статус</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="item in  history">
                                <td class="product-thumbnail">
                                </td>
                                <td class="product-name">
                                </td>
                                <td class="product-price"></td>
                                <td class="product-quantity">

                                </td>
                                <td class="product-subtotal">
                                </td>
                                <td class="product-remove"></td>
                            </tr>
                            <tr>
                                <td><h4><span>Цена заказа</span></h4></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props:["history"]
    }
</script>
<style lang="scss" scoped>

</style>
