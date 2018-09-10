import Vue from 'vue'
import VueRouter from 'vue-router'
import store from "./store";

Vue.use(VueRouter);

import Dashboard from './components/Dashboard.vue';

import LoginComponent from './components/auth/LoginComponent.vue';
import LogoutComponent from './components/auth/LogoutComponent.vue';

import Activities from './components/account/Activities.vue';

import IndexCompanies from './components/companies/IndexCompanies.vue';
import CreateCompany from './components/companies/CreateCompany.vue';
import EditCompany from './components/companies/EditCompany.vue';

import IndexCustomers from './components/customers/IndexCustomers.vue';
import CreateCustomer from './components/customers/CreateCustomer.vue';
import EditCustomer from './components/customers/EditCustomer.vue';

const routes = [
    { path: '/', redirect: { name: 'dashboard' } },
    {
        path: '/auth',
        name: 'auth',
        component: Vue.component( 'Auth', require( './components/Auth.vue' ) ),
        children: [
            { path: '/login', component: LoginComponent, name: 'login' },
            { path: '/logout', component: LogoutComponent, name: 'logout' },
        ]
    },
    {
        path: '/layout',
        name: 'layout',
        component: Vue.component( 'Layout', require( './components/Layout.vue' ) ),
        children: [
            { path: '/dashboard', component: Dashboard, name: 'dashboard', meta: { requiresAuth: true } },

            { path: '/activities', component: Activities, name: 'activities', meta: { requiresAuth: true } },

            { path: '/companies', component: IndexCompanies, name: 'indexCompanies', meta: { requiresAuth: true } },
            { path: '/companies/create', component: CreateCompany, name: 'createCompany', meta: { requiresAuth: true } },
            { path: '/companies/edit/:id', component: EditCompany, name: 'editCompany', meta: { requiresAuth: true } },

            { path: '/customers', component: IndexCustomers, name: 'indexCustomers', meta: { requiresAuth: true } },
            { path: '/customers/create', component: CreateCustomer, name: 'createCustomer', meta: { requiresAuth: true } },
            { path: '/customers/edit/:id', component: EditCustomer, name: 'editCustomer', meta: { requiresAuth: true } },

        ]
    }

];

const router = new VueRouter({ routes });

router.beforeEach((to, from, next) => {

    // check if the route requires authentication and user is not logged in
    if (to.matched.some(route => route.meta.requiresAuth) && !store.state.isLoggedIn) {
        // redirect to login page
        next({ name: 'login' });
        return
    }

    // if logged in redirect to dashboard
    if(to.path === '/login' && store.state.isLoggedIn) {
        next({ name: 'dashboard' });
        return
    }

    let token = localStorage.getItem('token');
    if (token) {
        axios.get('/api/auth/me', {
            headers: { Authorization: 'Bearer ' + token }
        }).then(response => {}).catch(error => {

            localStorage.removeItem('token');
            store.commit('logoutUser');

            next({ name: 'login' });
        });
    }

    next();
});

export default router
