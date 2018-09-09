<template>
    <section class="height-100vh d-flex align-items-center page-section-ptb login">
        <div class="container">
            <div class="justify-content-center no-gutters vertical-align row">

                <div class="login-fancy-bg bg col-md-6 col-lg-4">
                    <div class="login-fancy">
                        <h2 class="text-white mb-20">Cầm Đồ Cà Mau</h2>
                        <p class="mb-20 text-white">Chào mừng đến với hệ thống quản lý cầm đồ cà mau.</p>
                        <ul class="list-unstyled  pos-bot pb-30">
                            <li class="list-inline-item"><a class="text-white" href="#">Điều khoản dịch vụ</a> </li>
                            <li class="list-inline-item"><a class="text-white" href="#">Chính sách bảo mật</a></li>
                        </ul>
                    </div>
                </div>

                <div class="bg-white col-md-6 col-lg-4">
                    <div class="login-fancy pb-40 clearfix">
                        <h3 class="mb-30">Đăng nhập vào Cầm Đồ Cà Mau</h3>

                        <form v-on:submit.prevent="submitLogin">
                            <div class="section-field mb-20">
                                <label class="mb-10" for="email">Địa chỉ email <span class="text-danger">(*)</span></label>
                                <input v-model="email" id="email" class="web form-control" type="text" placeholder="Ex: user01@example.com" required autofocus />
                            </div>

                            <div class="section-field mb-20">
                                <label class="mb-10" for="Password">Mật khẩu <span class="text-danger">(*)</span></label>
                                <input v-model="password" id="password" class="web form-control" type="password" placeholder="Ex: 12345678@Ab" required />
                            </div>

                            <button class="button button-login">
                                <i class="fa fa-check text-white"></i>
                                <span class="text-white">ĐĂNG NHẬP</span>
                            </button>
                            <p class="mt-15 mb-0 remember-checkbox">Chưa có tài khoản? <a href="#">Tạo tài khoản mới</a></p>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </section>
</template>

<script>
    import store from '../../store';

    export default {
        name: "LoginComponent",
        data() {
            return {
                email: '',
                password: '',
                loginError: false,
            }
        },
        methods: {
            submitLogin() {
                this.loginError = false;
                axios.post('/api/auth/login', {
                    email: this.email,
                    password: this.password
                }).then(response => {
                    // login user, store the token and redirect to dashboard
                    store.commit('loginUser');
                    localStorage.setItem('token', response.data.access_token)
                    this.$router.push({ name: 'dashboard' })
                }).catch(error => {
                    this.loginError = true
                });
            }
        }
    }
</script>

<style scoped>

</style>