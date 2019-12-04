
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import store from './store/index';
import recyclescroller from 'vue-virtual-scroller';

export const bus = new Vue()
window.Vue.use(recyclescroller);

Vue.component('searchcomponent', require('./components/Search.vue'))
Vue.component('posts', require('./components/Posts.vue'))
Vue.component('createPost', require('./components/CreatePost.vue'))
Vue.component('ips', require('./components/ip/Ip.vue'))
Vue.component('recyclescroller', require('./components/Clusterize.vue'))
Vue.component('vuevirtualtable', require('./components/VirtualTable.vue'))

const app = new Vue({
    el: '#app',
    store
});
