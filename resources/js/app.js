import './bootstrap';
import { createApp } from 'vue';
// базовый объект, который выводится во view
import App from './components/App';
import store from './store/index';
import router from './router/index';
// console.log(window.location.pathname)

if (window.location.pathname === '/') {
    const app = createApp(App);
    app.use(store);
    app.use(router);
// app.mount('#app-vue');
    store.dispatch('cart/load');
    store.dispatch('products/load').then(() => {
        app.mount('#app-vue');
    });

}

