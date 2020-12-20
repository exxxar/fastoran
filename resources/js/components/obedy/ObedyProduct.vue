<template>
    <div class="day-item">

        <h3>{{product.title}}</h3>
        <img v-lazy="product.image" :alt="product.title" class="w-100" @click="openModal()">



        <obedy-controls :product="product" />

        <b-modal :id="'modal-'+uuid" size="lg" hide-footer>
            <template #modal-title>
                <h3><span class="badge badge-danger">"{{product.title}}"</span></h3>
            </template>

            <div class="row" v-if="!product.is_week">
                <div class="col-md-7 col-sm-6">
                    <img :src="product.image" class="img-fluid" alt="">
                </div>
                <div class="col-md-5 col-sm-6 ">
                    <p v-if="product.description">{{product.description}}</p>
                    <ul v-if="product.positions">
                        <li v-for="pos in product.positions" class="d-flex mb-2 flex-wrap text-dark">

                            <p><span class="badge badge-danger mr-1">{{pos.weight}} гр.</span>{{pos.title}}
                            </p>

                        </li>
                    </ul>

                    <p v-if="product.price" class="text-dark">Цена: <strong>{{product.price}} руб.</strong></p>
                    <p v-if="product.weight" class="text-dark">Масса: <strong>{{product.weight}} гр.</strong></p>

                    <obedy-controls :product="product"/>


                </div>
            </div>

            <div class="row" v-if="product.is_week">


                <ul v-if="product.positions" class="row p-2">
                    <li v-for="pos in product.positions" class="col-md-6 mt-2">
                        <div class="row">
                            <div class="col-md-6">
                                <img :src="pos.image" class="img-fluid" alt="">
                            </div>
                            <div class="col-md-6">
                                <p><span class="badge badge-danger mr-1">{{pos.weight}} гр.</span>{{pos.title}}
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>

                <div class="row w-100">
                    <div class="col-md-4 d-flex justify-content-center align-items-center">
                        <p v-if="product.price" class="text-dark">Полная цена: <strong>{{product.price}} руб.</strong></p>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center align-items-center">
                        <p v-if="product.weight" class="text-dark">Общая масса: <strong>{{product.weight}} гр.</strong></p>
                    </div>
                    <div class="col-md-4">
                        <obedy-controls :product="product"/>
                    </div>
                </div>


            </div>
        </b-modal>
    </div>
</template>
<script>
    import {v4 as uuidv4} from 'uuid';
    import ObedyControls from '../obedy/ObedyControls'

    export default {
        props: ["product"],
        components: {
            ObedyControls
        },
        data() {
            return {
                uuid: null,
                is_product_open: false,

                settings: {
                    suppressScrollX: true,
                    suppressScrollY: false,
                },

            }
        },
        watch: {
            cart: function (newVal, oldVal) {
                return newVal
            }
        },
        computed: {
            cart() {
                return this.$store.getters.goCartProducts;
            }
        },
        mounted() {
            this.uuid = uuidv4();


            let callback = (val, oldVal, uri) => {
                this.$store.dispatch("goCartProducts")
            }

            Vue.ls.on('store_go', callback) //watch change foo key and triggered callbac
        },
        methods: {


            openModal() {
                this.$bvModal.show('modal-' + this.uuid)
            },


            sendMessage(message, type = 'success') {
                this.$notify({
                    group: 'info',
                    type: type,
                    title: 'Оповещение ОбедыGO',
                    text: message
                });
            },
        }
    }
