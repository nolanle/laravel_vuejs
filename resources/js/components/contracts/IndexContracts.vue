<template>
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mb-0">Quản Lý Hợp Đồng</h4></div>
                <div class="col-sm-6">
                    <nav class="float-left float-sm-right" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}"><i class="ti-home"></i> Dashboard</router-link></li>
                            <li class="breadcrumb-item active" aria-current="page">Quản Lý Hợp Đồng</li>
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
                                        <router-link v-if="isCreateContract" :to="{name: 'createContract'}" class="btn btn-success"><i class="fa fa-plus"></i> THÊM MỚI</router-link>
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
                                        <th>TÊN TS</th>
                                        <th>SỐ TIỀN</th>
                                        <th>PHÍ/NGÀY</th>
                                        <th>CẦM/CHUỘC</th>
                                        <th>THANH LÝ</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="contract, index in contracts.data">
                                        <td class="align-content-center">#{{ index + 1 }}</td>
                                        <td>
                                            <router-link v-if="isEditContract" :to="{name: 'editContract', params: {id: contract.id}}" :class="'btn btn-xs btn-default'">
                                                <span :class="'text-success'"><strong>{{ contract.customer.fullname }}</strong></span>
                                            </router-link>
                                            <span v-else>{{ contract.customer.fullname }}</span>
                                        </td>
                                        <td><span>{{ contract.commodity_name }} ({{ contract.commodity.code }})</span></td>
                                        <td><span>{{ contract.pawn_amount | currency }}</span></td>
                                        <td><span>{{ contract.interest_by_date | currency }}</span></td>
                                        <td>
                                            <span>{{ contract.pawn_date | moment("D/M/Y") }} =></span><br>
                                            <span>{{ contract.redeeming_date | moment("D/M/Y") }}</span><br>
                                            <span v-if="contract.out_of_date === true" :class="'text-danger'">
                                                <strong>quá hạn {{ contract.out_of_date_days }} ngày</strong>
                                            </span>
                                            <span v-else class="text-danger"><strong>còn {{ contract.remaining }} ngày</strong></span>
                                        </td>
                                        <td><p-check disabled class="p-svg p-plain" v-model="contract.liquidate_date !== null"><img slot="extra" class="svg" :src="'svg/task.svg'">THANH LÝ</p-check></td>
                                        <td>
                                            <router-link :to="{name: 'showContract', params: {id: contract.id}}" :class="'btn btn-xs btn-success'"><span><i class="fa fa-tasks"></i></span></router-link>
                                            <a v-if="isDeleteContract" v-on:click="deleteEntry(contract.id, index)" href="javascript:;" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="react-bs-table-pagination">
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-4 col-xs-4 col-sm-4 col-lg-4 offset-4">
                                    <pagination :data="contracts" @pagination-change-page="getResults"></pagination>
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
        name: "IndexContracts",
        data: function () {
            return {
                // checking
                isCreateContract: false,
                isEditContract: false,
                isDeleteContract: false,

                // get informations
                page: 1,
                contracts: {}
            }
        },
        mounted() {
            this.getResults();

            // check
            this.checkIsCreateContract();
            this.checkIsEditContract();
            this.checkIsDeleteContract();
        },
        methods: {
            checkIsCreateContract() {
                axios.get('/api/auth/check/permission/' + 'create-contract', {
                    headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}
                }).then(response => {
                    this.isCreateContract = response.data.access;
                })
            },
            checkIsEditContract() {
                axios.get('/api/auth/check/permission/' + 'edit-contract', {
                    headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}
                }).then(response => {
                    this.isEditContract = response.data.access;
                })
            },
            checkIsDeleteContract() {
                axios.get('/api/auth/check/permission/' + 'delete-contract', {
                    headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}
                }).then(response => {
                    this.isDeleteContract = response.data.access;
                })
            },

            getResults(page = 1) {
                let app = this; app.page = page;
                axios.get('/api/v1/contracts?page=' + app.page, {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                }).then(response => {
                    app.contracts = response.data;
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
                        axios.delete('/api/v1/contracts/' + id, {
                            headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                        }).then(function (response) {
                            app.getResults(app.page);
                            app.$swal({
                                type: 'success',
                                title: 'Đã xóa thành công!',
                                text: 'Hợp đồng đã bị xóa khỏi hệ thống.'
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