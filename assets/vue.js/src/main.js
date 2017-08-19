import Vue from 'vue';
import App from './App.vue';
import router from './router.js';
import store from './store/index';
import Vuex from 'vuex';
import axios from './http.js';
import { sync } from 'vuex-router-sync';
import ElementUI from 'element-ui';
import '@/assets/element/theme/index.css';

Vue.config.productionTip = false;

Vue.use(Vuex);
Vue.use(ElementUI);

sync(store, router);

new Vue({
    axios,
    router,
    store,
    render: h => h(App)
}).$mount('#app');