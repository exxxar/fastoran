const state = {
    go_products: null,
    go_categories: null,
}

// getters
const getters = {
    getGoProducts: (state, getters, rootState) => {
        return state.go_products;
    },
    getGoCategories: (state, getters, rootState) => {
        return state.go_categories;
    },

}

// actions
const actions = {

    loadProducts({state, commit}) {
        commit('loadProducts');
    },
    loadCategories({state, commit}) {
        commit('loadCategories');
    }
}

// mutations
const mutations = {
    loadProducts(state) {
       axios
           .get('/api/v2/obedy/products')
           .then(resp=>{
               state.go_products = resp.data
           })
    },
    loadCategories(state) {
        axios
            .get('/api/v2/obedy/categories')
            .then(resp=>{
                state.go_categories = resp.data
            })
    },


}

export default {
    state,
    getters,
    actions,
    mutations
}
