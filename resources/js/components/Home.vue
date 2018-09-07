<template>
    <div>
        <router-link :to="{name: 'indexCompanies'}" class="btn btn-success">Companies</router-link>
        <!--<router-link to="/companies" class="btn btn-success">Companies</router-link>-->
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        name: "Home"
    }
</script>

<style scoped>

</style>