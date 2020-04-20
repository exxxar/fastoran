<template>
    <div class="login-form">
        <p v-if="message!=null" v-html="message"></p>
        <form v-on:submit.prevent="login">
            <div class="row">
                <div class="col-12 mt-2">
                    <input type="text" class="form-control"  v-model="phone"
                           placeholder="Ваш номер телефона"
                           name="phone"
                           pattern="[\+]\d{2} [\(]\d{3}[\)] \d{3}[\-]\d{2}[\-]\d{2}"
                           maxlength="19"
                           v-mask="['+38 (###) ###-##-##']"

                           required>
                </div>
                <div class="col-12 mt-2">
                    <input type="text" class="form-control"
                           pattern="\d{6}"
                           v-mask="['######']"
                           placeholder="Код из СМС" v-model="auth_code" required>
                </div>
                <div class="col-12 mt-2" v-if="need_new_code">
                    <button @click="resendSMSCode" class="btn btn-food btn-info">Выслать новый код</button>
                </div>
                <div class="col-12 mt-2">
                    <button type="submit" class="btn btn-food">Войти</button>
                </div>
            </div>


        </form>
    </div>
</template>
<script>
    import {mask} from 'vue-the-mask'

    export default {
        data() {
            return {
                phone: localStorage.getItem("phone",""),
                auth_code: localStorage.getItem("auth_code",""),
                message: null,
                need_new_code: false

            }
        },
        mounted() {
            if (this.phone&&this.auth_code)
                this.login();
        },
        methods: {
            resendSMSCode() {
                this.need_new_code = false
                this.message = "На ваш номер отправлен СМС с кодом! СМС придет в течении 2х минут."
                console.log("RESEND CODE")

                setTimeout(()=>this.need_new_code=true,120000)
            },
            login(e) {

                localStorage.setItem("phone",this.phone)
                localStorage.setItem("auth_code",this.auth_code)

                axios
                    .post('../api/v1/auth/login', {
                        phone: this.phone,
                        password: this.auth_code,
                        remember_me: false,
                    }).then(resp => {
                    console.log(resp)
                    if (resp.data.access_token != null)
                        this.$emit("access_token", resp.data.access_token)
                    else
                        this.$emit("access_token", null)

                    if (resp.data.message != null) {
                        this.message = resp.data.message
                        this.need_new_code = true
                    }

                })
            },

        },
        directives: {mask}

    }
</script>

<style lang="scss" scoped>
    .login-form {
        width: 400px;
        padding: 20px;
        box-sizing: border-box;

        input,
        button {
            padding: 10px;
            border-radius: 0px;
        }

        button {
            width: 100%;
            text-transform: uppercase;
            font-weight: 800;
            color: white;

            &.btn-info {
                background: #00a650;
            }
        }
    }
</style>
