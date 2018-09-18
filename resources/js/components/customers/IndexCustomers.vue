<template>
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mb-0">Danh Sách Khách Hàng</h4>
                    <div class="delete-button"></div>
                </div>
                <div class="col-sm-6">
                    <nav class="float-left float-sm-right" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}"><i class="ti-home"></i> Dashboard</router-link></li>
                            <li class="breadcrumb-item active" aria-current="page">Danh Sách Khách Hàng</li>
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
                                        <router-link v-if="isCreateCustomer" :to="{name: 'createCustomer'}" class="btn btn-success"><i class="fa fa-plus"></i> THÊM MỚI</router-link>
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group form-group-sm react-bs-table-search-form">
                                        <input placeholder="Tìm kiếm công ty" class="form-control" type="text"><span class="input-group-btn"></span>
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
                                        <th>TÊN KHÁCH HÀNG</th>
                                        <th>ĐỊA CHỈ</th>
                                        <th>ĐIỆN THOẠI</th>
                                        <th>SỐ CMND</th>
                                        <th>NGÀY CẤP</th>
                                        <th>NƠI CẤP</th>
                                        <th>NGÀY TẠO</th>
                                        <th>TRẠNG THÁI</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(customer, index) in customers.data">
                                        <td>{{ index + 1 }}</td>
                                        <td>
                                            <router-link v-if="isEditCustomer" :to="{name: 'editCustomer', params: {id: customer.id}}" :class="'btn btn-xs btn-default'">
                                                <span :class="'text-success'"><strong>{{ customer.fullname }}</strong></span>
                                            </router-link>
                                            <span v-else>{{ customer.fullname }}</span>
                                        </td>
                                        <td>{{ customer.address }}</td>
                                        <td>{{ customer.phone }}</td>
                                        <td>{{ customer.government_id }}</td>
                                        <td>{{ customer.issued_date | moment("D/M/Y") }}</td>
                                        <td>{{ customer.issued_at }}</td>
                                        <td>{{ customer.created_at | moment("D/M/Y") }}</td>
                                        <td><switches v-model="customer.activated" theme="bootstrap" color="success" disabled></switches></td>
                                        <td><a v-if="isDeleteCustomer" href="javascript:;" class="btn btn-xs btn-danger" v-on:click="deleteEntry(customer.id, index)"><i class="fa fa-trash"></i></a></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="react-bs-table-pagination">
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-4 col-xs-4 col-sm-4 col-lg-4 offset-4">
                                    <pagination :data="customers" @pagination-change-page="getResults"></pagination>
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
        name: "IndexCustomers",
        data: function () {
            return {
                // checking
                isCreateCustomer: false,
                isEditCustomer: false,
                isDeleteCustomer: false,

                page: 1,
                customers: {}
            }
        },
        mounted() {
            this.getResults();

            // check permissions
            this.checkIsCreateCustomer();
            this.checkIsEditCustomer();
            this.checkIsDeleteCustomer();
        },
        methods: {
            checkIsCreateCustomer() {
                axios.get('/api/auth/check/permission/' + 'create-customer', {
                    headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}
                }).then(response => {
                    this.isCreateCustomer = response.data.access;
                })
            },
            checkIsEditCustomer() {
                axios.get('/api/auth/check/permission/' + 'edit-customer', {
                    headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}
                }).then(response => {
                    this.isEditCustomer = response.data.access;
                })
            },
            checkIsDeleteCustomer() {
                axios.get('/api/auth/check/permission/' + 'delete-customer', {
                    headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}
                }).then(response => {
                    this.isDeleteCustomer = response.data.access;
                })
            },

            getResults(page = 1) {
                let app = this;
                app.page = page;
                axios.get('/api/v1/customers?page=' + page, {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                }).then(response => {
                    // console.log(response.data.data);
                    app.customers = response.data;
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
                        axios.delete('/api/v1/customers/' + id, {
                            headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                        }).then(function (response) {
                            app.getResults(app.page);
                            app.$swal({
                                type: 'success',
                                title: 'Đã xóa thành công!',
                                text: 'Khách hàng đã bị xóa khỏi hệ thống.'
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