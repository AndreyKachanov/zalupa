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
        // parentsCategories: function (state) {
        //     return state.categories.filter(cat => cat.parent_id === null)
        // },
        parentsCategories: state => state.categories.filter(cat => cat.parent_id === null),
        // subCategories: function (state) {
        //     return function (parentCategory) {
        //         return state.categories.filter(cat => cat.parent_id === parentCategory)
        //     }
        // },
        subCategories: state => (idCurrentCategory) => state.categories.filter(cat => cat.parent_id === idCurrentCategory)


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
           let parents = await makeRequest('/api/get-categories');
            // console.log(items);
            store.commit('setParents', parents.data);
        },
        setCacheUrls(store, slug) {
            // console.log('test', slug);
            store.commit('setCacheUrls', slug);
        }
    }
}
