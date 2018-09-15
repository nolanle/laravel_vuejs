<template>
    <div class="side-menu-fixed">
        <div class="scrollarea scrollbar side-menu-bg" style="overflow: hidden;">
            <div class="scrollarea-content saidbar" tabindex="1" style="margin-top: 0px; margin-left: 0px;">
                <div class="saidbar">
                    <ul class="nav navbar-nav side-menu" id="collapsedMenu">
                        <li><router-link :to="{name: 'dashboard'}"><i class="ti-home"></i> DASHBOARD</router-link></li>
                        <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">LIÊN KẾT NHANH</li>
                        <li><router-link :to="{name: 'createContract'}"><i class="ti-write"></i> THÊM HỢP ĐỒNG</router-link></li>
                        <li><router-link :to="{name: 'createCustomer'}"><i class="ti-user"></i> THÊM KHÁCH HÀNG</router-link></li>
                        <li><router-link :to="{name: 'createEmployee'}"><i class="ti-wallet"></i> THÊM NHÂN VIÊN</router-link></li>

                        <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">CHỨC NĂNG CHÍNH</li>
                        <li>
                            <a href="#companiesCollapse" aria-controls="companiesCollapse" role="button" aria-expanded="false" class="collapsed" data-toggle="collapse">
                                <div class="pull-left"><i class="ti-target"></i><span class="right-nav-text">QL CÔNG TY</span></div>
                                <div class="pull-right"><i class="ti-plus"></i></div>
                                <div class="clearfix"></div>
                            </a>
                            <div class="collapse " id="companiesCollapse">
                                <ul>
                                    <li><router-link :to="{name: 'indexCompanies'}">DS CÔNG TY</router-link></li>
                                    <li><router-link :to="{name: 'indexCommodities'}">DS HÀNG HÓA</router-link></li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#employeesCollapse" aria-controls="employeesCollapse" role="button" aria-expanded="false" class="collapsed" data-toggle="collapse">
                                <div class="pull-left"><i class="ti-target"></i><span class="right-nav-text">QL NHÂN VIÊN</span></div>
                                <div class="pull-right"><i class="ti-plus"></i></div>
                                <div class="clearfix"></div>
                            </a>
                            <div class="collapse " id="employeesCollapse">
                                <ul>
                                    <li><router-link :to="{name: 'indexRoles'}">PHÂN QUYỀN</router-link></li>
                                    <li><router-link :to="{name: 'indexEmployees'}">DS NHÂN VIÊN</router-link></li>
                                </ul>
                            </div>
                        </li>
                        <li><router-link :to="{name: 'indexCustomers'}"><i class="ti-target"></i> DS KHÁCH HÀNG</router-link></li>
                        <li><router-link :to="{name: 'indexContracts'}"><i class="ti-target"></i> HĐ CẦM ĐỒ</router-link></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Sidebar"
    }
</script>

<style scoped>

</style>