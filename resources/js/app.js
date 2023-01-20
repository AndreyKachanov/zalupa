import './bootstrap';
import { createApp } from 'vue';
// базовый объект, который выводится во view
import App from './components/App';

import store from './store/index';
import router from './router/index';

// console.log(window.location.pathname)
let locationPath = window.location.pathname;
// добавить в массив product/[0-9]
// console.log(locationPath);


// ^\/category\/[\w\-]+$ - любой буквенный символ или дефис
// ^\/category\/[a-z\-0-1]+$

// console.log('res=', /^\/category\/[a-z\-0-1]+$/.test(locationPath)); // false
let isSubCategoryPath = /^\/category\/[a-z0-9\-]*$/.test(locationPath);

// let arrPath = ['/', '/cart', '/contacts', '/order', '/category/1-populyarnye-tovary', '/category/sub-1-main-1-populyarnye-tovary'];
let arrPath = ['/', '/cart', '/contacts', '/order'];
if ( arrPath.indexOf(locationPath) > -1 || isSubCategoryPath) {
    // console.log('test');
    const app = createApp({});

    app.component('app-component', App)

    app.use(store);
    app.use(router);

    router.beforeEach((to, from, next) => {
        if (to.name === 'category') {
            let slug = to.params.slug;
            // console.log(slug);
            let cacheUrls = store.getters["categories/cacheUrls"];
            if (!cacheUrls.includes(slug)) {
                // console.log(1);
                store.dispatch('products/getProductsFromCategory', slug);
                store.dispatch('categories/setCacheUrls', slug);
            }
        }
        next();
    });


    store.dispatch('categories/loadCategories');
    store.dispatch('cart/load');
    store.dispatch('settings/loadSettings');

    app.mount('#app-vue');
    // store.dispatch('products/load').then(() => {
    //     app.mount('#app-vue');
    // });

}

