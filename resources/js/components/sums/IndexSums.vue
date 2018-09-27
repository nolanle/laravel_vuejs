<template>
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mb-0">Tổng Hợp Thu Chi</h4>
                    <div class="delete-button"></div>
                </div>
                <div class="col-sm-6">
                    <nav class="float-left float-sm-right" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}"><i class="ti-home"></i> Dashboard</router-link></li>
                            <li class="breadcrumb-item active" aria-current="page">Tổng Hợp Thu Chi</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="mb-30 col-xl-12">
                <div class="card-statistics h-100 card">
                    <div class="card-body react-bs-table-container">

                        <form v-on:submit="getSumsWithFilter()">
                            <div class="react-bs-table-tool-bar mb-10">
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label>Từ Ngày</label>
                                        <datepicker v-model="fromDate" :format="customFormatter" :language="vi" :input-class="'form-control'"></datepicker>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Đến Ngày</label>
                                        <datepicker v-model="toDate" :format="customFormatter" :language="vi" :input-class="'form-control'"></datepicker>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Xem Báo Cáo</label>
                                        <button class="btn btn-success form-control"><i class="fa fa-filter"></i><span> Xem Báo Cáo</span></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <hr>

                        <div class="react-bs-table react-bs-table-bordered">
                            <div class="react-bs-container-body">
                                <table class="table table-striped table-bordered table-hover table-condensed">
                                    <thead>
                                    <tr>
                                        <th>THỜI GIAN</th>
                                        <th>SỐ DƯ ĐẦU KỲ</th>
                                        <th>TỔNG THU</th>
                                        <th>TỔNG CHI</th>
                                        <th>SỐ DƯ CUỐI KỲ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(sum, index) in sums.data">
                                        <td>{{ sum.arising_date | moment("D/M/Y") }}</td>
                                        <td>{{ sum.beginning_balance | currency }}</td>
                                        <td>{{ sum.total_revenue | currency }}</td>
                                        <td>{{ sum.total_cost | currency }}</td>
                                        <td>{{ sum.ending_balance | currency }}</td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <td><span class="text-danger"><strong>{{ total.col_a }}</strong></span></td>
                                        <td><span class="text-danger"><strong>{{ total.col_b | currency }}</strong></span></td>
                                        <td><span class="text-danger"><strong>{{ total.col_c | currency }}</strong></span></td>
                                        <td><span class="text-danger"><strong>{{ total.col_d | currency }}</strong></span></td>
                                        <td><span class="text-danger"><strong>{{ total.col_e | currency }}</strong></span></td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="react-bs-table-pagination">
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-4 col-xs-4 col-sm-4 col-lg-4 offset-4">
                                    <pagination :data="sums" @pagination-change-page="getResults"></pagination>
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
    import moment from 'moment';
    import {en, vi} from 'vuejs-datepicker/dist/locale';

    export default {
        name: "IndexSums",
        data: function () {
            return {
                page: 1, en: en, vi: vi,
                fromDate: new Date().setDate((new Date()).getDate() - 10),
                toDate: new Date(),
                sums: {}, total: {},
            }
        },
        mounted() {
            this.getResults();
        },
        methods: {
            totalCost() {
                let cost = 0;
                this.sums.map(function(value, key) {
                    cost += value.total_cost;
                });
                return cost;
            },
            getSumsWithFilter() {
                event.preventDefault();
                let app         = this;
                app.fromDate    = moment(app.fromDate).format('YYYY-MM-DD');
                app.toDate      = moment(app.toDate).format('YYYY-MM-DD');
                axios.post('/api/v1/sums-with-filter?page=' + app.page, {
                    from_date: app.fromDate, to_date: app.toDate
                }, {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                }).then(function (response) {
                    app.sums = response.data;
                    app.total = response.data.total;
                });
            },
            customFormatter(date) { return moment(date, 'YYYY-MM-DD').format('DD-MM-YYYY') },
            getResults(page = 1) {
                let app = this;
                app.page = page;
                axios.get('/api/v1/sums?page=' + app.page, {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                }).then(
                    response => {
                        app.sums = response.data;
                        app.total = response.data.total;
                    }
                );
            },
        },
    }
</script>

<style scoped>

</style>