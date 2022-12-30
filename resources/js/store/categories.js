import  { makeRequest } from "../api/server";

export default {
    namespaced: true,
    state: {
        categories: [],
        cacheUrls: []
    },
    getters: {
        allCategories: function (state) {
            return state.categories
        },
        cacheUrls: state => state.cacheUrls,
        parentsCategories: function (state) {
            return state.categories.filter(cat => cat.parent_id === null)
        },
        subCategories: function (state) {
            return function (parentCategory) {
                // return '123'
                // console.log('id parent', parentCategory);
                return state.categories.filter(cat => cat.parent_id === parentCategory)
            }
        }

    },
    mutations: {
        setParents(state, parents) {
            state.categories = parents;
        },
        setCacheUrls(state, slug) {
            state.cacheUrls.push(slug);
        }
    },
    actions: {
        async loadCategories(store) {
            // console.log(this.$router);
           let parents = await makeRequest('https://catalog.loc/api/get-categories');
            // console.log(items);
            store.commit('setParents', parents.data);
        },
        setCacheUrls(store, slug) {
            // console.log('test', slug);
            store.commit('setCacheUrls', slug);
        }
    }
}
