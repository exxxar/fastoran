<template>
    <div>
        <b-collapse id="collapse-a" class="register w-100">

            <div class="container">

                <b-row>
                    <b-col col lg="6">


                    </b-col>
                    <b-col col lg="6" sm="12" xs="12">
                        <b-form>
                            <b-form-group
                                id="input-group-1"
                                label="Email address:"
                                label-for="input-1"
                                description="We'll never share your email with anyone else."
                            >
                                <b-form-input
                                    id="input-1"
                                    type="email"
                                    required
                                    placeholder="Enter email"
                                ></b-form-input>
                            </b-form-group>

                            <b-form-group id="input-group-2" label="Your Name:" label-for="input-2">
                                <b-form-input
                                    id="input-2"
                                    required
                                    placeholder="Enter name"
                                ></b-form-input>
                            </b-form-group>

                            <b-form-group id="input-group-3" label="Food:" label-for="input-3">
                                <b-form-select
                                    id="input-3"
                                    required
                                ></b-form-select>
                            </b-form-group>

                            <b-form-group id="input-group-4">
                                <b-form-checkbox-group id="checkboxes-4">
                                    <b-form-checkbox value="me">Check me out</b-form-checkbox>
                                    <b-form-checkbox value="that">Check that out</b-form-checkbox>
                                </b-form-checkbox-group>
                            </b-form-group>

                            <b-button type="submit" variant="primary">Submit</b-button>
                            <b-button type="reset" variant="danger">Reset</b-button>
                        </b-form>
                    </b-col>
                </b-row>

            </div>

        </b-collapse>
        <section class="header">


            <div class="container">
                <div class="row flex-row justify-content-around align-items-center">


                    <div v-b-toggle.collapse-a.collapse-b class="col-md-3 col-sm-3 col-xs-12 hidden-xs">
                        <a href="#"><img src="/img/header-logo.png" alt="" class="logo"></a>
                    </div>
                    <!--      <div class="col-md-2 col-md-offset-5 col-sm-3 col-sm-offset-3 col-xs-3 hidden-xs">
                              <a href="#" class="basket" data-toggle="modal" data-target="#basket">
                                  <div class="hidden-xs"><img src="/img/svg/basket.svg" alt=""></div>
                                  <div class="hidden-xs">
                                      <p class="clean">Корзина</p>
                                      <p class="clean">пуста</p>
                                      <div class="cnt full hidden"><p>99</p></div>
                                      <p class="summ full hidden">91220 руб</p>
                                  </div>
                              </a>
                          </div>-->
                    <!--      <div class="col-md-2 col-sm-3 col-xs-12 hidden-xs">
                              <div class="reg">
                                  <div><img src="/img/svg/user.svg" alt=""></div>
                                  <div>
                                      <p>Личный кабинет</p>
                                      &lt;!&ndash; <p >Регистрация</p> &ndash;&gt;
                                  </div>
                                  <div class="log-out-wrap hidden hidden-xs">
                                      <a href="/profile" class="profile">Профайл</a>
                                      <a href="#" class="log-out">Выход</a>
                                  </div>
                                  &lt;!&ndash; <ul class="drop-list">
                                      <li><a href="#">Профайл</a></li>
                                      <li><a href="#">Мои заказы</a></li>
                                      <li><a href="#">Выход</a></li>
                                  </ul> &ndash;&gt;
                              </div>
                          </div>
                          <div class="col-xs-3 hidden-sm hidden-md hidden-lg">
                              <div class="reg">
                                  <img src="/img/burger-menu.png" alt="">
                              </div>
                          </div>
                          <div class="col-xs-6 hidden-sm hidden-md hidden-lg text-center">
                              <a href="/"><img src="/img/header-logo.png" alt="" class="logo"></a>
                          </div>-->
                    <div class="col-xs-3 text-right hidden-sm hidden-md hidden-lg">
                        <a href="#" class="basket" data-toggle="modal" data-target="#basket">
                            <div class="">
                                <!-- <p class="clean">Корзина</p>
                                <p class="clean">пуста</p> -->
                                <div class="cnt full hidden"><p>99</p></div>
                                <!-- <p class="summ full hidden">91220 руб</p> -->
                            </div>
                            <img class="basket-xs" src="/img/svg/basket.svg" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </div>
</template>

<script>
    export default {}
</script>
