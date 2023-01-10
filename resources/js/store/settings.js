import  { makeRequest } from "../api/server";

export default {
    namespaced: true,
    state: {
        settings: []
    },
    getters: {
        allSettings: function (state) {
            return state.settings
        },
    },
    mutations: {
        setSettings(state, settings) {
            state.settings = settings;
        },
    },
    actions: {
        async loadSettings(store) {
            // console.log(this.$router);
           let settings = await makeRequest('/api/get-settings');
            // console.log(items);
            store.commit('setSettings', settings.data);
        }
    }
}
