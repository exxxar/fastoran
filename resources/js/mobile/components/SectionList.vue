<template>
    <div class="section-list">
        <div class="section-preloader" v-if="preloader">
            <img src="/img/ajax-loader.gif" alt="">
            <h6>Загружаем-с доступные секции</h6>
        </div>

        <div class="container mb-5">
            <div class="row">
                <div class="col-6 section-wrapper" v-for="section in sections">
                    <a class="section-item" :href="'https://fastoran.com/m/sections/'+section.id">
                        <img v-lazy="section.img" :alt="section.name" class="img-fluid image lazyload">
                        <h6>{{section.name}}</h6>
                    </a>

                </div>

            </div>
        </div>

    </div>
</template>
<script>
    export default {
        data() {
            return {
                sections: [],
                preloader: false
            }
        },
        mounted() {
            this.loadSections()

        },
        methods: {
            loadSections() {
                this.preloader = true;
                axios
                    .post("/api/v1/fastoran/sections/")
                    .then(resp => {
                        this.sections = resp.data
                        this.preloader = false;

                    })
            },

        }
    }
</script>
<style lang="scss" scoped>
    .section-list {
        position: relative;

        .container {
            padding-right: 5px;
            padding-left: 5px;
        }

        .section-wrapper {
            padding: 5px;

            .section-item {
                padding: 5px;
                background: white;
                border: 1px #e7e7e7 solid;
                border-radius: 5px;
                display: block;
                h6 {
                    text-align: center;
                    line-height: 200%;
                    text-transform: uppercase;
                    font-size: 14px;
                    padding: 10px 5px 0px 5px;
                    margin: 0;
                }
            }
        }

        .food-categories {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            box-sizing: border-box;
            padding: 0px;

            li {
                list-style: none;
                padding: 0px;

                a {
                    display: block;
                    height: 100%;
                    width: 100%;
                    color:black;
                    padding:2px;
                    text-transform: lowercase;

                    &:hover {
                        background: none;
                        border-bottom: 2px #c31013 solid;
                    }
                }
            }
        }
    }

    .section-preloader {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        z-index: 10;
        background: rgba(255, 255, 255, 0.8);

        img {
            margin-top: 50px;
            width: 75px;
            height: 75px;
        }

    }


</style>
