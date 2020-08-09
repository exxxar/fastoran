import Vue from 'vue';
import Vuex from 'vuex';
import cart from './modules/cart';
import ingredients from './modules/ingredients';
import likes from './modules/likes';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {},
    getters: {},
    mutations: {},
    actions: {},
    modules: {
        cart, ingredients, likes
    },
});
