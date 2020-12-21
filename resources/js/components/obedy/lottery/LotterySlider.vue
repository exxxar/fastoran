<template>
    <div class="row mt-2 mb-2 d-flex justify-content-center flex-wrap">
        <div class="col-md-6 col-lg-4 col-sm-6 col-12 " v-for="item in list">
            <div class="lottery-slide mb-3">
                <img v-lazy="item.image" alt="">
                <p class="inf">Мест: <strong>{{ item.place_count - item.free_place_count }} / {{ item.place_count
                    }}</strong></p>


                <b-progress :value="item.place_count - item.free_place_count" :max="item.place_count" variant="success" height="30px" animated>

                </b-progress>

                <button class="btn btn-danger mt-2 w-100" @click="select(item.id)">Участвовать</button>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                list: [
                    {
                        id: 1,
                        image: '/img/go/lottery/lottery_1.png',
                        free_place_count: 10,
                        place_count: 20,
                        title: 'Title',
                        is_active: true,
                        is_complete: false,
                        date_end: '25.12.2020',
                        description: 'Simple description'
                    },

                ]
            }
        },
        mounted() {
            this.loadLotteries();
        },
        methods: {
            select(id) {
                this.$emit("enter", id)

            },
            loadLotteries() {
                axios
                    .get('/api/v2/obedy/lottery/all').then(resp => {
                    console.log(resp)
                    this.list = resp.data
                });
            }
        }
    }
</script>
<style lang="scss">
    .lottery-slide {
        width: 100%;
        padding: 20px;
        border-radius: 5px;
        background-color: red;
        background: url('/img/bg_go.jpg') no-repeat center center;
        background-size: cover;
        box-shadow: 1px 1px 2px 0px #000000;

        img {
            width: 100%;
        }

        p.inf {
            font-family: fantasy;
            color: #c31200;
            text-align: center;
            /* width: 100%; */
            display: block;
        }

        .progress {
            box-shadow: 1px 1px 2px 0px #000000 inset;
        }
    }
</style>
