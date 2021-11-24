

require('./bootstrap');
import vuetify from './plugins/vuetify'
window.Vue = require('vue').default;

import loginPage from './pages/loginPage.vue'
import dashboardPage from './pages/dashboardPage.vue'
import router from './router/index'
import store from './store/index'
import './plugins/vuedarkmode'
const app = new Vue({
    el: '#app',
    vuetify,
    components : {
        loginPage,
        dashboardPage
    },
    router : router,
    store : store
});
