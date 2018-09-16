<template>
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mb-0">Chỉnh Sửa Nhân Viên</h4>
                    <div class="delete-button"></div>
                </div>
                <div class="col-sm-6">
                    <nav class="float-left float-sm-right" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}"><i class="ti-home"></i> Dashboard</router-link></li>
                            <li class="breadcrumb-item"><router-link :to="{name: 'indexEmployees'}">Danh Sách Nhân Viên</router-link></li>
                            <li class="breadcrumb-item active" aria-current="page">Chỉnh Sửa Nhân Viên</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card-statistics mb-30 card">
            <div class="card-body">
                <h5 class="card-title"><span>Chỉnh Sửa NV: #{{ employee.name }}</span></h5>
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <form v-on:submit="updateForm()">

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="username">Tên Đăng Nhập <span class="text-danger">(*)</span></label>
                                    <input v-model="employee.username" type="text" id="username" class="form-control" placeholder="Vd: tranlythong123" required />
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="password">Mật Khẩu</label>
                                    <input v-model="employee.password" type="text" id="password" class="form-control" />
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="password_confirm">Nhập Lại Mật Khẩu</label>
                                    <input v-model="employee.password_confirm" type="text" id="password_confirm" class="form-control" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="name">Họ Và Tên <span class="text-danger">(*)</span></label>
                                <input v-model="employee.name" type="text" id="name" class="form-control" placeholder="Vd: Trần Văn A" required />
                            </div>

                            <div class="form-group">
                                <label for="email">Địa Chỉ Email <span class="text-danger">(*)</span></label>
                                <input v-model="employee.email" type="text" id="email" class="form-control" placeholder="Vd: tran***@example.com" required />
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="company_id">Thuộc Công Ty <span class="text-danger">(*)</span></label>
                                    <select v-model="employee.company_id" id="company_id" class="form-control">
                                        <option v-for="company in companies" v-bind:value="company.id">{{ company.name }}</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="role">Vai Trò <span class="text-danger">(*)</span></label>
                                    <select v-model="employee.role" id="role" class="form-control">
                                        <option v-for="role in roles" v-bind:value="role.name">{{ role.display_name }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="activated">Trạng Thái <span class="text-danger">(*)</span></label>
                                <span class="form-control">
                                    <switches v-model="employee.activated" id="activated" theme="bootstrap" color="success"></switches>
                                </span>
                            </div>

                            <div class="pull-right">
                                <router-link :to="{name: 'indexEmployees'}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i>
                                    <span>QUAY LẠI</span>
                                </router-link>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-edit"></i>
                                    <span>LƯU THAY ĐỔI</span>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "EditEmployee",
        data: function () {
            return {
                employeeId: null,
                employee: { name: '', username: '', email: '', password: '', password_confirm: '', company_id: 1, activated: 1, role: '' },
                companies: {}, roles: {},
            }
        },
        mounted() {
            this.employeeId = this.$route.params.id;
            this.getRoles();
            this.getCompanies();
            this.getEmployee();
        },
        methods: {
            getEmployee() {
                let app = this;
                axios.get('/api/v1/employees/' + app.employeeId, {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                }).then(response => {
                    app.employee = response.data;
                });
            },
            getRoles() {
                axios.get('/api/v1/roles-without-paginate', {
                    headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}
                }).then(response => {
                    this.roles = response.data;
                });
            },
            getCompanies() {
                axios.get('/api/v1/companies-without-paginate', {
                    headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}
                }).then(response => {
                    this.companies = response.data;
                });
            },
            updateForm() {
                let app = this;
                event.preventDefault();
                axios.patch('/api/v1/employees/' + app.employeeId, app.employee, {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }

                }).then(function (response) {
                    app.$swal({
                        type: 'success',
                        title: 'Cập nhật thành công?',
                        text: "Cập nhật thông tin nhân viên thành công!",
                        confirmButtonColor: '#3085d6',
                    }).then((result) => {
                        if (result.value) {
                            app.$router.replace('/employees');
                        } else {
                            app.$swal({
                                type: 'error',
                                title: 'Cập nhật thất bại!',
                                text: 'Lỗi hệ thống, vui lòng thử lại sau.'
                            });
                        }
                    });

                }).catch(function (error) {
                    app.$swal({
                        type: 'error',
                        title: 'Cập nhật thất bại!',
                        text: 'Lỗi hệ thống ' + error + ', vui lòng thử lại sau.'
                    });

                });
            }
        }
    }
</script>

<style scoped>

</style>