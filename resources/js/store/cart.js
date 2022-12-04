import { makeRequest, makeRequestPost } from "../api/server";

export default {
    namespaced: true,
    state: {
        // сохраненные в корзине товары
        products: [
            // { id: 100, cnt: 1},
            // { id: 101, cnt: 10},
        ],
        // массив выбранного количества товаров, но не сохраненного в корзину
        productsTemp: [
            // { id: 1, cnt: 5},
        ],
        token: null,
        billNumber: null
    },
    getters: {
        all: state => state.products,
        productsTemp: state => state.productsTemp,
        length: state=> state.products.length,
        billNumber: state=>  state.products.length > 0 ? state.billNumber : null,
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
        hasTemp: state => (id) => state.productsTemp.some(pr => pr.id === id),
        getCountFromCart(state, getters) {
          return function (id) {
              if (getters.has(id)) {
                  return state.products[state.products.findIndex(pr => pr.id === id)].cnt;
              } else if (getters.hasTemp(id))  {
                  return state.productsTemp[state.productsTemp.findIndex(pr => pr.id === id)].cnt;
                  // return 1;
              } else {
                  return 1;
              }
          }
        },

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
        addNew(state, { id, cnt }) {
            state.products.push({ id, cnt: cnt});
        },
        remove(state, id) {
            state.products = state.products.filter(pr => pr.id !== id);
        },
        setCnt(state, { id, cnt }) {
            console.log(id, cnt);
            let i = state.products.findIndex(pr => pr.id === id);
            state.products[i].cnt = Math.max(1, cnt);
        },
        setTempCnt(state, { id, cnt }) {
            console.log('test');
            console.log(id, cnt);
            let i = state.productsTemp.findIndex(pr => pr.id === id);
            console.log('i = ' + i);
            state.productsTemp[i].cnt = Math.max(1, cnt);
        },
        setTempCntPushArr(state, { id, cnt }) {
            // console.log(id, cnt);
            state.productsTemp.push({ id: id, cnt: cnt});
            // state.productsTemp[i].cnt = Math.max(1, cnt);
        },
        setCart(state, { token, cart }) {
            state.token = token;
            state.products = cart;
        },
        setBillNumber(state, number) {
            state.billNumber = number;
        }
    },
    actions: {
        async add({ state, getters, commit }, id) {
            // если в корзине нет такого элемента
            if (!getters.has(id)) {
                // let url = `https://catalog.loc/api/cart/add?token=${state.token}&id=${id}`;
                let url = `https://catalog.loc/api/cart/add/${state.token}/${id}`;
                let res = await makeRequestPost(url);
                if (res) {
                    commit('add', id);
                }
            } else {
                console.log('В корзине такой элемент уже есть');
            }
        },
        async addNew({ state, getters, commit }, id) {
            // если в корзине нет такого элемента
            if (!getters.has(id)) {
                // let url = `https://catalog.loc/api/cart/add?token=${state.token}&id=${id}`;
                // let cnt;

                let cnt = getters.hasTemp(id) ? state.productsTemp[state.productsTemp.findIndex(pr => pr.id === id)].cnt : 1 ;
                // console.log(cnt);
                let url = `https://catalog.loc/api/cart/add/token/${state.token}/item/${id}/count/${cnt}`;
                let res = await makeRequestPost(url);
                if (res) {
                    commit('addNew', { id, cnt });

                    console.log(state.billNumber);
                    console.log(this);
                    console.log(state.token);

                    if (state.billNumber === null) {

                        this.dispatch('cart/setBillNumber', state.token);

                        // let url = `https://catalog.loc/api/invoice/load?token=${state.token}`;
                        // let { bill_number  } = await makeRequest(url);
                        // commit('setBillNumber', bill_number);

                    } else {
                        console.log('bill_number !== null');
                    }

                    // let idx = state.productsTemp.findIndex(pr => pr.id === id);
                    // if (idx !== -1) {
                    //     // console.log( state.productsTemp[idx].cnt)
                    //     let cnt = state.productsTemp[idx].cnt;
                    //     commit('addNew', {id, cnt});
                    // } else {
                    //     commit('addNew', {id, cnt: 1});
                    // }

                }
            } else {
                console.log('В корзине такой элемент уже есть');
            }
        },
        async remove({ state, getters, commit }, id) {
            if (getters.has(id)) {
                // let url = `https://catalog.loc/api/cart/remove?token=${state.token}&id=${id}`;
                let url = `https://catalog.loc/api/cart/remove/${state.token}/${id}`;
                let res = await makeRequestPost(url);
                if (res) {
                    commit('remove', id);
                }
            } else {
                console.log('Товар уже удален из корзины');
            }
        },
        // async setCnt(state, store, id, cnt) {
        async setCnt({ state, getters, commit }, { id, cnt }) {
            // console.log(payload);
            // console.log(store.getters.all);
            if (getters.has(id)) {
                console.log(state.token);
                console.log(id);
                console.log(cnt);
                let url = `https://catalog.loc/api/cart/set-cnt/${state.token}/${id}/${cnt}`;
                let res = await makeRequestPost(url);
                if (res) {
                    console.log('Кол-во товара удачно обновлено на сервере');
                    commit('setCnt', { id, cnt });
                } else {
                    console.log('Ошибка обновления количества товара в корзине');
                }
            } else {
                console.log('Товара нет в корзине');
            }
        },
        setTempCnt(store, payload) {
            // console.log(store.state.productsTemp);

            // console.log(store.getters.all);
            if (store.getters.hasTemp(payload.id)) {
                console.log('индекс есть');
                store.commit('setTempCnt', payload);
            } else {
                store.commit('setTempCntPushArr', payload);
                // console.log('индекса нет');
            }
        },
        setTempCntToLocalStorage(store, payload) {
            // console.log(store.state.productsTemp);

            // console.log(store.getters.all);
            if (store.getters.hasTemp(payload.id)) {
                console.log('индекс есть');
                store.commit('setTempCnt', payload);
            } else {
                store.commit('setTempCntPushArr', payload);
                // console.log('индекса нет');
            }
        },
        async load(store) {
            let oldToken = localStorage.getItem('CART_TOKEN');
            let url = `https://catalog.loc/api/cart/load?token=${oldToken}`;
            let { needUpdate, cart, token  } = await makeRequest(url);

            if (needUpdate) {
                localStorage.setItem('CART_TOKEN', token);
            }

            store.commit('setCart', { cart, token });

            if (cart.length > 0) {
                // dispatch("setBillNumber", token);
                console.log('cart.length > 0');

                this.dispatch('cart/setBillNumber', token);
                // let url = `https://catalog.loc/api/invoice/load?token=${token}`;
                // let { bill_number  } = await makeRequest(url);
                // store.commit('setBillNumber', bill_number);

            } else {
                console.log('cart length < 0');
            }

        },
        async setBillNumber({ commit }, token) {

            let url = `https://catalog.loc/api/invoice/load?token=${token}`;
            let { bill_number  } = await makeRequest(url);
            commit('setBillNumber', bill_number);
        }

        // async setInvoiceNumber({ state, getters, commit }) {
        //     if ( state.invoiceNumber === null ) {
        //         // console.log('action setInvoiceNumber');
        //         let token = state.token;
        //         // console.log(token);
        //         let url = `https://catalog.loc/api/invoice/load?token=${token}`;
        //         let { bill_number } = await makeRequest(url);
        //         // console.log(res.bill_number);
        //         // localStorage.setItem('CART_BILL_NUMBER', bill_number);
        //         commit('setInvoiceNumber', bill_number);
        //     } else {
        //         console.log('invoiceNumber not null!')
        //     }
        // },
        // async loadBillNumber({ state, commit }) {
        //     let token = state.token;
        //     console.log('loadBillNumber token=' + token);
        //     // let url = `https://catalog.loc/api/invoice/load?token=${token}`;
        //     // let { bill_number  } = await makeRequest(url);
        //     // commit('setInvoiceNumber', bill_number);
        // },

    }
}
