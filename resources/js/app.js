/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);



Vue.component('rest-menu', require('./components/RestMenu.vue').default);
Vue.component('rest-filter', require('./components/RestFilter.vue').default);
Vue.component('tags-cloud-list', require('./components/TagsCloud.vue').default);

Vue.component('custom-order', require('./components/CustomOrder.vue').default);
Vue.component('rest-info', require('./components/RestInfo.vue').default);
Vue.component('cart', require('./components/Cart.vue').default);
Vue.component('table-cart', require('./components/TableCart.vue').default);
Vue.component('header-fastoran', require('./components/Header.vue').default);
Vue.component('add-cart-btn', require('./components/AddCartBtn.vue').default);
Vue.component('cart-count-index', require('./components/CartCountIndex.vue').default);
Vue.component('contact-form', require('./components/CallbackForm.vue').default);

//Admin
Vue.component('kitchens', require('./components/admin/Kitchens.vue').default);
Vue.component('orders', require('./components/admin/Orders.vue').default);
Vue.component('new-order', require('./components/admin/NewOrder.vue').default);
Vue.component('order_details', require('./components/admin/OrderDetails.vue').default);
Vue.component('menus', require('./components/admin/Menus.vue').default);
Vue.component('menu-categories-list', require('./components/admin/MenuCategories.vue').default);
Vue.component('restorans-list', require('./components/admin/Restorans.vue').default);
Vue.component('stop-list', require('./components/admin/StopList.vue').default);
Vue.component('users', require('./components/admin/Users.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import {BootstrapVue, IconsPlugin} from 'bootstrap-vue'
import Notifications from 'vue-notification'
import VueCurrencyFilter from 'vue-currency-filter'
import 'lazysizes';
// import a plugin
import 'lazysizes/plugins/parent-fit/ls.parent-fit';

// Install BootstrapVue
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)
Vue.use(Notifications)

import Storage from 'vue-ls';

let options = {
    namespace: 'vuejs__', // key prefix
    name: 'ls', // name variable Vue.[ls] or this.[$ls],
    storage: 'local', // storage name session, local, memory
};

Vue.use(Storage, options);


Vue.use(VueCurrencyFilter,
    {
        symbol : '₽',
        thousandsSeparator: '.',
        fractionCount: 2,
        fractionSeparator: ',',
        symbolPosition: 'back',
        symbolSpacing: true
    })
import store from '../js/store'

const app = new Vue({
    store,
    el: '#wrapper',
});
