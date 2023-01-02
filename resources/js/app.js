import './bootstrap';
import { createApp } from 'vue';
// базовый объект, который выводится во view
import App from './components/App';

import store from './store/index';
import router from './router/index';

// console.log(window.location.pathname)
let locationPath = window.location.pathname;
// добавить в массив product/[0-9]

if (['/', '/cart', '/order', '/category/1-populyarnye-tovary'].indexOf(locationPath) > -1) {
    const app = createApp({});

    app.component('app-component', App)

    app.use(store);
    app.use(router);

    router.beforeEach((to, from, next) => {
        if (to.name === 'category') {
            let slug = to.params.slug
            let cacheUrls = store.getters["categories/cacheUrls"];
            if (!cacheUrls.includes(slug)) {
                store.dispatch('products/getProductsFromCategory', slug);
                store.dispatch('categories/setCacheUrls', slug);
            }
        }
        next();
    });


    store.dispatch('categories/loadCategories');
    store.dispatch('cart/load');

    app.mount('#app-vue');
    // store.dispatch('products/load').then(() => {
    //     app.mount('#app-vue');
    // });

}

