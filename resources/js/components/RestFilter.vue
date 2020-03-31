<template>
    <div>
        <b-form @submit="onSubmit" @reset="onReset" v-if="show">

            <b-row>
                <b-col col lg="4" md="6" sm="12">
                    <b-form-group>
                        <b-form-select
                            id="input-3"
                            v-model="form.city"
                            :options="getCities()"
                            required
                        ></b-form-select>
                    </b-form-group>

                </b-col>
                <b-col col lg="4" md="6" sm="12">
                    <b-form-group>
                        <b-form-select
                            id="input-3"
                            v-model="form.region"
                            :options="getRegions()"
                            required
                        ></b-form-select>
                    </b-form-group>
                </b-col>
                <b-col col lg="4" md="12" sm="12" >
                    <b-form-group>
                        <b-button variant="warning" class="w-100">Найти ближайшие рестораны</b-button>
                    </b-form-group>
                </b-col>
            </b-row>


        </b-form>
    </div>
</template>

<script>
    export default {
        name: "RestFilter",
        data() {
            return {
                cities: [
                    {
                        value: 1,
                        text: "Донецк"
                    },
                    {
                        value: 2,
                        text: "Макеевка"
                    }
                ],
                regions: [
                    {value: 1, city: 1, text: "Ворошиловский район"},
                    {value: 2, city: 1, text: "Буденовский район"},
                    {value: 3, city: 1, text: "Калининский район"},
                    {value: 4, city: 1, text: "Кировский район"},
                    {value: 5, city: 1, text: "Куйбышевский район"},
                    {value: 6, city: 1, text: "Ленинский район"},
                    {value: 7, city: 1, text: "Петровский район"},
                    {value: 8, city: 1, text: "Пролетарский район"},
                    {value: 9, city: 2, text: "Горняцкий район"},
                    {value: 10, city: 2, text: "Кировский район"},
                    {value: 11, city: 2, text: "Советский район"},
                    {value: 11, city: 2, text: "Центрально-Городской район"},
                    {value: 11, city: 2, text: "Красногвардейский район"},
                ],
                form: {
                    email: '',
                    name: '',
                    city: 1,
                    region: 1,
                    checked: []
                },
                foods: [{text: 'Select One', value: null}, 'Carrots', 'Beans', 'Tomatoes', 'Corn'],
                show: true
            }
        },

        watch:{
            'form.city':function (newVal,oldVal) {
                this.form.region = this.regions.filter(item=>item.city===this.form.city)[0].value
            }
        },

        methods: {
            getCities: function () {
                return this.cities;
            },
            getRegions: function () {
                return this.form.city != null ? this.regions.filter(item => item.city === this.form.city) : this.regions;
            },
            onSubmit(evt) {
                evt.preventDefault()
                alert(JSON.stringify(this.form))
            },
            onReset(evt) {
                evt.preventDefault()
                // Reset our form values
                this.form.email = ''
                this.form.name = ''
                this.form.food = null
                this.form.checked = []
                // Trick to reset/clear native browser form validation state
                this.show = false
                this.$nextTick(() => {
                    this.show = true
                })
            }
        }
    }
</script>
