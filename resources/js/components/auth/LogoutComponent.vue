<template>

</template>

<script>
    import store from '../../store'
    export default {
        data() { return { token: '' } },
        mounted () {
            let app = this;
            app.token = localStorage.getItem('token');

            //console.log(app.token);
            localStorage.removeItem('token');
            store.commit('logoutUser');

            axios.post('/api/auth/logout', {}, {
                headers: { Authorization: 'Bearer ' + app.token }
            }).then(response => {

            }).catch(error => {
                app.$swal({
                    type: 'error',
                    title: 'Đăng xuất thất bại!',
                    text: 'Lỗi hệ thống ' + error + ', vui lòng thử lại sau.'
                });
            });

            app.$router.push({ name: 'login' });

        },

    }
</script>