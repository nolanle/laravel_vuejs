<template>
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mb-0">Xem Chi Tiết</h4></div>
                <div class="col-sm-6">
                    <nav class="float-left float-sm-right" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}"><i class="ti-home"></i> Dashboard</router-link></li>
                            <li class="breadcrumb-item"><router-link :to="{name: 'indexContracts'}">Cầm Đồ</router-link></li>
                            <li class="breadcrumb-item active" aria-current="page">Xem Chi Tiết</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="card-statistics mb-30 card">
            <div class="card-body">
                <h5 class="card-title"><span>Xem Chi Tiết</span></h5>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="text-danger">Lịch Sử Trả Phí</h4>
                        <hr>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <table class="table table-striped table-bordered table-hover table-condensed">
                                    <thead>
                                    <tr>
                                        <th class="align-content-center">STT</th>
                                        <th>Từ Ngày</th>
                                        <th>Đến Ngày</th>
                                        <th>Số Tiền</th>
                                        <th>Số Ngày</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(history, index) in contract.histories">
                                        <td class="align-content-center">#{{ index + 1 }}</td>
                                        <td><span>{{ history.from | moment("D-M-Y") }}</span></td>
                                        <td><span>{{ history.to | moment("D-M-Y") }}</span></td>
                                        <td><span>{{ history.amount | currency }}</span></td>
                                        <td><span>{{ history.paid_days }} ngày</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group col-md-6">
                                <span><strong>THÔNG TIN THANH TOÁN</strong></span>
                                <table class="table table-striped table-bordered table-hover table-condensed">
                                    <tbody>
                                    <tr>
                                        <td><h6>Số tiền:</h6></td>
                                        <td><h6>{{ contract.interest_by_date * contract.interest_period | currency }}</h6></td>
                                    </tr>
                                    <tr>
                                        <td><h6>Số ngày:</h6></td>
                                        <td><h6>{{ contract.interest_period }} ngày</h6></td>
                                    </tr>
                                    <tr>
                                        <td><h6>Còn lại:</h6></td>
                                        <td>
                                            <h6 v-if="contract.out_of_date === true" :class="'text-danger'">Quá hạn {{ contract.out_of_date_days }} ngày</h6>
                                            <h6 v-else class="text-danger">Còn {{ contract.remaining }} ngày</h6>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="pull-right">
                                    <span><strong>HÀNH ĐỘNG</strong></span><br>
                                    <button @click="$router.go(-1)" type="button" class="btn btn-secondary"><i class="fa fa-arrow-left"></i><span> QUAY LẠI</span></button>
                                    <button v-if="isPaidContract" v-on:click="paid" :disabled="contract.can_paid || contract.can_liquidate === true" type="button" href="javascript:;" class="btn btn-xs btn-info"><span><i class="fa fa-paw"></i> TRẢ PHÍ</span></button>
                                    <!--<button v-if="isRenewContract" v-on:click="maintaince" :disabled="contract.can_renew || contract.can_liquidate === true" type="button" href="javascript:;" class="btn btn-xs btn-warning"><span><i class="fa fa-arrow-circle-o-up"></i> GIA HẠN</span></button>-->
                                    <button v-if="isLiquidateContract" v-on:click="liquidate" :disabled="contract.can_liquidate" type="button" href="javascript:;" class="btn btn-xs btn-danger"><span><i class="fa fa-check-circle"></i> THANHLÝ</span></button>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h4 class="text-danger">Thông Tin Khách Hàng</h4><hr>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="fullname">Khách Hàng <span class="text-danger">(*)</span></label>
                                <input v-model="contract.customer.fullname" id="fullname" type="text" class="form-control" required disabled />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="government_id">CMND / Passport <span class="text-danger">(*)</span></label>
                                <input v-model="contract.customer.government_id" id="government_id" type="text" class="form-control" required disabled />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="phone">Số Điện Thoại <span class="text-danger">(*)</span></label>
                                <input v-model="contract.customer.phone" id="phone" type="text" class="form-control" required disabled />
                            </div>

                            <div class="form-group col-md-6">
                                <label for="address">Địa Chỉ <span class="text-danger">(*)</span></label>
                                <input v-model="contract.customer.address" id="address" type="text" class="form-control" required disabled />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="issued_date">Ngày Cấp <span class="text-danger">(*)</span></label>
                                <input v-model="contract.customer.issued_date" id="issued_date" type="text" class="form-control" required disabled />
                            </div>

                            <div class="form-group col-md-6">
                                <label for="issued_at">Cấp Tại <span class="text-danger">(*)</span></label>
                                <input v-model="contract.customer.issued_at" id="issued_at" type="text" class="form-control" required disabled />
                            </div>
                        </div>

                        <h4 class="text-danger">Thông Tin Tài Sản</h4><hr>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="commodity_id">Loại Tài Sản <span class="text-danger">(*)</span></label>
                                <input v-model="contract.commodity.name" id="commodity_id" type="text" class="form-control" required disabled />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="commodity_name">Tên Tài Sản <span class="text-danger">(*)</span></label>
                                <input v-model="contract.commodity_name" id="commodity_name" type="text" class="form-control" required disabled />
                            </div>
                        </div>

                        <div class="form-row">
                            <div v-for="(attr, index) in contract.attrs" class="form-group col-md-6">
                                <label>{{ attr.key }} <span class="text-danger">(*)</span></label>
                                <div class="input-group">
                                    <input v-model="attr.value" type="text" class="form-control" required disabled />
                                </div>
                            </div>
                        </div>

                        <h4 class="text-danger">Thông Tin Hợp Đồng</h4><hr>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="pawn_amount">Số Tiền Cầm <span class="text-danger">(*)</span></label>
                                <money v-model="contract.pawn_amount" id="pawn_amount" :class="'form-control'" disabled></money>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="interest_by_date">Số Tiền Lãi <span class="text-danger">(*)</span> <small>(VNĐ / 1 Triệu / Ngày)</small></label>
                                <money v-model="contract.interest_by_date" id="interest_by_date" :class="'form-control'" disabled></money>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="interest_period">Kỳ Lãi <span class="text-danger">(*)</span></label>
                                <money v-model="contract.interest_period" id="interest_period" :class="'form-control'" disabled></money>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Thu Lãi Trước <span class="text-danger">(*)</span></label>
                                <span class="form-control">
                                    <p-check class="p-svg p-plain" v-model="contract.interest_before_pawn" disabled>
                                        <img slot="extra" class="svg" :src="'svg/task.svg'">Thu Lãi Trước
                                    </p-check>
                                </span>
                            </div>
                            <div class="col-md-12"><small>(VD : 10 ngày đóng lãi 1 lần thì điền số 10)</small></div>
                        </div><br>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="days_of_delayed">Thanh Lý Sau (ngày) <span class="text-danger">(*)</span></label>
                                <money v-model="contract.days_of_delayed" id="days_of_delayed" :class="'form-control'" disabled></money>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Ngày Vay <span class="text-danger">(*)</span></label>
                                <datepicker v-model="contract.pawn_date" :format="customFormatter" :input-class="'form-control'" disabled></datepicker>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pawn_note">Ghi chú</label>
                            <textarea-autosize v-model="contract.pawn_note" id="pawn_note" :min-height="150" ref="pawn_note" :class="'form-control'" disabled></textarea-autosize>
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
        name: "ShowContract",
        data: function () {
            return {
                // checking
                isPaidContract: false,
                isRenewContract: false,
                isLiquidateContract: false,

                // data
                en: en, vi: vi,
                contract: {
                    customer: {id: 0, fullname: '', address: '', phone: '', government_id: '', issued_date: '', issued_at: ''},
                    commodity: {id: 0, name: '', code: '', mortgage_amount: 0, interest_before_mortgage: 0, interest_by_date: 0, interest_period: 0, days_of_delayed: 0, activated: 0, attrs: [],},
                    id: 0, commodity_id: 0, commodity_name: '', pawn_amount: 0, interest_before_pawn: 0, interest_by_date: 0, interest_period: 0, days_of_delayed: 0, pawn_date: '', pawn_note: '', attrs: [], liquidate_date: '',
                },
            }
        },
        mounted(){
            this.contract.id = this.$route.params.id;
            this.getContract();

            // check permissions
            this.checkIsPaidContract();
            this.checkIsRenewContract();
            this.checkIsLiquidateContract();
        },
        methods:{
            checkIsPaidContract() {
                axios.get('/api/auth/check/permission/' + 'paid-contract', {
                    headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}
                }).then(response => {
                    this.isPaidContract = response.data.access;
                })
            },
            checkIsRenewContract() {
                axios.get('/api/auth/check/permission/' + 'renew-contract', {
                    headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}
                }).then(response => {
                    this.isRenewContract = response.data.access;
                })
            },
            checkIsLiquidateContract() {
                axios.get('/api/auth/check/permission/' + 'liquidate-contract', {
                    headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}
                }).then(response => {
                    this.isLiquidateContract = response.data.access;
                })
            },

            paid() {
                var app = this;
                axios.patch('/api/v1/contracts/paid/' + app.contract.id, [], {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                }).then(function (response) {
                    console.log(response.data);

                    // app.getContract();

                    app.$router.go(app.$route.fullPath);

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
            liquidate() {
                var app = this;
                app.$swal({
                    title: 'Thanh lý hợp đồng!', text: 'Thanh lý hợp đồng ' + app.contract.customer.fullname + '!',
                    type: 'warning', showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33',
                    confirmButtonText: 'THANH LÝ!', cancelButtonText: '<i class="fa fa-ban"></i> HỦY BỎ',
                }).then((result) => {
                    if (result.value) {
                        axios.patch('/api/v1/contracts/liquidate/' + app.contract.id, [], {
                            headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                        }).then(function (response) {
                            // app.getContract();

                            app.$router.go(app.$route.fullPath);

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
            getContract(){let app = this;axios.get('/api/v1/contracts/' + app.contract.id, {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {app.contract = response.data;})},
            customFormatter(date) {return moment(date, 'YYYY-MM-DD').format('DD-MM-YYYY')},
            diffDays(date1, date2) {var timeDiff = Math.abs(date2.getTime() - date1.getTime());return Math.ceil(timeDiff / (1000 * 3600 * 24));},
            maintaince(){this.$swal({type: 'warning', title: 'Chức năng bảo trì', text: 'Hệ thống đang bảo trì chức năng này, vui lòng thử lại sau'});},
        }
    }
</script>

<style scoped>

</style>