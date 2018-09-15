import Vue from 'vue'
import VueRouter from 'vue-router'
import store from "./store";

Vue.use(VueRouter);

import Dashboard from './components/Dashboard.vue';

import LoginComponent from './components/auth/LoginComponent.vue';
import LogoutComponent from './components/auth/LogoutComponent.vue';

import Account from './components/account/Activities.vue';
import Activities from './components/account/Activities.vue';

import IndexCompanies from './components/companies/IndexCompanies.vue';
import CreateCompany from './components/companies/CreateCompany.vue';
import EditCompany from './components/companies/EditCompany.vue';

import IndexCustomers from './components/customers/IndexCustomers.vue';
import CreateCustomer from './components/customers/CreateCustomer.vue';
import EditCustomer from './components/customers/EditCustomer.vue';

import IndexEmployees from './components/employees/IndexEmployees.vue';
import CreateEmployee from './components/employees/CreateEmployee.vue';
import EditEmployee from './components/employees/EditEmployee.vue';

import IndexCommodities from './components/commodities/IndexCommodities.vue';
import CreateCommodity from './components/commodities/CreateCommodity.vue';
import EditCommodity from './components/commodities/EditCommodity.vue';

import IndexRoles from './components/roles/IndexRoles.vue';
import CreateRole from './components/roles/CreateRole.vue';
import EditRole from './components/roles/EditRole.vue';

import IndexContracts from './components/contracts/IndexContracts.vue';
import CreateContract from './components/contracts/CreateContract.vue';
import EditContract from './components/contracts/EditContract.vue';

const routes = [
    { path: '/', redirect: { name: 'dashboard' } },
    {
        path: '/auth',
        name: 'auth',
        component: Vue.component( 'Auth', require( './components/Auth.vue' ) ),
        children: [
            { path: '/login', component: LoginComponent, name: 'login' },
            { path: '/logout', component: LogoutComponent, name: 'logout', meta: { requiresAuth: true } },
        ]
    },
    {
        path: '/layout',
        name: 'layout',
        component: Vue.component( 'Layout', require( './components/Layout.vue' ) ),
        meta: { requiresAuth: true },
        children: [
            { path: '/dashboard', component: Dashboard, name: 'dashboard' },

            { path: '/account', component: Account, name: 'account' },
            { path: '/activities', component: Activities, name: 'activities' },

            { path: '/companies', component: IndexCompanies, name: 'indexCompanies' },
            { path: '/companies/create', component: CreateCompany, name: 'createCompany' },
            { path: '/companies/edit/:id', component: EditCompany, name: 'editCompany' },

            { path: '/customers', component: IndexCustomers, name: 'indexCustomers' },
            { path: '/customers/create', component: CreateCustomer, name: 'createCustomer' },
            { path: '/customers/edit/:id', component: EditCustomer, name: 'editCustomer' },

            { path: '/employees', component: IndexEmployees, name: 'indexEmployees' },
            { path: '/employees/create', component: CreateEmployee, name: 'createEmployee' },
            { path: '/employees/edit/:id', component: EditEmployee, name: 'editEmployee' },

            { path: '/commodities', component: IndexCommodities, name: 'indexCommodities' },
            { path: '/commodities/create', component: CreateCommodity, name: 'createCommodity' },
            { path: '/commodities/edit/:id', component: EditCommodity, name: 'editCommodity' },

            { path: '/roles', component: IndexRoles, name: 'indexRoles' },
            { path: '/roles/create', component: CreateRole, name: 'createRole' },
            { path: '/roles/edit/:id', component: EditRole, name: 'editRole' },

            { path: '/contracts', component: IndexContracts, name: 'indexContracts' },
            { path: '/contracts/create', component: CreateContract, name: 'createContract' },
            { path: '/contracts/edit/:id', component: EditContract, name: 'editContract' },
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
