import Vue from 'vue'
import VueRouter from 'vue-router'

require('./bootstrap.js');

Vue.use(VueRouter);

import App from './components/App'
import Feeds from './components/Feeds'

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'feeds',
            component: Feeds
        }
    ]
});

const app = new Vue({
    el: '#app',
    components: {App},
    router,
});
