import axios from 'axios'
window.axios = axios
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Vue from 'vue';
window.Vue = Vue;

import {Circle} from 'vue-loading-spinner';

Vue.component('questionnaire',()=>import('./components/Questionnaire'))
Vue.component('vue-spinner', Circle)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
