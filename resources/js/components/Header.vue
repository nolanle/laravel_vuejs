<template>
    <nav class="admin-header navbar navbar-default col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-left navbar-brand-wrapper">
            <router-link :to="{name: 'dashboard'}" :class="'navbar-brand brand-logo'"><img :src="'images/logo.png'"/></router-link>
            <router-link :to="{name: 'dashboard'}" :class="'navbar-brand brand-logo-mini'"><img :src="'images/logo-icon-dark.png'"/></router-link>
        </div>

        <!-- Top bar left -->
        <ul class="nav navbar-nav mr-auto">
            <li class="nav-item"><a class="button-toggle-nav inline-block ml-20 pull-left"><i class="zmdi zmdi-menu ti-align-right"></i></a></li>
        </ul>

        <!-- top bar right -->
        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item dropdown mr-30">
                <a class="nav-link nav-pill user-avatar" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img :src="user.avatar" alt="avatar" />
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header">
                        <div class="media">
                            <div class="media-body">
                                <h5 class="mt-0 mb-0">{{ user.name }}</h5><span>{{ user.email }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <router-link :to="{name: 'activities'}" :class="'dropdown-item'"><i class="text-secondary ti-reload"></i>Hoạt động</router-link>
                    <!--<a class="dropdown-item" href="#"><i class="text-success ti-email"></i>Messages</a>-->
                    <a class="dropdown-item" href="#"><i class="text-warning ti-user"></i>Hồ sơ</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"><i class="text-info ti-settings"></i>Cài đặt</a>
                    <router-link :to="{name: 'logout'}" class="dropdown-item"><i class="text-danger ti-unlock"></i>Đăng xuất</router-link>
                </div>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        name: "Header",
        data: function () {
            return {
                user: { id: '', name: '', email: '' },
            }
        },
        mounted() { this.getResults(); },
        methods: {
            getResults(page = 1) {
                let app = this;
                axios.get('/api/auth/me', {
                    headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}
                }).then(response => {
                    app.user = response.data;
                });
            },
        }
    }
</script>

<style scoped>

</style>