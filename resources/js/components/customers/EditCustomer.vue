<template>
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mb-0">Chỉnh Sửa Khách Hàng</h4>
                    <div class="delete-button"></div>
                </div>
                <div class="col-sm-6">
                    <nav class="float-left float-sm-right" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}"><i class="ti-home"></i> Dashboard</router-link></li>
                            <li class="breadcrumb-item"><router-link :to="{name: 'indexCustomers'}">Danh Sách Khách Hàng</router-link></li>
                            <li class="breadcrumb-item active" aria-current="page">Chỉnh Sửa Khách Hàng</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card-statistics mb-30 card">
            <div class="card-body">
                <h5 class="card-title"><span>Chỉnh Sửa Khách Hàng</span></h5>
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <form v-on:submit="updateForm()">

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="name">Tên Khách Hàng <span class="text-danger">(*)</span></label>
                                    <input v-model="customer.fullname" type="text" id="name" class="form-control" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone">Số Điện Thoại</label>
                                <input v-model="customer.phone" type="text" id="phone" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label for="address">Địa Chỉ</label>
                                <input v-model="customer.address" type="text" id="address" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label for="government_id">CMND</label>
                                <input v-model="customer.government_id" type="text" id="government_id" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label for="company_id">Công Ty <span class="text-danger">(*)</span></label>
                                <select v-model="customer.company_id" id="company_id" class="form-control">
                                    <option v-for="company in companies" v-bind:value="company.id">{{ company.name }}</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="activated">Trạng Thái <span class="text-danger">(*)</span></label>
                                <div class="pull-right">
                                    <switches v-model="customer.activated" id="activated" theme="bootstrap" color="success"></switches>
                                </div>
                            </div>

                            <div class="pull-right">
                                <!--<router-link :to="{name: 'indexCustomers'}" class="btn btn-secondary">-->
                                    <!--<i class="fa fa-arrow-left"></i>-->
                                    <!--<span>QUAY LẠI</span>-->
                                <!--</router-link>-->
                                <button @click="$router.go(-1)" type="button" class="btn btn-secondary"><i class="fa fa-arrow-left"></i><span> QUAY LẠI</span></button>
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
        name: "EditCustomer",
        data: function () {
            return {
                customerId: null,
                customer: { fullname: '', address: '', phone: '', government_id: '', activated: 0, company_id: 0 },
                companies: {},
            }
        },
        mounted() {
            this.customerId = this.$route.params.id;
            this.getCompanies();
            this.getCustomer();
        },
        methods: {
            getCustomer() {
                let app = this;
                axios.get('/api/v1/customers/' + app.customerId, {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                }).then(response => {
                    app.customer = response.data;
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
                axios.patch('/api/v1/customers/' + app.customer.id, app.customer, {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }

                }).then(function (response) {
                    app.$swal({
                        type: 'success',
                        title: 'Cập nhật thành công?',
                        text: "Cập nhật thông tin khách hàng thành công!",
                        confirmButtonColor: '#3085d6',
                    }).then((result) => {
                        if (result.value) {
                            app.$router.replace('/customers');
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