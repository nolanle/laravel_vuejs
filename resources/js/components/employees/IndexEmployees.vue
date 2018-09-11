<template>
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mb-0">Danh Sách Nhân Viên</h4>
                    <div class="delete-button"></div>
                </div>
                <div class="col-sm-6">
                    <nav class="float-left float-sm-right" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}"><i class="ti-home"></i> Dashboard</router-link></li>
                            <li class="breadcrumb-item active" aria-current="page">Danh Sách Nhân Viên</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="mb-30 col-xl-12">
                <div class="card-statistics h-100 card">
                    <div class="card-body react-bs-table-container">

                        <div class="react-bs-table-tool-bar ">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-8">
                                    <div class="btn-group" role="group">
                                        <router-link :to="{name: 'createEmployee'}" class="btn btn-success"><i class="fa fa-plus"></i> THÊM MỚI</router-link>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group form-group-sm react-bs-table-search-form">
                                        <input placeholder="Tìm kiếm nhân viên" class="form-control" type="text"><span class="input-group-btn"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="react-bs-table react-bs-table-bordered">
                            <div class="react-bs-container-body">
                                <table class="table table-striped table-bordered table-hover table-condensed">
                                    <thead>
                                    <tr>
                                        <th class="align-content-center">STT</th>
                                        <th>HỌ VÀ TÊN</th>
                                        <th>TÊN ĐĂNG NHẬP</th>
                                        <th>EMAIL</th>
                                        <th>CÔNG TY</th>
                                        <th>NGÀY TẠO</th>
                                        <th>TRẠNG THÁI</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="employee, index in employees.data">
                                        <td>{{ index + 1 }}</td>
                                        <td><router-link :to="{name: 'editEmployee', params: {id: employee.id}}" :class="'btn btn-xs btn-default'">
                                            <span :class="'text-success'"><strong>{{ employee.name }}</strong></span>
                                        </router-link></td>
                                        <td>{{ employee.username }}</td>
                                        <td>{{ employee.email }}</td>
                                        <td>{{ employee.company_id }}</td>
                                        <td>{{ employee.created_at | moment("D/M/Y") }}</td>
                                        <td><switches v-model="employee.activated" theme="bootstrap" color="success" disabled></switches></td>
                                        <td><a href="#" class="btn btn-xs btn-danger" v-on:click="deleteEntry(employee.id, index)"><i class="fa fa-trash"></i></a></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="react-bs-table-pagination">
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-4 col-xs-4 col-sm-4 col-lg-4 offset-4">
                                    <!--<pagination :data="employees" @pagination-change-page="getResults"></pagination>-->
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "IndexEmployees",
        data: function () {
            return {
                page: 1,
                employees: {}
            }
        },
        mounted() { this.getResults(); },
        methods: {
            getResults(page = 1) {
                let app = this;
                app.page = page;
                axios.get('/api/v1/employees?page=' + page, {
                    headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}
                }).then(response => {
                    // console.log(response.data.data);
                    app.employees = response.data;
                });
            },
            deleteEntry(id, index) {
                var app = this;
                this.$swal({
                    type: 'warning',
                    title: 'Bạn có chắc xóa?',
                    text: "Hành động này không thể hoàn tác, vui lòng xác nhận!",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Chắc chắn, xóa luôn đi!',
                    cancelButtonText: '<i class="fa fa-ban"></i> Hủy bỏ',
                }).then((result) => {
                    if (result.value) {
                        axios.delete('/api/v1/employees/' + id, {
                            headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                        }).then(function (response) {
                            app.getResults(app.page);
                            app.$swal({
                                type: 'success',
                                title: 'Đã xóa thành công!',
                                text: 'Nhân viên đã bị xóa khỏi hệ thống.'
                            });
                        }).catch(function (error) {
                            app.$swal({
                                type: 'error',
                                title: 'Xóa thất bại!',
                                text: 'Lỗi hệ thống ' + error + ', vui lòng thử lại sau.'
                            });
                        });
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>