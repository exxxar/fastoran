const state = {
    items: localStorage.getItem('vuejs__store') == null ? [] : JSON.parse(localStorage.getItem('vuejs__store')),
}

// getters
const getters = {
    cartProducts: (state, getters, rootState) => {

        return state.items;
    },
    cartTotalCount: (state, getters) => {

        if (state.items == null)
            return 0;

        if (state.items.length === 0)
            return 0;

        let summ = 0;
        state.items.forEach((item) => {
            summ += item.quantity
        });
        return summ
    },
    cartTotalPrice: (state, getters) => {
        if (state.items == null)
            return 0;

        if (state.items.length === 0)
            return 0;

        let summ = 0;
        state.items.forEach((item) => {
            if (item.weight) {
                summ += item.product.food_price * (item.weight/item.product.food_ext)
            }
            else
            summ += item.product.food_price * item.quantity
        });
        return summ
    }
}

// actions
const actions = {
    getProductList({state, commit}) {
        state.items = localStorage.getItem('vuejs__store') == null ? [] : JSON.parse(localStorage.getItem('vuejs__store'))
        return state.items
    },
    inCart({state, commit}, id) {
        return (state.items.filter(item => item.product.id === id)).length
    },
    addProductToCart({state, commit}, product) {
        commit('pushProductToCart', product);
        localStorage.setItem('vuejs__store', JSON.stringify(state.items));
    },
    addProductToCartWithWeight({state, commit}, prod) {
        commit('pushProductToCartWithWeight', prod);
        localStorage.setItem('vuejs__store', JSON.stringify(state.items));
    },
    remSub({state, commit}, id) {
        commit("removeSubFromItem", id)
        localStorage.setItem('vuejs__store', JSON.stringify(state.items));
    },
    addSub({state, commit}, sub) {
        commit("addSubToItem", sub)
        localStorage.setItem('vuejs__store', JSON.stringify(state.items));
    },
    setQuantity({state, commit}, prod) {
        commit('setItemQuantity', prod);
        console.log("q1")
        localStorage.setItem('vuejs__store', JSON.stringify(state.items));
    },
    incQuantity({state, commit}, id) {
        commit('incrementItemQuantity', id);
        localStorage.setItem('vuejs__store', JSON.stringify(state.items));
    },
    decQuantity({state, commit}, id) {
        commit('decrementItemQuantity', id);
        localStorage.setItem('vuejs__store', JSON.stringify(state.items));
    },
    removeProduct({state, commit}, id) {
        commit('removeItem', id);
        localStorage.setItem('vuejs__store', JSON.stringify(state.items));
    },
    clearCart({state, commit}) {
        commit('clearAllItems');
        localStorage.setItem('vuejs__store', JSON.stringify(state.items));
    }
}

// mutations
const mutations = {
    pushProductToCartWithWeight(state, prod) {
        const cartItem = state.items.find(item => item.product.id === prod.product.id)

        let product = prod.product

        if (!cartItem)
            state.items.push({
                product,
                quantity: 1,
                weight: prod.weight
            })
        else {
            cartItem.weight = prod.weight;
            if (prod.weight === 0||prod.product.food_ext>cartItem.weight) {
                let tmp = state.items.filter((item) => item.product.id !== prod.product.id);
                state.items = tmp
            }

        }


    },
    pushProductToCart(state, product) {
        const cartItem = state.items.find(item => item.product.id === product.id)
        if (!cartItem)
            state.items.push({
                product,
                quantity: 1
            })
        else
            cartItem.quantity++;
    },
    removeSubFromItem(state, id) {
        const cartItem = state.items.find(item => item.product.id === id)
        let tmp = cartItem.product.selected_sub
        tmp = tmp.split(',')
        tmp = tmp.slice(0, tmp.length - 1).join()
        cartItem.product.selected_sub = tmp

    },
    addSubToItem(state, sub) {
        const cartItem = state.items.find(item => item.product.id === sub.id)
        cartItem.product.selected_sub = sub.more_info
    },
    incrementItemQuantity(state, id) {
        const cartItem = state.items.find(item => item.product.id === id)
        cartItem.quantity++
    },
    setItemQuantity(state, prod) {
        console.log(prod)
        const cartItem = state.items.find(item => item.product.id === prod.id)
        console.log(cartItem.quantity)
        cartItem.quantity = prod.quantity;

    },

    decrementItemQuantity(state, id) {
        const cartItem = state.items.find(item => item.product.id === id)
        if (cartItem.quantity > 1)
            cartItem.quantity--;
    },
    removeItem(state, id) {
        let tmp = state.items.filter((item) => item.product.id !== id);
        state.items = tmp
        //commit('setCartItems',tmp)
    },

    clearAllItems(state) {
        state.items = []
        //commit('setCartItems',tmp)
    },
    setCartItems(state, {items}) {
        state.items = items
    },

}

export default {
    state,
    getters,
    actions,
    mutations
}
