import './bootstrap';
import {createApp} from 'vue/dist/vue.esm-bundler.js';
import Main_dashboard from '@/components/Main_dashboard.vue';
import router from '@/router';
import { createPinia } from 'pinia';
const app = createApp({});
const pinia = createPinia();

app.component('app-component', Main_dashboard);

app.use(router);
app.use(pinia); 
app.mount("#app");
