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
                                        <router-link :to="{name: 'createContract'}" class="btn btn-success"><i class="fa fa-plus"></i> THÊM MỚI</router-link>
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
                                        <th class="align-content-center">#</th>
                                        <th>TÊN KHÁCH HÀNG</th>
                                        <th>LOẠI TS</th>
                                        <th>TÊN TS</th>
                                        <th>SỐ TIỀN VNĐ</th>
                                        <th>LÃI / NGÀY</th>
                                        <th>NGÀY CẦM</th>
                                        <!--<th>HẾT HẠN</th>-->
                                        <th>THANH LÝ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="contract, index in contracts.data">
                                        <td>{{ index + 1 }}</td>
                                        <td>
                                            <router-link :to="{name: 'editContract', params: {id: contract.id}}" :class="'btn btn-xs btn-default'">
                                                <span :class="'text-success'">
                                                    <strong>{{ contract.customer_id }}</strong>
                                                </span>
                                            </router-link>
                                        </td>
                                        <td></td>
                                        <td>{{ contract.commodity_name }}</td>
                                        <td>{{ contract.pawn_amount | currency }}</td>
                                        <td>{{ contract.interest_by_date | currency }}</td>
                                        <td>{{ contract.pawn_date | moment("D/M/Y") }}</td>
                                        <!--<td></td>-->
                                        <td>
                                            <!--<a href="#" class="btn btn-xs btn-danger" v-on:click="deleteEntry(contract.id, index)"><i class="fa fa-trash"></i></a>-->
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
                page: 1,
                contracts: {}
            }
        },
        mounted() { this.getResults(); },
        methods: {
            getResults(page = 1) {
                let app = this; app.page = page;
                axios.get('/api/v1/contracts?page=' + app.page, {headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }}).then(response => {
                    app.contracts = response.data;
                });
            },
        }
    }
</script>

<style scoped>

</style>