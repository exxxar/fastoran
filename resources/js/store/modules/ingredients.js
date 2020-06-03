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
        {id: 9, title: "Верхнее покрытие ролла"},
        {id: 10, title: "Начинка ролла"},
        {id: 11, title: "Основа ролла"},
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

        {id: 61, title: "Основа ролла", weight: 95, price: 80, category: 11, checked:true, disabled:true},
        {id: 62, title: "Лосось", weight: 30, price: 100, category: 9, checked:false, disabled:false},
        {id: 63, title: "Тунец", weight: 30, price: 110, category: 9, checked:false, disabled:false},
        {id: 64, title: "Угорь", weight: 30, price: 130, category: 9, checked:false, disabled:false},
        {id: 65, title: "Креветка Тигровая", weight: 30, price: 140, category: 9, checked:false, disabled:false},
        {id: 66, title: "Окунь", weight: 30, price: 60, category: 9, checked:false, disabled:false},
        {id: 67, title: "Кунжут Белый", weight: 30, price: 20, category: 9, checked:false, disabled:false},
        {id: 68, title: "Кунжут Черный", weight: 30, price: 20, category: 9, checked:false, disabled:false},
        {id: 69, title: "Кунжут ч/б", weight: 30, price: 30, category: 9, checked:false, disabled:false},
        {id: 70, title: "Икра Тобико Красная", weight: 30, price:50, category: 9, checked:false, disabled:false},
        {id: 71, title: "Икра Тобико Зелёная", weight: 30, price:50, category: 9, checked:false, disabled:false},
        {id: 72, title: "Икра Тобико Черная", weight: 30, price:50, category: 9, checked:false, disabled:false},
        {id: 73, title: "Струшка Тунца", weight: 30, price:30, category: 9, checked:false, disabled:false},
        {id: 74, title: "Огурец", weight: 30, price:20, category: 9, checked:false, disabled:false},
        {id: 75, title: "Авакадо", weight: 30, price:100, category: 9, checked:false, disabled:false},
        {id: 76, title: "Укроп", weight: 30, price:10, category: 9, checked:false, disabled:false},
        {id: 77, title: "Нори", weight: 30, price:15, category: 9, checked:true, disabled:false},
        {id: 78, title: "Лосось", weight: 30, price:50, category: 10, checked:false, disabled:false},
        {id: 79, title: "Тунец", weight: 30, price:50, category: 10, checked:false, disabled:false},
        {id: 80, title: "Угорь", weight: 30, price:65, category: 10, checked:false, disabled:false},
        {id: 81, title: "Креветка Тигровая", weight: 30, price:70, category: 10, checked:false, disabled:false},
        {id: 82, title: "Окунь", weight: 30, price:30, category: 10, checked:false, disabled:false},
        {id: 83, title: "Снежный Краб", weight: 30, price:30, category: 10, checked:false, disabled:false},
        {id: 84, title: "Мидии", weight: 30, price:30, category: 10, checked:false, disabled:false},
        {id: 85, title: "Кальмар", weight: 30, price:30, category: 10, checked:false, disabled:false},
        {id: 86, title: "Курица Жареная", weight: 30, price:30, category: 10, checked:false, disabled:false},
        {id: 87, title: "Лосось Жаренный", weight: 30, price:55, category: 10, checked:false, disabled:false},
        {id: 88, title: "Окунь Жаренный", weight: 30, price:35, category: 10, checked:false, disabled:false},

        {id: 89, title: "Сливочный Сыр", weight: 30, price:30, category: 10, checked:false, disabled:false},
        {id: 90, title: "Плаванный сыр", weight: 30, price:25, category: 10, checked:false, disabled:false},
        {id: 91, title: "Икра Тобико Красная", weight: 30, price:50, category: 10, checked:false, disabled:false},
        {id: 92, title: "Икра Лосося", weight: 30, price:100, category: 10, checked:false, disabled:false},
        {id: 93, title: "Огурец", weight: 30, price:10, category: 10, checked:false, disabled:false},
        {id: 94, title: "Авакадо", weight: 30, price:50, category: 10, checked:false, disabled:false},
        {id: 95, title: "Чука", weight: 30, price:15, category: 10, checked:false, disabled:false},
        {id: 96, title: "Помидор", weight: 30, price:15, category: 10, checked:false, disabled:false},
        {id: 97, title: "Сладкиц Перец", weight: 30, price:15, category: 10, checked:false, disabled:false},
        {id: 98, title: "Айсберг", weight: 30, price:15, category: 10, checked:false, disabled:false},
        {id: 99, title: "Лук зелёный", weight: 30, price:10, category: 10, checked:false, disabled:false},
        {id: 100, title: "Соус спайси", weight: 30, price:15, category: 10, checked:false, disabled:false},
        {id: 101, title: "Майонез", weight: 30, price:10, category: 10, checked:false, disabled:false}
    ]
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
