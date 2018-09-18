<template>
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mb-0">Hợp Đồng Đang Bị Cảnh Báo</h4></div>
                <div class="col-sm-6">
                    <nav class="float-left float-sm-right" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}"><i class="ti-home"></i> Dashboard</router-link></li>
                            <li class="breadcrumb-item active" aria-current="page">Hợp Đồng Đang Bị Cảnh Báo</li>
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
                                        <!--<router-link :to="{name: 'createContract'}" class="btn btn-success"><i class="fa fa-plus"></i> THÊM MỚI</router-link>-->
                                    </div>
                                </div>

                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group form-group-sm react-bs-table-search-form">
                                        <input placeholder="Tìm kiếm hợp đồng" class="form-control" type="text"><span class="input-group-btn"></span>
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
                                        <th>KHÁCH HÀNG</th>
                                        <th>ĐIỆN THOẠI</th>
                                        <th>GIÁ TRỊ/PHÍ</th>
                                        <th>THÔNG BÁO</th>
                                        <th>HẾT HẠN</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(contract, index) in contracts">
                                        <td class="align-content-center">#{{ index + 1 }}</td>
                                        <td>
                                            <router-link :to="{name: 'showContract', params: {id: contract.id}}" :class="'btn btn-xs btn-default'">
                                                <span :class="'text-success'"><strong>{{ contract.customer.fullname }}</strong></span>
                                            </router-link>
                                        </td>
                                        <td><span>{{ contract.customer.phone }}</span></td>
                                        <td><span>{{ contract.interest_by_date * contract.interest_period | currency }} VNĐ</span></td>
                                        <td>
                                            <span v-if="!contract.can_paid">Trả phí hợp đồng</span>
                                            <span v-else>Thanh lý hợp đồng</span>
                                        </td>
                                        <td>
                                            <span>{{ contract.pawn_date | moment("D/M/Y") }} => {{ contract.redeeming_date | moment("D/M/Y") }}</span><br>
                                            <span v-if="contract.out_of_date === true" :class="'text-danger'">
                                                <strong>quá hạn {{ contract.out_of_date_days }} ngày</strong>
                                            </span>
                                            <span v-else class="text-danger"><strong>còn {{ contract.remaining }} ngày</strong></span>
                                        </td>
                                        <td>
                                            <button v-on:click="paid(contract)" v-if="!contract.can_paid && isPaidContract" type="button" href="javascript:;" class="btn btn-xs btn-info"><span><i class="fa fa-paw"></i> TRẢ PHÍ</span></button>
                                            <button v-on:click="liquidate(contract)" v-else-if="isLiquidateContract" type="button" href="javascript:;" class="btn btn-xs btn-danger"><span><i class="fa fa-check-circle"></i> THANHLÝ</span></button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
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
        name: "WarningContracts",
        data: function () {
            return {
                isPaidContract: false,
                isLiquidateContract: false,

                page: 1,
                contracts: {}
            }
        },
        mounted() {
            this.getResults();

            // check permissions
            this.checkIsPaidContract();
            this.checkIsLiquidateContract();
        },
        methods: {
            checkIsPaidContract() {
                axios.get('/api/auth/check/permission/' + 'paid-contract', {
                    headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}
                }).then(response => {
                    this.isPaidContract = response.data.access;
                })
            },
            checkIsLiquidateContract() {
                axios.get('/api/auth/check/permission/' + 'liquidate-contract', {
                    headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}
                }).then(response => {
                    this.isLiquidateContract = response.data.access;
                })
            },
            paid(contract) {
                var app = this;
                axios.patch('/api/v1/contracts/paid/' + contract.id, [], {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                }).then(function (response) {
                    console.log(response.data);

                    app.getResults();
                    app.$swal({
                        type: 'success',
                        title: 'Trả phí thành công!',
                        text: 'Hợp đồng của bạn đã được trả phí.'
                    });
                }).catch(function (error) {
                    app.$swal({
                        type: 'error',
                        title: 'Trả phí thất bại!',
                        text: 'Lỗi hệ thống ' + error + ', vui lòng thử lại sau.'
                    });
                });
            },
            liquidate(contract) {
                var app = this;
                app.$swal({
                    title: 'Thanh lý hợp đồng!', text: 'Thanh lý hợp đồng ' + contract.customer.fullname + '!',
                    type: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33',
                    confirmButtonText: 'THANH LÝ!', cancelButtonText: '<i class="fa fa-ban"></i> HỦY BỎ',
                }).then((result) => {
                    if (result.value) {
                        axios.patch('/api/v1/contracts/liquidate/' + contract.id, [], {
                            headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                        }).then(function (response) {
                            app.getResults();
                            app.$swal({
                                type: 'success',
                                title: 'Thanh lý hợp đồng thành công!',
                                text: 'Hợp đồng đã được thanh lý thành công.'
                            });
                        }).catch(function (error) {
                            app.$swal({
                                type: 'error',
                                title: 'Thanh lý thất bại!',
                                text: 'Lỗi hệ thống ' + error + ', vui lòng thử lại sau.'
                            });
                        });
                    }
                });
            },
            getResults(page = 1) {
                let app = this;
                app.page = page;axios.get('/api/v1/contracts/warning?page=' + app.page, {
                    headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}
                }).then(response => {
                    app.contracts = response.data;
                });
            },
            maintaince(){this.$swal({type: 'warning', title: 'Chức năng bảo trì', text: 'Hệ thống đang bảo trì chức năng này, vui lòng thử lại sau'});},
        },
    }
</script>

<style scoped>

</style>