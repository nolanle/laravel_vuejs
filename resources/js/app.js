
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from 'vue-router';

window.Vue.use(VueRouter);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// Vue.component('example-component', require('./components/ExampleComponent.vue'));
// const app = new Vue({
//     el: '#app'
// });

import Home from './components/Home.vue';
import IndexCompanies from './components/companies/IndexCompanies.vue';
import CreateCompany from './components/companies/CreateCompany.vue';
import EditCompany from './components/companies/EditCompany.vue';

const routes = [
    // { path: '/', components: { home: Home } },
    // { path: '/companies', components: { indexCompanies: IndexCompanies } },
    { path: '/', component: Home, name: 'home' },
    { path: '/companies', component: IndexCompanies, name: 'indexCompanies' },
    { path: '/companies/create', component: CreateCompany, name: 'createCompany' },
    { path: '/companies/edit/:id', component: EditCompany, name: 'editCompany' },
];

const router = new VueRouter({ routes });

const app = new Vue({ router }).$mount('#app');
