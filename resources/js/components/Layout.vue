<template>
    <div>
        <header-component></header-component>

        <div class="container-fluid">
            <div class="row">
                <sidebar></sidebar>

                <div class="content-wrapper">

                    <router-view></router-view>

                    <footer-component></footer-component>

                </div> <!-- /content-wrapper -->

            </div> <!-- /row -->

        </div>
    </div>
</template>

<script>
    export default {
        name: "Layout"
    }
</script>

<style scoped>

</style>