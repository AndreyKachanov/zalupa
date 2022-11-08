import  { makeRequest } from "../api/server";

export default {
    namespaced: true,
    state: {
        // items: tmpGetPr()
        items: []
    },
    getters: {
        // карта для кеширования (отношение айдишников и номера в массиве) - по айдишнику товара лежит номер элемента в массиве
        // нужна для быстрого поиска, например индекс в базе данных
        // такие карты актуальны для массивов больших и редко изменяющихся
        itemsMap(state) {
            // console.log(1);
            let map = {};
            state.items.forEach((pr, i) => {
                map[pr.id.toString()] = i;
                console.log(1);
            });
            // console.log(map);
            return map;
        },
        // получение 1 товара по id
        // item: state => id => state.items.find(pr => pr.id === id),
        // вариант с кешированием
        // у state.items забираем товар по номеру в массиве
        // item: (state, getters) => id => state.items[getters.itemsMap[id]],
        item(state, getters) {
          return function (id) {
              // console.log('----');
              // console.log(getters.itemsMap[100]);
              // console.log('----');
              // console.log(2);
              return state.items[getters.itemsMap[id]]
          }
        },
        all: function (state) {
            return state.items
        }
        // all: state => state.items
    },
    mutations: {
        setItems(state, items) {
            state.items = items;
        }

    },
    actions: {
        async load(store) {
            console.log(this.$router);
           let items = await makeRequest('https://localhost:3000/api/items');
            console.log(items);
            store.commit('setItems', items.data);
        }
    }
}
// функция заглушка
// function tmpGetPr() {
//     return [
//         {"id":100,"title":"Ipnone 200","price":12000,"rest":10},
//         {"id":101,"title":"Samsung AAZ8","price":22000,"rest":5},
//         {"id":103,"title":"Nokia 3310","price":5000,"rest":2},
//         {"id":105,"title":"Huawei ZZ","price":15000,"rest":8}
//     ];
// }
