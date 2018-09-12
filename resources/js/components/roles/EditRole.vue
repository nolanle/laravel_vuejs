<template>
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mb-0">Chỉnh Sửa Quyền</h4>
                    <div class="delete-button"></div>
                </div>
                <div class="col-sm-6">
                    <nav class="float-left float-sm-right" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}"><i class="ti-home"></i> Dashboard</router-link></li>
                        <li class="breadcrumb-item"><router-link :to="{name: 'indexRoles'}">Phân Quyền</router-link></li>
                            <li class="breadcrumb-item active" aria-current="page">Chỉnh Sửa Quyền</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card-statistics mb-30 card">
            <div class="card-body">
                <h5 class="card-title"><span>Chỉnh sửa: {{ role.display_name }}</span></h5>
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <form v-on:submit="updateForm()">

                            <div class="form-group">
                                <label for="display_name">Tên Hiển Thị <span class="text-danger">(*)</span></label>
                                <input v-model="role.display_name" id="display_name" type="text" class="form-control" required />
                            </div>

                            <div class="form-group">
                                <label for="display_name">Mô Tả Quyền</label>
                                <textarea-autosize v-model="role.description" :min-height="180" ref="description" :class="'form-control'"></textarea-autosize>
                            </div>
                            <hr>

                            <div class="pull-right">
                                <router-link :to="{name: 'indexRoles'}" class="btn btn-secondary">
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
        name: "EditRole",
        data: function () {
            return { roleId: '', role: { display_name: '', description: '' } }
        },
        mounted() {
            this.roleId = this.$route.params.id;
            this.getRole();
        },
        methods: {
            getRole() {
                let app = this;
                axios.get('/api/v1/roles/' + app.roleId, {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                }).then(response => {
                    app.role = response.data;
                });
            },
            updateForm() {
                let app = this;
                event.preventDefault();

                axios.patch('/api/v1/roles/' + app.roleId, app.role, {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                }).then(function (response) {

                    app.$swal({
                        type: 'success',
                        title: 'Cập nhật thành công?',
                        text: "Cập nhật thông tin phân quyền thành công!",
                        confirmButtonColor: '#3085d6',
                    }).then((result) => {
                        if (result.value) {
                            app.$router.replace('/roles');
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
        },
    }
</script>

<style scoped>

</style>