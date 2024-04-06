import './bootstrap';

import { createApp } from "vue";
import app from "./components/app.vue";
import vuetify from "./vuetify";
import router from './router/index';
import store from './store';

import '@mdi/font/css/materialdesignicons.css';

createApp(app)
    .use(router)
    .use(store)
    .use(vuetify)
    .mount("#app");