import './bootstrap';

import { createApp } from 'vue';
import { createPinia } from 'pinia'
import App from '/OSPanel/home/laravel.vue/resources/js/infrastructure/config/app.vue';
import router from '/OSPanel/home/laravel.vue/resources/js/infrastructure/router/index.js'

const pinia = createPinia()

createApp(App)
  .use(router)
  .use(pinia)
  .mount('#app');
