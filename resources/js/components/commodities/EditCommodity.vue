<template>
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mb-0">Chỉnh Sửa Hàng Hóa</h4>
                    <div class="delete-button"></div>
                </div>
                <div class="col-sm-6">
                    <nav class="float-left float-sm-right" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}"><i class="ti-home"></i> Dashboard</router-link></li>
                            <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}">Danh Sách Hàng Hóa</router-link></li>
                            <li class="breadcrumb-item active" aria-current="page">Chỉnh Sửa Hàng Hóa</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card-statistics mb-30 card">
            <div class="card-body">
                <h5 class="card-title"><span>Chỉnh sửa {{ commodity.name }}</span></h5>
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <form v-on:submit="updateForm()">

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="name">Tên Hàng Hóa <span class="text-danger">(*)</span></label>
                                    <input v-model="commodity.name" type="text" id="name" class="form-control" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="code">Mã Hàng Hóa <span class="text-danger">(*)</span></label>
                                    <input v-model="commodity.code" type="text" id="code" class="form-control" />
                                </div>
                            </div>
                            <hr>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="mortgage_amount">Số Tiền Cầm <span class="text-danger">(*)</span></label>
                                    <input v-model="commodity.mortgage_amount" type="text" id="mortgage_amount" class="form-control" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label><span class="text-danger">(*)</span></label>
                                    <span class="form-control">
                                        <p-check v-model="commodity.interest_before_mortgage" class="p-svg p-plain">
                                            <img slot="extra" class="svg" :src="'svg/task.svg'">Thu Lãi Trước
                                        </p-check>
                                    </span>
                                </div>
                            </div>
                            <hr>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="interest_by_date">Lãi Ngày <span class="text-danger">(*)</span></label>
                                    <input v-model="commodity.interest_by_date" type="text" id="interest_by_date" class="form-control" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="interest_period">Kỳ Lãi <span class="text-danger">(*)</span></label>
                                    <input v-model="commodity.interest_period" type="text" id="interest_period" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="days_of_delayed">Thanh Lý Sau <span class="text-danger">(*)</span></label>
                                <input v-model="commodity.days_of_delayed" type="text" id="days_of_delayed" class="form-control" />
                            </div>
                            <hr>

                            <div class="form-group">
                                <label for="activated">Trạng Thái <span class="text-danger">(*)</span></label>
                                <span class="form-control">
                                    <switches v-model="commodity.activated" id="activated" theme="bootstrap" color="success"></switches>
                                </span>
                            </div>

                            <div class="pull-right">
                                <router-link :to="{name: 'indexCommodities'}" class="btn btn-secondary">
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
        name: "EditCommodity",
        data: function () {
            return {
                commodityId: '',
                commodity: {
                    name: '', code: '',
                    mortgage_amount: 0,
                    interest_before_mortgage: 0,
                    interest_by_date: 0,
                    interest_period: 0,
                    days_of_delayed: 0,
                    activated: 0,
                },
            }
        },
        mounted() {
            this.companyId = this.$route.params.id;
            this.getCommodity();
        },
        methods: {
            interestBeforeMortgageChange() {
                this.commodity.interest_before_mortgage = !this.commodity.interest_before_mortgage;
            },
            getCommodity() {
                let app = this;
                axios.get('/api/v1/commodities/' + app.companyId, {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                }).then(response => {
                    app.commodity = response.data;
                });
            },
            updateForm() {
                let app = this;
                event.preventDefault();
                axios.patch('/api/v1/commodities/' + app.commodity.id, app.commodity, {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                }).then(function (response) {

                    app.$swal({
                        type: 'success',
                        title: 'Cập nhật thành công?',
                        text: "Cập nhật thông tin hàng hóa thành công!",
                        confirmButtonColor: '#3085d6',
                    }).then((result) => {
                        if (result.value) {
                            app.$router.replace('/commodities');
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