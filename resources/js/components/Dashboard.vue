<template>
    <div></div>
</template>

<script>
    export default {
        name: "Dashboard",
        mounted() {
            this.$router.push({name: 'warningContracts'});
        }
    }
</script>
