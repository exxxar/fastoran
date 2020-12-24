const state = {
    go_items: localStorage.getItem('vuejs__store_go') == null ? [] : JSON.parse(localStorage.getItem('vuejs__store_go')),
}

// getters
const getters = {
    goCartProducts: (state, getters, rootState) => {

        return state.go_items;
    },
    getGoProductById: (state) => (id) => {
        let tmp = state.go_items.find(item => item.product.id === id)
        return tmp
    },
    goCartTotalCount: (state, getters) => {

        if (state.go_items == null)
            return 0;

        if (state.go_items.length === 0)
            return 0;

        let summ = 0;
        state.go_items.forEach((item) => {
            summ += item.quantity
        });
        return summ
    },
    goCartTotalPrice: (state, getters) => {
        if (state.go_items == null)
            return 0;

        if (state.go_items.length === 0)
            return 0;

        let summ = 0;
        state.go_items.forEach((item) => {
            summ += item.product.price * item.quantity * (item.days.length > 0 ? item.days.length : 1)


        });
        return summ
    },
    goCartTotalWeight: (state, getters) => {
        if (state.go_items == null)
            return 0;

        if (state.go_items.length === 0)
            return 0;

        let summ = 0;
        state.go_items.forEach((item) => {

                if (item.product.weight > 0)
                    summ += item.product.weight * item.quantity * (item.days.length > 0 ? item.days.length : 1)

                if (item.product.weight === 0) {
                    if (item.product.positions.length > 0)
                        item.product.positions.forEach((j_item) => {
                            summ += j_item.weight
                        })
                }


            }
        )
        ;
        return summ
    }
}

// actions
const actions = {
    sendGoOrder({state, commit}, form) {
        commit('sendGoOrder', form);
    },
    getGoProductList({state, commit}) {
        state.go_items = localStorage.getItem('vuejs__store_go') == null ? [] : JSON.parse(localStorage.getItem('vuejs__store_go'))
        return state.go_items
    },
    inGoCart({state, commit}, id) {
        return (state.go_items.filter(item => item.product.id === id)).length
    },
    addGoProductToCart({state, commit}, product) {
        commit('pushGoProductToCart', product);
        localStorage.setItem('vuejs__store_go', JSON.stringify(state.go_items));
    },
    setGoDaysForItem({state, commit}, data) {
        commit('setGoDaysForItem', data);
        localStorage.setItem('vuejs__store_go', JSON.stringify(state.go_items));
    },
    setGoQuantity({state, commit}, prod) {
        commit('setItemGoQuantity', prod);
        localStorage.setItem('vuejs__store_go', JSON.stringify(state.go_items));
    },
    incGoQuantity({state, commit}, id) {
        commit('incrementGoItemQuantity', id);
        localStorage.setItem('vuejs__store_go', JSON.stringify(state.go_items));
    },
    decGoQuantity({state, commit}, id) {
        commit('decrementGoItemQuantity', id);
        console.log("dec " + id)
        localStorage.setItem('vuejs__store_go', JSON.stringify(state.go_items));
    },
    removeGoProduct({state, commit}, id) {
        commit('removeGoItem', id);
        localStorage.setItem('vuejs__store_go', JSON.stringify(state.go_items));
    },
    clearGoCart({state, commit}) {
        commit('clearGoAllItems');
        localStorage.setItem('vuejs__store_go', JSON.stringify(state.go_items));
    }
}

// mutations
const mutations = {
    sendGoOrder(state, form) {


        axios
            .post('/api/v2/obedy/order', {
                name: form.name,
                address: form.address,
                message: form.message,
                phone: form.phone,
                products: state.go_items,
                total_weight:form.total_weight,
                total_price:form.total_price,
                total_count:form.total_count
            }, {responseType: 'blob'}).then(resp => {
            const FileDownload = require('js-file-download');

            FileDownload(resp.data, 'report.pdf');

            state.go_items = [];
            localStorage.setItem('vuejs__store_go', JSON.stringify(state.go_items));
        })
    },
    pushGoProductToCart(state, product) {
        const cartItem = state.go_items.find(item => item.product.id === product.id)
        if (!cartItem)
            state.go_items.push({
                product,
                quantity: 1,
                days: [],
            })
        else
            cartItem.quantity++;
    },

    incrementGoItemQuantity(state, id) {
        const cartItem = state.go_items.find(item => item.product.id === id)
        cartItem.quantity++
    },
    setGoDaysForItem(state, data) {
        let cartItem = state.go_items.find(item => item.product.id === data.id)
        cartItem.days = data.days;


    },
    setGoItemQuantity(state, prod) {
        const cartItem = state.go_items.find(item => item.product.id === prod.id)
        cartItem.quantity = prod.quantity;

    },
    decrementGoItemQuantity(state, id) {
        const cartItem = state.go_items.find(item => item.product.id === id)
        if (cartItem.quantity > 1)
            cartItem.quantity--;
    },
    removeGoItem(state, id) {
        let tmp = state.go_items.filter((item) => item.product.id !== id);
        state.go_items = tmp
        //commit('setCartItems',tmp)
    },

    clearGoAllItems(state) {
        state.go_items = []
        //commit('setCartItems',tmp)
    },
    setGoCartItems(state, {go_items}) {
        state.go_items = go_items
    },

}

export default {
    state,
    getters,
    actions,
    mutations
}
