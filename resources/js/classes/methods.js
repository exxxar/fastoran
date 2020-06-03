export default {

    loadRestInfo(self, domain) {
        window
        axios
            .get(`/api/v1/rest/${domain}`)
            .then(resp => {
                self.restInfo = resp.data.restoran
                console.log(resp.data.restoran)
            })

        return this
    },
    clearCalck(self){
        self.message = "Настройки сброшены в исходные!"
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
}


