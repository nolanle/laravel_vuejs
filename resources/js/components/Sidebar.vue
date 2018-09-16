<template>
    <div class="side-menu-fixed">
        <div class="scrollarea scrollbar side-menu-bg" style="overflow: hidden;">
            <div class="scrollarea-content saidbar" tabindex="1" style="margin-top: 0px; margin-left: 0px;">
                <div class="saidbar">
                    <ul class="nav navbar-nav side-menu" id="collapsedMenu">
                        <li v-if="isDashboard"><router-link :to="{name: 'dashboard'}"><i class="ti-home"></i> DASHBOARD</router-link></li>
                        
                        <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">LIÊN KẾT NHANH</li>
                        <li v-if="isCreateContract"><router-link :to="{name: 'createContract'}"><i class="ti-write"></i> THÊM HỢP ĐỒNG</router-link></li>
                        <li v-if="isCreateCustomer"><router-link :to="{name: 'createCustomer'}"><i class="ti-user"></i> THÊM KHÁCH HÀNG</router-link></li>
                        <li v-if="isCreateEmployee"><router-link :to="{name: 'createEmployee'}"><i class="ti-wallet"></i> THÊM NHÂN VIÊN</router-link></li>

                        <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">CHỨC NĂNG CHÍNH</li>
                        
                        <li v-if="isIndexCompany || isIndexCommodity">
                            <a href="#companiesCollapse" aria-controls="companiesCollapse" role="button" aria-expanded="false" class="collapsed" data-toggle="collapse">
                                <div class="pull-left"><i class="ti-target"></i><span class="right-nav-text">QL CÔNG TY</span></div>
                                <div class="pull-right"><i class="ti-plus"></i></div>
                                <div class="clearfix"></div>
                            </a>
                            <div class="collapse " id="companiesCollapse">
                                <ul>
                                    <li v-if="isIndexCompany"><router-link :to="{name: 'indexCompanies'}">DS CÔNG TY</router-link></li>
                                    <li v-if="isIndexCommodity"><router-link :to="{name: 'indexCommodities'}">DS HÀNG HÓA</router-link></li>
                                </ul>
                            </div>
                        </li>

                        <li v-if="isIndexRole || isIndexEmployee">
                            <a href="#employeesCollapse" aria-controls="employeesCollapse" role="button" aria-expanded="false" class="collapsed" data-toggle="collapse">
                                <div class="pull-left"><i class="ti-target"></i><span class="right-nav-text">QL NHÂN VIÊN</span></div>
                                <div class="pull-right"><i class="ti-plus"></i></div>
                                <div class="clearfix"></div>
                            </a>
                            <div class="collapse " id="employeesCollapse">
                                <ul>
                                    <li v-if="isIndexRole"><router-link :to="{name: 'indexRoles'}">PHÂN QUYỀN</router-link></li>
                                    <li v-if="isIndexEmployee"><router-link :to="{name: 'indexEmployees'}">DS NHÂN VIÊN</router-link></li>
                                </ul>
                            </div>
                        </li>
                        <li v-if="isIndexCustomer"><router-link :to="{name: 'indexCustomers'}"><i class="ti-target"></i> DS KHÁCH HÀNG</router-link></li>
                        <li v-if="isIndexContract"><router-link :to="{name: 'indexContracts'}"><i class="ti-target"></i> HĐ CẦM ĐỒ</router-link></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Sidebar",
        data: function () {
            return {
                permissions: {},

                isDashboard: false,

                isIndexCompany: false,
                // isCreateCompany: false,
                // isEditCompany: false,
                // isDeleteCompany: false,

                isIndexCommodity: false,
                // isCreateCommodity: false,
                // isEditCommodity: false,
                // isDeleteCommodity: false,

                isIndexRole: false,
                // isCreateRole: false,
                // isEditRole: false,
                // isDeleteRole: false,

                isIndexEmployee: false,
                isCreateEmployee: false,
                // isEditEmployee: false,
                // isDeleteEmployee: false,

                isIndexCustomer: false,
                isCreateCustomer: false,
                // isEditCustomer: false,
                // isDeleteCustomer: false,

                isIndexContract: false,
                isCreateContract: false,
                // isEditContract: false,
                // isPaidContract: false,
                // isRenewContract: false,
                // isLiquidateContract: false,
            }
        },
        mounted() {
            this.checkIsDashboard();
            this.checkIsCreateContract();
            this.checkIsCreateCustomer();
            this.checkIsCreateEmployee();

            this.checkIsIndexCompany();
            this.checkIsIndexCommodity();
            this.checkIsIndexRole();
            this.checkIsIndexEmployee();
            this.checkIsIndexCustomer();
            this.checkIsIndexContract();
        },
        methods: {
            checkIsDashboard() {axios.get('/api/auth/check/permission/' + 'dashboard', {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {this.isDashboard = response.data.access;})},
            checkIsCreateContract() {axios.get('/api/auth/check/permission/' + 'create-contract', {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {this.isCreateContract = response.data.access;})},
            checkIsCreateCustomer() {axios.get('/api/auth/check/permission/' + 'create-customer', {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {this.isCreateCustomer = response.data.access;})},
            checkIsCreateEmployee() {axios.get('/api/auth/check/permission/' + 'create-employee', {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {this.isCreateEmployee = response.data.access;})},

            checkIsIndexCompany() {axios.get('/api/auth/check/permission/' + 'index-company', {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {this.isIndexCompany = response.data.access;})},
            checkIsIndexCommodity() {axios.get('/api/auth/check/permission/' + 'index-commodity', {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {this.isIndexCommodity = response.data.access;})},
            checkIsIndexRole() {axios.get('/api/auth/check/permission/' + 'index-role', {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {this.isIndexRole = response.data.access;})},
            checkIsIndexEmployee() {axios.get('/api/auth/check/permission/' + 'index-employee', {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {this.isIndexEmployee = response.data.access;})},
            checkIsIndexCustomer() {axios.get('/api/auth/check/permission/' + 'index-customer', {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {this.isIndexCustomer = response.data.access;})},
            checkIsIndexContract() {axios.get('/api/auth/check/permission/' + 'index-contract', {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {this.isIndexContract = response.data.access;})},
        }
    }
</script>

<style scoped>

</style>