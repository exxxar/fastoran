const state = {
    like_items: localStorage.getItem('vuejs__store_likes') == null ? [] : JSON.parse(localStorage.getItem('vuejs__store_likes')),
}

// getters
const getters = {
    likesProducts: (state, getters, rootState) => {
        let tmp = state.like_items;
        for (let i =0;i<tmp.length;i++)
            tmp[i].product.rest_info.is_work = true;

        return tmp;
    },
}

// actions
const actions = {
    getLikesProductList({state, commit}) {
        state.like_items = localStorage.getItem('vuejs__store_likes') == null ? [] : JSON.parse(localStorage.getItem('vuejs__store_likes'))
        return state.like_items
    },
    addProductToLikes({state, commit}, product) {
        commit('pushProductToLikes', product);
        localStorage.setItem('vuejs__store_likes', JSON.stringify(state.like_items));
    },
    removeProductFromLikes({state, commit}, id) {
        commit('removeLikeItem', id);
        localStorage.setItem('vuejs__store_likes', JSON.stringify(state.like_items));
    },
    clearLikes({state, commit}) {
        commit('clearAllLikeItems');
        localStorage.setItem('vuejs__store_likes', JSON.stringify(state.like_items));
    }
}

// mutations
const mutations = {
    pushProductToLikes(state, product) {
        const cartItem = state.like_items.find(item => item.product.id === product.id)
        if (!cartItem) {

            state.like_items.push({
                product,
                quantity: 0
            })
        }
    },
    removeLikeItem(state, id) {
        let tmp = state.like_items.filter((item) => item.product.id !== id);
        state.like_items = tmp
        //commit('setCartItems',tmp)
    },

    clearAllLikeItems(state) {
        state.like_items = []
        //commit('setCartItems',tmp)
    },

}

export default {
    state,
    getters,
    actions,
    mutations
}
