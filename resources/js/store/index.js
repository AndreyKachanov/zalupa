import { createStore } from "vuex";

import cart from "./cart"
import products from "./products"
import categories from "./categories"

export default createStore({
    modules: {
        products,
        cart,
        categories
    },
    // строгий режим запрещает менять данные отовсюду кроме мутаций.
    // для прод режима мы его отключаем. для дев режима он будет работать
    strict: process.env.NODE_ENV !== 'production',
});
