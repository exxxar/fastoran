<template>

    <div class="sidebarWrapper" v-touch:swipe.left="swipeHandler">
        <div class="overlay toggleSidebar"></div>
        <nav class="sidebar">
            <div class="profilebox">
                <img v-lazy="'https://sun9-55.userapi.com/c638621/v638621489/19a5a/oPJ6fWyDhmk.jpg'" alt="avatar"
                     class="avatar">
                <h2 class="title">Fastoran</h2>
                <h5 class="lead">
                    <i class="icon ion-ios-pin mr-1"></i>
                    Донецк | Макеевка
                </h5>
                <h5 class="lead">
                    <i class="icon ion-ios-call mr-1"></i>
                    <a href="tel:+380715071752">+38 (071) 507-17-52</a>
                </h5>
                <hr>
                <!-- <div class="button">
                 <a href="#">
                     <i class="icon ion-ios-settings"></i>
                 </a>
             </div>-->
            </div>
            <div class="sidebarGroup">
                <ul class="sidebarMenu upperSidebar">
                    <li>
                        <a href="/m/phone-order" title="Заказать по телефону" aria-label="Заказать по телефону">
                            <i class="fas fa-phone-volume mr-1"></i>
                            Заказать по телефону
                        </a>
                    </li>
                    <li>
                        <a href="/m/product-order" title="Продукты из магазина" aria-label="Продукты из магазина">
                            <i class="fab fa-shopify mr-1"></i>
                            Продукты из магазина
                        </a>
                    </li>
                    <li>
                        <a href="/m/flowers-order" title="Цветы и букеты" aria-label="Цветы и букеты">
                            <i class="fas fa-spa mr-1"></i>
                            Цветы и букеты
                        </a>
                    </li>
                    <li>
                        <a href="/m/restorans" title="Рестораны" aria-label="Рестораны">
                            <i class="fas fa-utensils mr-1"></i>
                            Рестораны
                        </a>
                    </li>
                    <li>
                        <a href="/m/tags-cloud"  title="Категории продуктов" aria-label="Категории продуктов">
                            <i class="fas fa-pizza-slice mr-1"></i>
                            Категории
                        </a>
                    </li>
                    <li>
                        <a href="/m/history" title="Статус заказ" aria-label="Статус заказ">
                            <i class="fa fa-history mr-1" aria-hidden="true"></i>
                            История заказов
                        </a>
                    </li>
                    <li>
                        <a href="/m/status" title="Статус заказ" aria-label="Статус заказ">
                            <i class="fas fa-info-circle mr-1"></i>
                            Статус заказ
                        </a>
                    </li>
                </ul>
            </div>
            <div class="sidebarGroup">
                <ul class="sidebarMenu">
                    <li class="title">Собери вкусняшки</li>
                    <li>
                        <a href="/m/calcs/1" title="Пицца \ Блинчики" aria-label="Пицца \ Блинчики">
                            <img v-lazy="'/images/fastoran/chelentano-calc.jpg'" alt="avatar" class="avatar">
                            Пицца \ Блинчики
                        </a>
                    </li>
                    <li>
                        <a href="/m/calcs/3" title="Хот-доги \ Гонконгские вафли" aria-label="Хот-доги \ Гонконгские вафли">
                            <img v-lazy="'/images/fastoran/burger-bar-calc.jpg'" alt="avatar" class="avatar">
                            Хот-доги \ Гонконгские вафли
                        </a>
                    </li>
                </ul>
            </div>

            <div class="sidebarGroup">
                <ul class="sidebarMenu">
                    <li class="title">Мы в соц. сетях</li>
                    <li>
                        <a href="https://vk.com/fastorancom" rel="noreferrer" target="_blank" title="Fastoran в ВК" aria-label="Fastoran в ВК">
                            <i class="icon ion-logo-vk"></i>
                            Мы Вконтакте
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/fastoran_dn/" rel="noreferrer" target="_blank" title="Instagram Fastoran" aria-label="Instagram Fastoran">
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
                        <a href="https://t.me/diner_dn_bot" target="_blank" rel="noreferrer" title="Ресторан 'Diner'" aria-label="Ресторан 'Diner'">
                            <img v-lazy="'/images/fastoran/diner-bot.jpg'" alt="diner_dn_bot" class="avatar">
                            Ресторан "Diner"
                        </a>
                    </li>
                    <li>
                        <a href="https://t.me/isushibot" target="_blank" rel="noreferrer" title="Ресторан 'Isushi'" aria-label="Ресторан 'Isushi'">
                            <img v-lazy="'/images/fastoran/isushi-bot.jpg'" alt="isushibot" class="avatar">
                            Ресторан "Isushi"
                        </a>
                    </li>
                    <li>
                        <a href="https://t.me/svinya_dn_bot" target="_blank" rel="noreferrer" title="Гастропаб 'Свинья'" aria-label="Гастропаб 'Свинья'">
                            <img v-lazy="'/images/fastoran/svinya-bot.jpg'" alt="svinya_dn_bot" class="avatar">
                            Гастропаб "Свинья"
                        </a>
                    </li>
                    <li>
                        <a href="https://t.me/arkadia_donetsk_bot" target="_blank" rel="noreferrer" title="Ресторан 'Аркадия'" aria-label="Ресторан 'Аркадия'">
                            <img v-lazy="'/images/fastoran/arcadia-bot.jpg'" alt="arkadia_donetsk_bot" class="avatar">
                            Ресторан "Аркадия"
                        </a>
                    </li>
                    <li>
                        <a href="https://t.me/pirogi_dn_bot" target="_blank" rel="noreferrer" title="Осетинские пироги" aria-label="Осетинские пироги">
                            <img v-lazy="'/images/fastoran/pirogi-bot.jpg'" alt="pirogi_dn_bot" class="avatar">
                            Осетинские пироги
                        </a>
                    </li>

                    <li>
                        <a href="https://t.me/it_rest_service_bot" target="_blank" rel="noreferrer" title="It Rest Service" aria-label="It Rest Service">
                            <img v-lazy="'/images/fastoran/it-rest-bot.png'" alt="it_rest_service_bot" class="avatar">
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
        data() {
            return {
                test: "test"
            }
        },
        mounted() {
            document.addEventListener('touchstart', (e) => {

            }, {passive: true});
        },
        methods: {
            swipeHandler() {
                document.querySelector(".sidebarActive").classList.remove("sidebarActive")
                document.querySelector(".sidebar").classList.remove("is-active")
                document.querySelector(".sidebarWrapper").style.display = "none";

            }
        }
    }
</script>
