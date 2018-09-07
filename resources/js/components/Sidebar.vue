<template>
    <div class="side-menu-fixed">
        <div class="scrollarea scrollbar side-menu-bg" style="overflow: hidden;">
            <div class="scrollarea-content saidbar" tabindex="1" style="margin-top: 0px; margin-left: 0px;">
                <div class="saidbar">
                    <ul class="nav navbar-nav side-menu" id="collapsedMenu">
                        <li><router-link :to="{name: 'dashboard'}"><i class="ti-home"></i> DASHBOARD</router-link></li>
                        <li class="mt-10 mb-10 text-muted pl-4 font-medium menu-title">CHỨC NĂNG CHÍNH</li>
                        <li><router-link :to="{name: 'indexCompanies'}"><i class="ti-palette"></i> DANH SÁCH CÔNG TY</router-link></li>
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