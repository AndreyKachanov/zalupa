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
           let settings = await makeRequest('/api/get-settings');
            store.commit('setSettings', settings.data);
        }
    }
}
