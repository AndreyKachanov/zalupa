import './bootstrap';
import { createApp } from 'vue';
// базовый объект, который выводится во view
import App from './components/App';

import store from './store/index';
import router from './router/index';

// console.log(window.location.pathname)
let locationPath = window.location.pathname;
// добавить в массив product/[0-9]

if (['/', '/cart', '/order'].indexOf(locationPath) > -1) {
    const app = createApp({});

    app.component('app-component', App)

    app.use(store);
    app.use(router);
    console.log(router);
    console.log(store.getters["cart/all"]);


    store.dispatch('cart/load');
    // store.dispatch('cart/loadBillNumber');
    store.dispatch('products/load').then(() => {
        app.mount('#app-vue');
    });

}

