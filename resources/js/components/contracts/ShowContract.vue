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
                    <div class="col-md-8 offset-md-2">
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
                                        <th>Hành Động</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="history, index in contract.histories">
                                        <td class="align-content-center">#{{ index + 1 }}</td>
                                        <td><span>{{ history.from | moment("D-M-Y") }}</span></td>
                                        <td><span>{{ history.to = new Date() | moment("D-M-Y") }}</span></td>
                                        <td>
                                            <span v-if="history.type === 'created'">{{ history.amount = diffDays(new Date(), new Date(history.from)) * contract.interest_by_date | currency }} VNĐ</span>
                                        </td>
                                        <td>
                                            <a v-on:click="maintaince" v-if="history.amount > 0" href="javascript:;" class="btn btn-xs btn-info"><span><i class="fa fa-paw"></i> TRẢ PHÍ</span></a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="pull-right">
                                    <a v-on:click="maintaince" href="javascript:;" class="btn btn-xs btn-warning"><span><i class="fa fa-arrow-circle-o-up"></i> GIA HẠN</span></a>
                                    <a v-on:click="maintaince" href="javascript:;" class="btn btn-xs btn-danger"><span><i class="fa fa-check-circle"></i> THANHLÝ</span></a>
                                </div>
                            </div>
                        </div>

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
                en: en, vi: vi,
                contract: {
                    customer: {id: 0, fullname: '', address: '', phone: '', government_id: '', issued_date: '', issued_at: ''},
                    commodity: {id: 0, name: '', code: '', mortgage_amount: 0, interest_before_mortgage: 0, interest_by_date: 0, interest_period: 0, days_of_delayed: 0, activated: 0, attrs: [],},
                    id: 0, commodity_id: 0, commodity_name: '', pawn_amount: 0, interest_before_pawn: 0, interest_by_date: 0, interest_period: 0, days_of_delayed: 0, pawn_date: '', pawn_note: '', attrs: [],
                },
            }
        },
        mounted(){
            this.contract.id = this.$route.params.id;
            this.getContract();
        },
        methods:{
            maintaince(){
                this.$swal({
                    type: 'warning',
                    title: 'Chức năng bảo trì',
                    text: 'Hệ thống đang bảo trì chức năng này, vui lòng thử lại sau'
                });
            },
            paid(history) {
                history.from = moment(history.from).format('YYYY-MM-DD');
                history.to = moment(history.to).format('YYYY-MM-DD');
                console.log(history);
            },
            diffDays(date1, date2) {
                var timeDiff = Math.abs(date2.getTime() - date1.getTime());
                return Math.ceil(timeDiff / (1000 * 3600 * 24));
            },
            customFormatter(date) {return moment(date, 'YYYY-MM-DD').format('DD-MM-YYYY')},
            getContract(){
                let app = this;
                axios.get('/api/v1/contracts/' + app.contract.id, {
                    headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}
                }).then(response => {
                    app.contract = response.data;
                    console.log(response.data);
                });
            },
            liquidateEntry(contract) {
                var app = this;
                app.$swal({
                    type: 'warning',
                    title: 'Thanh lý hợp đồng của ' + contract.customer.fullname + '!',
                    text: "Chi phí: " + contract.pawn_fee_amount + " cho " + contract.pawn_days + " ngày.",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'THANH LÝ!',
                    cancelButtonText: '<i class="fa fa-ban"></i> HỦY BỎ',
                }).then((result) => {
                    if (result.value) {
                        axios.patch('/api/v1/contracts/paid/' + contract.id, [], {
                            headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                        }).then(function (response) {
                            // console.log(response.data);
                            app.getResults(app.page);
                            app.$swal({
                                type: 'success',
                                title: 'Đã xóa thành công!',
                                text: 'Công ty do bạn quản lý đã bị xóa khỏi hệ thống.'
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
        }
    }
</script>

<style scoped>

</style>