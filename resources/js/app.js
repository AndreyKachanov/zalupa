import './bootstrap';

import { createApp } from 'vue';
// базовый объект, который выводится во view
import App from './components/App';

const app = createApp(App);
app.mount('#app-vue');