</script>
<style lang="scss">

    .day-item {
        box-sizing: border-box;
        border-radius: 5px;
        position: relative;
        padding: 5px;


        img {
            border-radius: 5px;
            box-shadow: 1px 1px 2px 0px #000000;
        }

        h3 {
            color: black;
            font-size: 24px;
            /* background: #c31200; */
            /* color: white; */
            padding: 10px;
            /* width: 100%; */
            text-transform: uppercase;
            border-radius: 5px 5px 0px 0px;
            font-family: fantasy;
            text-align: center;

            &:first-letter {
                color: #c31200;
            }
        }

        button {
            box-shadow: 1px 1px 2px 0px #000000;

            span {
                font-weight: 800;
            }
        }

        .btn-coutner {
            padding: 27px;
        }

        .cnt-container p {
            padding-top: 14px;
        }

        .shadow {
            position: absolute;
            width: 100%;
            z-index: 10;
            background: rgba(0, 0, 0, 0.5) url('/img/logo_obed_go.jpg') center center no-repeat;
            background-size: cover;
            height: 100%;
            top: 0;
            left: 0;
            border-radius: inherit;

            display: flex;
            justify-content: center;
            align-items: flex-end;

            p {
                font-size: 24px;
                background: #c31200;
                color: white;
                padding: 10px;
                /* width: 100%; */
                text-transform: uppercase;
                border-radius: 5px 5px 0px 0px;
                font-family: fantasy;
            }
        }

    }

    .product-modal {
        position: fixed;
        z-index: 100;
        right: 0;
        top: 0;
        height: 100vh;
        width: 100%;
        box-sizing: border-box;
        /* border-left: 5px #c31200 solid; */
        display: flex;
        justify-content: center;
        align-items: center;

        .product-modal-inner {
            max-width: 1000px;
            width: 100%;
            height: 100%;
            max-height: 700px;
            position: relative;
            background: white;
            transition: 0.3s;
            box-sizing: border-box;
            /* border-left: 5px #c31200 solid; */
            z-index: 10002;
            /* box-shadow: 0px 0px 3px 1px #3c3c3c; */
            border: 1px #e9e9e9 solid;
        }

        .product-shadow {
            position: absolute;
            z-index: 1001;
            top: inherit;
            left: inherit;
            width: inherit;
            height: inherit;
            background: rgba(0, 0, 0, 0.5);
        }

        .custom-modal-header {
            width: 100%;
            height: 30px;
            display: flex;
            justify-content: flex-end;
            align-items: center;


            a,
            button {
                text-transform: uppercase;
                color: #af2112;
                font-weight: 800;
                font-size: 12px;
                cursor: pointer;
                padding: 10px;

                &:focus {
                    outline: none;
                }

            }
        }

        .custom-modal-footer {
            width: inherit;
            height: auto;
            /* background: red; */
            position: absolute;
            bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            background: white;
            /* border-top: 5px #c31200 solid; */
            padding: 10px;
            box-sizing: border-box;
            /* box-shadow: 0px 0px 3px 1px #8b8b8b; */
            border: 1px #e9e9e9 solid;

            form.order-form {
                padding: 10px 0px;
                box-sizing: border-box;
                width: 100%;
                transition: 0.3s;
                /* border-top: 2px red solid; */
                position: relative;
                display: flex;
                justify-content: center;
                align-items: center;
                flex-wrap: wrap;

                .hider {
                    position: absolute;
                    top: -25px;
                    width: 100px;
                    height: 30px;
                    /* right: 0; */
                    background: #c31200;
                    color: white;
                    font-weight: 800;
                    text-transform: uppercase;
                    font-size: 10px;
                    border-radius: 5px;
                    border: 1px #c31200 solid;
                    box-shadow: 0px 0px 3px 0px #464646;

                    &:hover {
                        background-color: #ad1200;
                        transition: .3s;
                    }

                    &:focus {
                        outline: none;
                    }
                }

                textarea,
                input {
                    width: 100%;
                    padding: 15px;
                    border: 1px #d50c0d solid;
                    margin-bottom: 5px;
                    border-radius: 5px;
                }
            }
        }

        .day-item-wrapper {
            padding: 10px;

            .day-item {

                box-sizing: border-box;
                border-radius: 5px;
                position: relative;


                img {
                    border-radius: 5px;
                }

                h3 {
                    color: black;
                    font-size: 24px;
                    /* background: #c31200; */
                    /* color: white; */
                    padding: 10px;
                    /* width: 100%; */
                    text-transform: uppercase;
                    border-radius: 5px 5px 0px 0px;
                    font-family: 'Roboto', sans-serif;
                    text-align: center;

                    &:first-letter {
                        color: #c31200;
                    }
                }

                .shadow {
                    position: absolute;
                    width: 100%;
                    z-index: 10;
                    background: rgba(0, 0, 0, 0.5) url('/img/logo_obed_go.jpg') center center no-repeat;
                    background-size: cover;
                    height: 100%;
                    top: 0;
                    left: 0;
                    border-radius: inherit;

                    display: flex;
                    justify-content: center;
                    align-items: flex-end;

                    p {
                        font-size: 24px;
                        background: #c31200;
                        color: white;
                        padding: 10px;
                        /* width: 100%; */
                        text-transform: uppercase;
                        border-radius: 5px 5px 0px 0px;
                        font-family: fantasy;
                    }
                }

            }

            .addition-item {

                padding: 5px 10px 10px 10px;
                box-sizing: border-box;
                border-radius: 5px;
                position: relative;

                h4 {
                    font-size: 12px;
                    color: #c31200;
                    text-transform: uppercase;
                    font-family: monospace;
                    border-bottom: 1px black dashed;
                    display: inline-block;
                    padding: 0px 5px;
                }

                h3 {
                    border-bottom: 2px transparent solid;
                    padding: 10px;
                    text-transform: uppercase;
                    text-align: center;
                    font-weight: 800;
                    color: #0f0f0f;

                    &:first-letter {
                        color: #c31200;
                    }
                }
            }
        }
    }

    .group-btn-counter {
        display: flex;
        min-width: 90px;
        justify-content: space-around;
    }



</style>
