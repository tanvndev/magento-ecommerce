import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import Antd from 'ant-design-vue';
import '@/assets/icons/fontawesome-5-pro/css/all.css';
import 'ant-design-vue/dist/reset.css';
import '@/assets/styles/main.css';
import vue3GoogleLogin from 'vue3-google-login'

const app = createApp(App);

app.use(vue3GoogleLogin, {
  clientId: import.meta.env.VITE_GOOGLE_CLIENT_ID
});

app.use(router);
app.use(store);
app.use(Antd);

app.mount('#app');
