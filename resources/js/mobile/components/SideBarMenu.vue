<template>

        <div class="sidebarWrapper" v-touch:swipe.left="swipeHandler">
            <div class="overlay toggleSidebar"></div>
            <nav class="sidebar">
                <div class="profilebox">
                    <img src="https://sun9-55.userapi.com/c638621/v638621489/19a5a/oPJ6fWyDhmk.jpg" alt="avatar" class="avatar">
                    <h2 class="title">Fastoran</h2>
                    <h5 class="lead">
                        <i class="icon ion-ios-pin mr-1"></i>
                        Донецк
                    </h5>
                    <!-- <div class="button">
                     <a href="#">
                         <i class="icon ion-ios-settings"></i>
                     </a>
                 </div>-->
                </div>
                <div class="sidebarGroup ">
                    <ul class="sidebarMenu upperSidebar">
                        <li>
                            <a href="">
                                <i class="fas fa-phone-volume"></i>
                                Заказать по телефону
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="fab fa-shopify"></i>
                                Продукты из магазина
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="fas fa-spa"></i>
                                Цветы и букеты
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="fas fa-utensils"></i>
                                Рестораны
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <i class="fas fa-pizza-slice"></i>
                                Категории продуктов
                            </a>
                        </li>
                        <li>
                            <a href="{{route('mobile.status">
                                <i class="fas fa-info-circle"></i>
                                Статус заказ
                            </a>
                        </li>
                        <li>
                            <a href="blog-home.html">
                                <i class="far fa-question-circle"></i>
                                Обратная связь
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="sidebarGroup">
                    <ul class="sidebarMenu">
                        <li class="title">Собери вкусняшки</li>
                        <li>
                            <a href="">
                                <img src="images/fastoran/chelentano-calc.jpg" alt="avatar" class="avatar">
                                Пицца \ Блинчики
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="images/fastoran/isushi-calc.jpg" alt="avatar" class="avatar">
                                Роллы
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <img src="images/fastoran/burger-bar-calc.jpg" alt="avatar" class="avatar">
                                Хот-доги \ Гонконгские вафли
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="sidebarGroup">
                    <ul class="sidebarMenu">
                        <li class="title">Мы в соц. сетях</li>
                        <li>
                            <a href="https://vk.com/fastorancom">
                                <i class="icon ion-logo-vk"></i>
                                Мы Вконтакте
                            </a>
                        </li>
                        <li>
                            <a href="https://www.instagram.com/fastoran_dn/">
                                <i class="icon ion-logo-instagram"></i>
                                Instagram
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="sidebarGroup">
                    <ul class="sidebarMenu">
                        <li class="title">Telegram боты партнеров</li>
                        <li>
                            <a href="https://t.me/diner_dn_bot" target="_blank">
                                <img src="images/fastoran/diner-bot.jpg" alt="diner_dn_bot" class="avatar">
                                Ресторан "Diner"
                            </a>
                        </li>
                        <li>
                            <a href="https://t.me/isushibot" target="_blank">
                                <img src="images/fastoran/isushi-bot.jpg" alt="isushibot" class="avatar">
                                Ресторан "Isushi"
                            </a>
                        </li>
                        <li>
                            <a href="https://t.me/svinya_dn_bot" target="_blank">
                                <img src="images/fastoran/svinya-bot.jpg" alt="svinya_dn_bot" class="avatar">
                                Гастропаб "Свинья"
                            </a>
                        </li>
                        <li>
                            <a href="https://t.me/arkadia_donetsk_bot" target="_blank">
                                <img src="images/fastoran/arcadia-bot.jpg" alt="arkadia_donetsk_bot" class="avatar">
                                Ресторан "Аркадия"
                            </a>
                        </li>
                        <li>
                            <a href="https://t.me/pirogi_dn_bot" target="_blank">
                                <img src="images/fastoran/pirogi-bot.jpg" alt="pirogi_dn_bot" class="avatar">
                                Осетинские пироги
                            </a>
                        </li>

                        <li>
                            <a href="https://t.me/it_rest_service_bot" target="_blank">
                                <img src="images/fastoran/it-rest-bot.png" alt="it_rest_service_bot" class="avatar">
                                It Rest Service
                            </a>
                        </li>

                    </ul>
                </div>
            </nav>
        </div>


</template>
<script>
    export default {
        data(){
          return {
              test:"test"
          }
        },
        methods:{
            swipeHandler(){
               document.querySelector(".sidebarActive").classList.remove("sidebarActive")
                document.querySelector(".sidebar").classList.remove("is-active")
                document.querySelector(".sidebarWrapper").style.display = "none";

            }
        }
    }
</script>
