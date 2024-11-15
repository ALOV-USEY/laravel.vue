import { createRouter, createWebHistory } from 'vue-router';
import Start from '/OSPanel/home/laravel.vue/resources/js/ui/pages/Start.vue';
import Find from '/OSPanel/home/laravel.vue/resources/js/ui/pages/Find.vue';
import HotelPage from '/OSPanel/home/laravel.vue/resources/js/ui/pages/HotelPage.vue';
import Admin from '/OSPanel/home/laravel.vue/resources/js/ui/pages/Admin.vue';
import SecondChat from '/OSPanel/home/laravel.vue/resources/js/ui/pages/SecondChat.vue';
import Login from '/OSPanel/home/laravel.vue/resources/js/ui/pages/Login.vue';
import Register from '/OSPanel/home/laravel.vue/resources/js/ui/pages/Register.vue';
import HotelManager from '/OSPanel/home/laravel.vue/resources/js/ui/components/HotelManager.vue';

const routes = [
  { path: '/', name: 'Start', component: Start },
  { path: '/find', name: 'Find', component: Find },
  { path: '/hotels/:id', name: 'HotelPage', component: HotelPage },
  { path: '/admin', name: 'Admin', component: Admin },
  { path: '/second-chat', name: 'Second Chat', component: SecondChat },
  { path: '/login', name: 'Login', component: Login },
  { path: '/register', name: 'Register', component: Register },
  { path: '/hotel-manager', name: 'Hotel Manager', component: HotelManager }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
