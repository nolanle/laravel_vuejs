<template>
    <div class="card search-customer">
        <div class="card-body">
            <a href="javascript:;"><strong>{{ item.fullname }}</strong></a>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SearchCustomer",
        props: {
            item: { required: true },
            searchText: { required: true }
        }
    }
</script>

<style scoped>
    .search-customer {
        z-index: 10;
    }
</style>