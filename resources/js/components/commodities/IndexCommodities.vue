<template>
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mb-0">Danh Sách Hàng Hóa</h4>
                    <div class="delete-button"></div>
                </div>
                <div class="col-sm-6">
                    <nav class="float-left float-sm-right" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}"><i class="ti-home"></i> Dashboard</router-link></li>
                            <li class="breadcrumb-item active" aria-current="page">Danh Sách Hàng Hóa</li>
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
                                        <router-link :to="{name: 'createCommodity'}" class="btn btn-success">
                                            <span><i class="fa fa-plus"></i> THÊM MỚI</span>
                                        </router-link>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group form-group-sm react-bs-table-search-form">
                                        <input placeholder="Tìm kiếm công ty" class="form-control" type="text"><span class="input-group-btn"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="react-bs-table react-bs-table-bordered" style="height: 100%;">
                            <div class="react-bs-container-body" style="height: 100%;">
                                <table class="table table-striped table-bordered table-hover table-condensed">
                                    <thead>
                                    <tr>
                                        <th>TÊN (MÃ)</th>
                                        <th>TIỀN CẦM</th>
                                        <th>LÃI SUẤT</th>
                                        <th>KỲ LÃI</th>
                                        <th>THANH LÝ SAU</th>
                                        <th>LÃI TRƯỚC</th>
                                        <th>TRẠNG THÁI</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="commodity, index in commodities.data">
                                        <td>
                                            <router-link :to="{name: 'editCommodity', params: {id: commodity.id}}">
                                                <span :class="'text-success'"><strong>{{ commodity.name }} ({{ commodity.code }})</strong></span>
                                            </router-link>
                                        </td>
                                        <td>{{ commodity.mortgage_amount | currency }}</td>
                                        <td>{{ commodity.interest_by_date | currency }} /1triệu/ngày</td>
                                        <td>{{ commodity.interest_period }} ngày</td>
                                        <td>{{ commodity.days_of_delayed }} ngày quá hạn</td>
                                        <td>
                                            <p-check class="p-svg p-plain" v-model="commodity.interest_before_mortgage" disabled>
                                                <img slot="extra" class="svg" :src="'svg/task.svg'"> THU LÃI TRƯỚC
                                            </p-check>
                                        </td>
                                        <td><switches v-model="commodity.activated" theme="bootstrap" color="success" disabled></switches></td>
                                        <td><a href="#" class="btn btn-xs btn-danger" v-on:click="deleteEntry(commodity.id, index)"><i class="fa fa-trash"></i></a></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="react-bs-table-pagination">
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-4 col-xs-4 col-sm-4 col-lg-4 offset-4">
                                    <pagination :data="commodities" @pagination-change-page="getResults"></pagination>
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
        name: "IndexCommodities",
        data: function () {
            return {
                page: 1,
                commodities: {}
            }
        },
        mounted() { this.getResults(); },
        methods: {
            getResults(page = 1) {
                let app = this;
                app.page = page;
                axios.get('/api/v1/commodities?page=' + page, {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                }).then(response => {
                    app.commodities = response.data;
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
                        axios.delete('/api/v1/commodities/' + id, {
                            headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                        }).then(function (response) {
                            app.getResults(app.page);
                            app.$swal({
                                type: 'success',
                                title: 'Đã xóa thành công!',
                                text: 'Loại hàng hóa đã bị xóa khỏi hệ thống.'
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