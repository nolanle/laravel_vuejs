<template>
    <div class="side-menu-fixed">
        <div class="scrollarea scrollbar side-menu-bg" style="overflow: hidden;">
            <div class="scrollarea-content saidbar" tabindex="1" style="margin-top: 0px; margin-left: 0px;">
                <div class="saidbar">
                    <ul class="nav navbar-nav side-menu" id="collapsedMenu">
                        <!--<li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">LIÊN KẾT NHANH</li>-->
                        <li v-if="isCreateContract"><router-link :to="{name: 'createContract'}"><i class="text-success ti-write"></i> THÊM HỢP ĐỒNG</router-link></li>
                        <li v-if="isWarningContracts"><router-link :to="{name: 'warningContracts'}"><i class="text-success ti-bell"></i> THÔNG BÁO</router-link></li>
                        <li><router-link :to="{name: 'activities'}"><i class="text-success ti-reload"></i>NHẬT KÝ HOẠT ĐỘNG</router-link></li>
                        <li><router-link :to="{name: 'indexArises'}"><i class="text-success ti-reload"></i>CHI TIẾT HẰNG NGÀY</router-link></li>
                        <li><router-link :to="{name: 'indexSums'}"><i class="text-success ti-target"></i>TỔNG HỢP THU CHI</router-link></li>
                        <li v-if="isIndexCompany"><router-link :to="{name: 'indexCompanies'}"><i class="text-success ti-target"></i>QL CÔNG TY</router-link></li>
                        <li v-if="isIndexCommodity"><router-link :to="{name: 'indexCommodities'}"><i class="text-success ti-target"></i>QL HÀNG HÓA</router-link></li>
                        <li v-if="isIndexRole"><router-link :to="{name: 'indexRoles'}"><i class="text-success ti-target"></i>PHÂN QUYỀN</router-link></li>
                        <li v-if="isIndexEmployee"><router-link :to="{name: 'indexEmployees'}"><i class="text-success ti-target"></i>NHÂN VIÊN</router-link></li>
                        <li v-if="isIndexCustomer"><router-link :to="{name: 'indexCustomers'}"><i class="text-success ti-target"></i>DS KHÁCH HÀNG</router-link></li>
                        <li v-if="isIndexContract"><router-link :to="{name: 'indexContracts'}"><i class="text-success ti-target"></i>HĐ CẦM ĐỒ</router-link></li>
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
                // isDashboard: false,
                isIndexCompany: false,
                isIndexCommodity: false,
                isIndexRole: false,
                isIndexEmployee: false,
                isCreateEmployee: false,
                isIndexCustomer: false,
                isCreateCustomer: false,
                isIndexContract: false,
                isCreateContract: false,
                isWarningContracts: false,
            }
        },
        mounted() {
            // this.checkIsDashboard();
            this.checkIsCreateContract();
            this.checkIsCreateCustomer();
            this.checkIsCreateEmployee();

            this.checkIsIndexCompany();
            this.checkIsIndexCommodity();
            this.checkIsIndexRole();
            this.checkIsIndexEmployee();
            this.checkIsIndexCustomer();
            this.checkIsIndexContract();
            this.checkIsWarningContracts();
        },
        methods: {
            // checkIsDashboard() {axios.get('/api/auth/check/permission/' + 'dashboard', {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {this.isDashboard = response.data.access;})},
            checkIsCreateContract() {axios.get('/api/auth/check/permission/' + 'create-contract', {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {this.isCreateContract = response.data.access;})},
            checkIsCreateCustomer() {axios.get('/api/auth/check/permission/' + 'create-customer', {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {this.isCreateCustomer = response.data.access;})},
            checkIsCreateEmployee() {axios.get('/api/auth/check/permission/' + 'create-employee', {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {this.isCreateEmployee = response.data.access;})},

            checkIsIndexCompany() {axios.get('/api/auth/check/permission/' + 'index-company', {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {this.isIndexCompany = response.data.access;})},
            checkIsIndexCommodity() {axios.get('/api/auth/check/permission/' + 'index-commodity', {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {this.isIndexCommodity = response.data.access;})},
            checkIsIndexRole() {axios.get('/api/auth/check/permission/' + 'index-role', {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {this.isIndexRole = response.data.access;})},
            checkIsIndexEmployee() {axios.get('/api/auth/check/permission/' + 'index-employee', {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {this.isIndexEmployee = response.data.access;})},
            checkIsIndexCustomer() {axios.get('/api/auth/check/permission/' + 'index-customer', {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {this.isIndexCustomer = response.data.access;})},
            checkIsIndexContract() {axios.get('/api/auth/check/permission/' + 'index-contract', {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {this.isIndexContract = response.data.access;})},
            checkIsWarningContracts() {axios.get('/api/auth/check/permission/' + 'warning-contract', {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {this.isWarningContracts = response.data.access;})},
        }
    }
</script>

<style scoped>

</style>