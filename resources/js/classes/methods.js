export default {

    loadRestInfo(self, domain) {

        window
            .axios
            .get(`/api/v1/rest/${domain}`)
            .then(resp => {
                self.restInfo = resp.data.restoran
                console.log(resp.data.restoran)
            })

        return this
    },
    clearCalc(self) {
        self.message = "Пространство для творчество обновлено!"
        clearTimeout(self.timer)
        self.timer = setTimeout(() => {
            self.message = ''
        }, 5000)

        self.summary_count = 0
        self.fillings = []

        self.sendMessage(
            "Настройки сброшены в исходные!"
        )
    },
    decrementSummary(self) {
        self.summary_count -= self.summary_count >= 1 ? 1 : 0;
    },
    incrementSummary(self) {
        self.summary_count++;
    },
    addItem(self, id) {
        self.fillings.push(id)
    },
    removeItem(self, id) {
        let index = self.fillings.indexOf(id);
        if (index > -1) {
            self.fillings.splice(index, 1);
        }
    },
    hasManyItems(self, id) {
        return self.fillings.filter(item => item === id).length
    },
    watchForFillings(self, val) {
        self.price = 0;
        self.weight = 0;

        val.forEach((item) => {
            let product = self.$store.getters.getIngredientById(item)
            self.price += product.price
            self.weight += product.weight
        });

        self.summary_price = self.price * self.summary_count
        self.summary_weight = self.weight * self.summary_count
    },
    prepareCheckedItems(self, arr) {
        arr.forEach(cat => {
            let from = self.$store.getters.getIngredientsFilling(cat)
            from.filter(item => item.checked).forEach((item, index) => {
                if (!self.fillings.includes(item)) {
                    self.fillings.push(item.id)
                }
            })
        });



        return this;
    },
    getCategory(self, id) {
        return self.$store.getters.getIngredientsCategory(id)
    },
    getFilling(self, type) {
        return self.$store.getters.getIngredientsFilling(type)
    },
    getFillingById(self, id) {
        return self.$store.getters.getIngredientById(id)
    },
    checkFirstRestoran(self,restId) {
        return self.products.filter(item => item.product.rest_id !== restId).length === 0 || self.products.length === 0;
    },
    addToCart(self,title) {

        if (!this.checkFirstRestoran(self,self.restInfo.id)) {
            self.message = "У вас в корзине лежит товар от другого заведения:(";
            self.sendMessage("Возможно одновременно заказать только из одного заведения!", 'error')
            return;
        }

        let tmp_info = '';

        let map_fill = new Map();

        self.fillings.forEach((item, index) => {
            let ingr = this.getFillingById(self, item)
            let title = `${ingr.title} (${ingr.weight} гр.)`
            if (map_fill.has(title)) {
                let count = map_fill.get(title)
                count++
                map_fill.set(title, count)

            } else
                map_fill.set(title, 1);

        })

        map_fill.forEach(function (value, key) {
            tmp_info += `${key} x${value}\n`

        });


        var uniqid = require('uniqid');

        let product = {
            id:uniqid(),
            food_ext: self.weight,
            food_img: self.restInfo.logo,
            food_name: title,
            food_price: self.price,
            food_remark: `\nСостав: ${tmp_info} `,
            food_status: 5,
            rest_id: self.restInfo.id,
            restoran: self.restInfo,

        };

        for (let i = 0; i < self.summary_count; i++)
            self.$store.dispatch('addProductToCart', product)

        self.sendMessage(
            "Ваш кулинарный шедевр добавлен в корзину!"
        )
        self.message = "Ваш кулинарный шедевр добавлен в корзину!"

        setTimeout(()=>self.clearCalc(),2000)

    },
}


