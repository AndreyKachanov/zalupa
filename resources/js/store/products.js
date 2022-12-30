import  { makeRequest } from "../api/server";

export default {
    namespaced: true,
    state: {
        // items: tmpGetPr()
        items: [],
        showMoreArr: {},
        mataInfo: {}
        // itemsFromParent: []
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
                // console.log(1);
            });
            // console.log(map);
            return map;
        },
        itemsMapSlug(state) {
            // console.log(1);
            let map = {};
            state.items.forEach((pr, i) => {
                map[pr.slug.toString()] = i;
                // console.log(1);
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
        itemSlug(state, getters) {
            return function (slug) {
                // console.log(slug, ' - ', getters.itemsMapSlug[slug]);
                return state.items[getters.itemsMapSlug[slug]]
            }
        },
        // allFromParentCategory: function (state) {
        //     return state.itemsFromParent
        // }
        // возвращает все items, где category = ids
        itemsFromCategories(state) {
            return function (ids) {
                // console.log('ids2', ids);
                return state.items.filter(item => ids.includes(item.category));
            }
        },
        // hasNewItemsForPagination: state => slug => state.showMoreArr[slug],
        hasNewItemsForPagination(state) {
            return function (slug) {
                // setTimeout(() => console.log('setTimeout 111 test = ', state.showMoreArr[slug]), 50);
                // console.log('>>>1', state.showMoreArr[slug]);
                return state.showMoreArr[slug];
            }
        },
        metaInfo: state => state.mataInfo,

        // itemsFromCategoryAndSubCategory: state => ids => state.items.filter(item => ids.includes(item.category)),
        // productsWithParentCategories: state => (categories, slug) => state.items.filter(item => item.category === categories[categories.findIndex(pr => pr.slug === slug)].id),
        all: state => state.items,
        // showMoreArr: state => state.showMoreArr,
        showMoreArr(state) {
            // console.log('>>>2', state.showMoreArr);
            return state.showMoreArr;
        }
    },
    mutations: {
        setItems(state, items) {
            state.items = items;
        },
        setItemsTest(state, newItems) {
            // console.log('old items:', state.items);
            // console.log('setItemsTest:', newItems);

            // Добавляем только не дублирующиеся элементы из newItems по ключу id
            state.items.push(...newItems.filter(item => (state.items.find(pr => pr.id === item.id) == null)));
        },
        // test(state) {
        //     state.items.push({
        //         article_number: "0303.1.9003", category: 1, id: 20, img:"https://catalog.loc/uploads/items/f48b9456a2dbd817426fe4d052efd4dd.jpg", link: ".", price: "370.00", title: "Шар FlyNova Pro"
        //     });
        // },
        setMetaInfo(state, metaInfo) {
            state.mataInfo = metaInfo;
            // console.log('setMetaInfo = ', state.mataInfo.current_page);
        },
        setShowMoreArrItem(state, { slug, metaInfo }) {
            // console.log('setShowMoreArrItem', slug, metaInfo);
            let currentPage = metaInfo.current_page;
            let lastPage = metaInfo.last_page;

            // console.log('setShowMoreItem slug', slug);
            // console.log('setShowMoreItem metaInfo', metaInfo);
            if (currentPage < lastPage) {
                state.showMoreArr[slug] = currentPage;
            }
            if (currentPage === lastPage) {
                state.showMoreArr[slug] = false;
            }
            // console.log(state.showMoreArr);
        },

    },
    actions: {
        async load(store) {
            // console.log(this.$router);
           let items = await makeRequest('https://catalog.loc/api/items');
            // console.log(items);
            store.commit('setItems', items.data);
        },
        async getProductsFromParentCategoryAndSubcategories({ commit }, slug) {
            let url = `https://catalog.loc/api/items/category/${slug}`;
            let items  = await makeRequest(url);
            // console.log(items.data);
            commit('setItemsTest', items.data);
        },
        async getProductsFromCategory({ commit }, slug, page = 1) {

            let url = `https://catalog.loc/api/items/category/${slug}?page=${page}`;
            let items  = await makeRequest(url);
            // console.log('>>>1', items);
            commit('setItemsTest', items.data);
            let metaInfo =  items.meta;
            // commit('setMetaInfo', metaInfo);
            commit('setShowMoreArrItem', { slug, metaInfo });

        },
        async showMore({ commit, state }, slug) {
            let page = state.showMoreArr[slug] + 1
            // console.log('page=', state.showMoreArr[slug]);
            // console.log('showMore slug =', slug);
            let url = `https://catalog.loc/api/items/category/${slug}?page=${page}`;
            let items  = await makeRequest(url)
            commit('setItemsTest', items.data);
            let metaInfo =  items.meta;
            commit('setShowMoreArrItem', { slug, metaInfo });
        },
        setShowMoreItem({commit}, {slug, metaInfo}) {
            console.log('action setShowMoreItem', metaInfo);
            console.log('залупа >>>2', metaInfo);
            commit('setShowMoreItem1', { slug, metaInfo });
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
