import { makeRequest } from "../api/server";

export default {
    namespaced: true,
    state: {
        products: [
            // { id: 100, cnt: 1},
            // { id: 101, cnt: 10},
        ],
        token: null
    },
    getters: {
        all: state => state.products,
        length: state=> state.products.length,
        // лежит товар в корзине или не лежит
        // параметрозованный геттер
        // has(state) {
            // return function (id) {
                // хотябы 1 элемент с таким id нашелся
        //         return state.products.some(pr => pr.id === id);
        //     }
        // },
        // короткий вариант записи
        // хотябы 1 элемент с таким id нашелся
        has: state => (id) => state.products.some(pr => pr.id === id),
        // выбранные товары
        // с помощью rootGetters обращается в модуль products и достаём с помощью гетера item по id инфу о товаре
        // далее склеиваем массивы
        productsDetailed(state, getters, rootState, rootGetters) {
            return state.products.map(pr => {
              let info = rootGetters['products/item'](pr.id);
              return { ...pr, ...info };
            });

        },
        // подсчет суммы товаров в корзине
        total: (state, getters) => getters.productsDetailed.reduce( (t, pr) => t + pr.price * pr.cnt, 0)
    },
    mutations: {
        add(state, id) {
            state.products.push({ id, cnt: 1});
        },
        remove(state, id) {
            state.products = state.products.filter(pr => pr.id !== id);
        },
        setCnt(state, { id, cnt }) {
            let i = state.products.findIndex(pr => pr.id === id);
            state.products[i].cnt = Math.max(1, cnt);
        },
        setCart(state, { token, cart }) {
            state.token = token;
            state.products = cart;
        }
    },
    actions: {
        async add({ state, getters, commit }, id) {
            // если в корзине нет такого элемента
            if (!getters.has(id)) {
                // let url = `http://faceprog.ru/reactcourseapi/cart/add.php?token=${state.token}&id=${id}`;
                let url = `https://localhost:3000/api/cart/add/token=${state.token}&id=${id}`;
                let res = await makeRequest(url);
                if (res) {
                    commit('add', id);
                }
            } else {
                console.log('В корзине такой элемент уже есть');
            }
        },
        async remove({ state, getters, commit }, id) {
            if (getters.has(id)) {
                let url = `http://faceprog.ru/reactcourseapi/cart/remove.php?token=${state.token}&id=${id}`;
                let res = await makeRequest(url);
                if (res) {
                    commit('remove', id);
                }
            } else {
                console.log('Товар уже удален из корзины');
            }
        },
        setCnt(store, payload) {
            if (store.getters.has(payload.id)) {
                store.commit('setCnt', payload);
            }
        },
        async load(store) {
            let oldToken = localStorage.getItem('CART_TOKEN');
            // let url = `http://faceprog.ru/reactcourseapi/cart/load.php?token=${oldToken}`;
            let url = `https://localhost:3000/api/cart/load?token=${oldToken}`;
            let { needUpdate, cart, token  } = await makeRequest(url);
            console.log(token);
            if (needUpdate) {
                localStorage.setItem('CART_TOKEN', token);
            }

            store.commit('setCart', { cart, token });
        }
    }
}
