import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import Antd from 'ant-design-vue';
import '@/assets/icons/fontawesome-5-pro/css/all.css';
import 'ant-design-vue/dist/reset.css';
import '@/assets/styles/main.css';
import Pusher from 'pusher-js';
import Echo from 'laravel-echo';

window.Pusher = Pusher;

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: import.meta.env.VITE_PUSHER_APP_KEY,
  cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
  forceTLS: true
});

const app = createApp(App);
app.use(router);
app.use(store);
app.use(Antd);
app.mount('#app');
