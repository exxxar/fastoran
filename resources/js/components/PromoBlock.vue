<template>
    <div>
        <form v-on:submit.prevent="onSubmit">
            <div class="row">
                <div class="col-12">
                    <input type="text" v-model="code" placeholder="Введите промо-код">
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                code:null
            }
        },
        methods:{
            onSubmit(){

            }
        }
    }
</script>
<style lang="scss">

</style>
