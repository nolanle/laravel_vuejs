/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
window.Vue = require('vue');

import VueRouter from 'vue-router';
window.Vue.use(VueRouter);

import VueSweetalert from 'vue-sweetalert2';
window.Vue.use(VueSweetalert);

Vue.use(require('vue-moment'));

import VueCurrencyFilter from 'vue-currency-filter';
window.Vue.use(VueCurrencyFilter, {
    symbol : 'VNĐ', thousandsSeparator: '.', fractionCount: 0, fractionSeparator: ',', symbolPosition: 'back', symbolSpacing: true
});

import PrettyCheckbox from 'pretty-checkbox-vue';
window.Vue.use(PrettyCheckbox);

import VueTextareaAutosize from 'vue-textarea-autosize';
window.Vue.use(VueTextareaAutosize);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component('switches', require('vue-switches'));

Vue.component('header-component', require('./components/Header.vue'));
Vue.component('sidebar', require('./components/Sidebar.vue'));
Vue.component('footer-component', require('./components/Footer.vue'));

import router from './routes';
const app = new Vue({ router }).$mount('#app');

