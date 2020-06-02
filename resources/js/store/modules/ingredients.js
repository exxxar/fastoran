const state = {
    filling_categories:[
        {id: 1, title: "Овощные начинки"},
        {id: 2, title: "Мясные начинки"},
        {id: 3, title: "Морские начинки"},
        {id: 4, title: "Сырные начинки"},
        {id: 5, title: "Блинчики сладкие"},
        {id: 6, title: "Сладкие добавки"},
        {id: 7, title: "Блинчики соленые"},
        {id: 8, title: "Основа пиццы"},
    ],
    filling: [
        {id: 1, title: "Грибы жаренные", weight: 50, price: 45, category: 1, checked:false, disabled:false},
        {id: 2, title: "Грибы стерилизованные", weight: 40, price: 45, category: 1, checked:false, disabled:false},
        {id: 3, title: "Грибы свежие", weight: 40, price: 45, category: 1, checked:false, disabled:false},
        {id: 4, title: "Ананасы", weight: 40, price: 35, category: 1, checked:false, disabled:false},
        {id: 5, title: "Помидоры свежие", weight: 50, price: 30, category: 1, checked:false, disabled:false},
        {id: 6, title: "Перец болгарский", weight: 40, price: 30, category: 1, checked:false, disabled:false},
        {id: 7, title: "Кукуруза", weight: 40, price: 30, category: 1, checked:false, disabled:false},
        {id: 8, title: "Маслины", weight: 30, price: 55, category: 1, checked:false, disabled:false},
        {id: 9, title: "Фасоль спаржевая", weight: 50, price: 30, category: 1, checked:false, disabled:false},
        {id: 10, title: "Пепперони", weight: 30, price: 26, category: 1, checked:false, disabled:false},
        {id: 11, title: "Маринованный лук", weight: 50, price: 12, category: 1, checked:false, disabled:false},
        {id: 12, title: "Огурец маринованный", weight: 50, price: 30, category: 1, checked:false, disabled:false},
        {id: 13, title: "Зелень петрушки к пицце", weight: 3, price: 12, category: 1, checked:false, disabled:false},
        {id: 14, title: "Зелень укропа к пицце", weight: 3, price: 12, category: 1, checked:false, disabled:false},
        {id: 15, title: "Балык мясной", weight: 40, price: 50, category: 2, checked:false, disabled:false},
        {id: 16, title: "Курица", weight: 50, price: 55, category: 2, checked:false, disabled:false},
        {id: 17, title: "Охотничьи колбаски", weight: 50, price: 55, category: 2, checked:false, disabled:false},
        {id: 18, title: "Салями", weight: 40, price: 50, category: 2, checked:false, disabled:false},
        {id: 19, title: "Бекон", weight: 40, price: 50, category: 2, checked:false, disabled:false},
        {id: 20, title: "Салями острая пепперони", weight: 25, price: 55, category: 2, checked:false, disabled:false},
        {id: 21, title: "Кальмары", weight: 50, price: 85, category: 3, checked:false, disabled:false},
        {id: 22, title: "Крабовые палочки", weight: 50, price: 40, category: 3, checked:false, disabled:false},
        {id: 23, title: "Семга", weight: 40, price: 135, category: 3, checked:false, disabled:false},
        {id: 24, title: "Ди Маре", weight: 150, price: 135, category: 3, checked:false, disabled:false},
        {id: 25, title: "Твердый сыр", weight: 70, price: 55, category: 4, checked:false, disabled:false},
        {id: 26, title: "Фета", weight: 50, price: 60, category: 4, checked:false, disabled:false},
        {id: 27, title: "Пармезан", weight: 15, price: 40, category: 4, checked:false, disabled:false},
        {id: 28, title: "Моцарелла", weight: 60, price: 60, category: 4, checked:false, disabled:false},

        {id: 29, title: "Блинчик соленый", weight: 50, price: 45, category: 7, checked:true, disabled:true},
        {id: 30, title: "Семга, тар-тар", weight: 50, price: 45, category: 7, checked:false, disabled:false},
        {id: 31, title: "Икра красная", weight: 50, price: 45, category: 7, checked:false, disabled:false},
        {id: 32, title: "Грибы(20г), сыр(20г)", weight: 50, price: 45, category: 7, checked:false, disabled:false},
        {id: 33, title: "Курица(30г), сыр(20г)", weight: 50, price: 45, category: 7, checked:false, disabled:false},
        {id: 34, title: "Сыр", weight: 50, price: 45, category: 7, checked:false, disabled:false},
        {id: 35, title: "Сыр(20г), грибы(20г), балык(20г)", weight: 50, price: 45, category: 7, checked:false, disabled:false},
        {id: 36, title: "Салями, помидор, сыр", weight: 50, price: 45, category: 7, checked:false, disabled:false},
        {id: 37, title: "Курица, грибы, сметана", weight: 50, price: 45, category: 7, checked:false, disabled:false},
        {id: 38, title: "С балыком 'Три желания'", weight: 50, price: 45, category: 7, checked:false, disabled:false},
        {id: 39, title: "С семгой 'Три желания'", weight: 50, price: 45, category: 7, checked:false, disabled:false},
        {id: 40, title: "Помидор(17г), сыр(30г), майонез(10г), зелень(3г)", weight: 50, price: 45, category: 7, checked:false,disabled:false},

        {id: 41, title: "Блинчик сладкий", weight: 50, price: 45, category: 5, checked:true, disabled:true},
        {id: 42, title: "Апельсин конфи", weight: 50, price: 45, category: 5, checked:false, disabled:false},
        {id: 43, title: "Банан (50г), шоколад(15г)", weight: 65, price: 45, category: 5, checked:false, disabled:false},
        {id: 44, title: "Альфорно / Творожная начинка", weight: 65, price: 45, category: 5, checked:false, disabled:false},
        {id: 45, title: "Нутелла / Банан / Мороженное", weight: 65, price: 45, category: 5, checked:false, disabled:false},
        {id: 46, title: "Творожная начинка / Апельсин конфи", weight: 65, price: 45, category: 5, checked:false, disabled:false},
        {id: 47, title: "Смородина / Творожная начинка", weight: 65, price: 45, category: 5, checked:false, disabled:false},
        {id: 48, title: "Вишня конфи", weight: 65, price: 45, category: 5, checked:false, disabled:false},
        {id: 49, title: "Клубника конфи", weight: 65, price: 45, category: 5, checked:false, disabled:false},
        {id: 50, title: "Нутелла(30г), орехи(5г)", weight: 65, price: 45, category: 5, checked:false, disabled:false},
        {id: 51, title: "Нутелла(30г), орехи(5г)", weight: 65, price: 45, category: 5, checked:false, disabled:false},
        {id: 52, title: "Мёд", weight: 65, price: 45, category: 6, checked:false, disabled:false},
        {id: 53, title: "Сгущенное молоко", weight: 65, price: 45, category: 6, checked:false, disabled:false},
        {id: 54, title: "Сметана", weight: 65, price: 45, category: 6, checked:false, disabled:false},
        {id: 55, title: "Соус ванильный", weight: 65, price: 45, category: 6, checked:false, disabled:false},
        {id: 56, title: "Черная смородина", weight: 65, price: 45, category: 6, checked:false, disabled:false},
        {id: 57, title: "Шоколад", weight: 65, price: 45, category: 6, checked:false, disabled:false},
        {id: 58, title: "Яблоки, корица", weight: 65, price: 45, category: 6, checked:false, disabled:false},


        {id: 59, title: "Пицца Челентано", weight: 350, price: 95, category: 8, checked:true, disabled:false},
        {id: 60, title: "Пицца Челентано с белым соусом", weight: 95, price: 45, category: 8, checked:false, disabled:false},


    ],
}

// getters
const getters = {
    getIngredientById:(state)=>(id)=>{
      return state.filling.find(item=>item.id===id)
    },
    getIngredientsCategory: (state) => (id) => {
        return state.filling_categories.filter(item => item.id === id)[0]
    },
    getIngredientsFilling: (state) => (type) => {
        return state.filling.filter(item => item.category === type)
    }
}

// actions
const actions = {

}

// mutations
const mutations = {

}

export default {
    state,
    getters,
    actions,
    mutations
}
