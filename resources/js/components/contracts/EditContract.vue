<template>
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mb-0">Chỉnh Sửa Hợp Đồng</h4></div>
                <div class="col-sm-6">
                    <nav class="float-left float-sm-right" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}"><i class="ti-home"></i> Dashboard</router-link></li>
                            <li class="breadcrumb-item"><router-link :to="{name: 'indexContracts'}">Cầm Đồ</router-link></li>
                            <li class="breadcrumb-item active" aria-current="page">Chỉnh Sửa Hợp Đồng</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card-statistics mb-30 card">
            <div class="card-body">
                <h5 class="card-title"><span>Thêm Hợp Đồng Mới</span></h5>
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <form v-on:submit="updateForm()">
                            <h4 class="text-danger">Thông Tin Khách Hàng</h4><hr>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="fullname">Khách Hàng <span class="text-danger">(*)</span></label>
                                    <input v-model="contract.customer.fullname" id="fullname" type="text" class="form-control" required />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="government_id">CMND / Passport <span class="text-danger">(*)</span></label>
                                    <input v-model="contract.customer.government_id" id="government_id" type="text" class="form-control" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="phone">Số Điện Thoại <span class="text-danger">(*)</span></label>
                                    <input v-model="contract.customer.phone" id="phone" type="text" class="form-control" required />
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="address">Địa Chỉ <span class="text-danger">(*)</span></label>
                                    <input v-model="contract.customer.address" id="address" type="text" class="form-control" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="issued_date">Ngày Cấp <span class="text-danger">(*)</span></label>
                                    <!--<input v-model="contract.customer.issued_date" id="issued_date" type="text" class="form-control" required />-->
                                    <datepicker v-model="contract.customer.issued_date" :format="customFormatter" :language="vi" :input-class="'form-control'"></datepicker>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="issued_at">Cấp Tại <span class="text-danger">(*)</span></label>
                                    <input v-model="contract.customer.issued_at" id="issued_at" type="text" class="form-control" required />
                                </div>
                            </div>
                            <h4 class="text-danger">Thông Tin Tài Sản</h4><hr>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="commodity_id">Loại Tài Sản <span class="text-danger">(*)</span></label>
                                    <select v-model="contract.commodity_id" id="commodity_id" class="form-control" required>
                                        <option v-for="item in commodities" v-bind:value="item.id">{{ item.name }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="commodity_name">Tên Tài Sản <span class="text-danger">(*)</span></label>
                                    <input v-model="contract.commodity_name" id="commodity_name" type="text" class="form-control" required />
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="pawn_amount">Số Tiền Cầm <span class="text-danger">(*)</span></label>
                                    <!--<input v-model="contract.pawn_amount" id="pawn_amount" type="text" class="form-control" required />-->
                                    <money v-model="contract.pawn_amount" id="pawn_amount" :class="'form-control'"></money>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="interest_by_date">Số Tiền Lãi <span class="text-danger">(*)</span> <small>(VNĐ / 1 Triệu / Ngày)</small></label>
                                    <!--<input v-model="contract.interest_by_date" id="interest_by_date" type="text" class="form-control" required />-->
                                    <money v-model="contract.interest_by_date" id="interest_by_date" :class="'form-control'"></money>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="interest_period">Kỳ Lãi <span class="text-danger">(*)</span></label>
                                    <!--<input v-model="contract.interest_period" id="interest_period" type="text" class="form-control" required />-->
                                    <money v-model="contract.interest_period" id="interest_period" :class="'form-control'"></money>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Thu Lãi Trước <span class="text-danger">(*)</span></label>
                                    <span class="form-control">
                                        <p-check class="p-svg p-plain" v-model="contract.interest_before_pawn">
                                            <img slot="extra" class="svg" :src="'svg/task.svg'">Thu Lãi Trước
                                        </p-check>
                                    </span>
                                </div>
                                <div class="col-md-12"><small>(VD : 10 ngày đóng lãi 1 lần thì điền số 10)</small></div>
                            </div>
                            <br>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="days_of_delayed">Thanh Lý Sau (ngày) <span class="text-danger">(*)</span></label>
                                    <!--<input v-model="contract.days_of_delayed" id="days_of_delayed" type="text" class="form-control" required />-->
                                    <money v-model="contract.days_of_delayed" id="days_of_delayed" :class="'form-control'"></money>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Ngày Vay <span class="text-danger">(*)</span></label>
                                    <datepicker v-model="contract.pawn_date" :format="customFormatter" :language="vi" :input-class="'form-control'"></datepicker>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="pawn_note">Ghi chú</label>
                                <textarea-autosize v-model="contract.pawn_note" id="pawn_note" :min-height="150" ref="pawn_note" :class="'form-control'"></textarea-autosize>
                            </div>

                            <div class="pull-right">
                                <router-link :to="{name: 'indexContracts'}" class="btn btn-secondary">
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
    import moment from 'moment';
    import {en, vi} from 'vuejs-datepicker/dist/locale';

    export default {
        name: "EditContract",
        data: function () {
            return {
                en: en, vi: vi,
                commodities: {},
                contract: {
                    customer: {
                        id: 0,
                        fullname: '',
                        address: '',
                        phone: '',
                        government_id: '',
                        issued_date: '',
                        issued_at: ''
                    },
                    commodity: {
                        name: '', code: '',
                        mortgage_amount: 0,
                        interest_before_mortgage: 0,
                        interest_by_date: 0,
                        interest_period: 0,
                        days_of_delayed: 0,
                        activated: 0,
                    },
                    id: 0,
                    commodity_id: 0,
                    commodity_name: '',
                    pawn_amount: 0,
                    interest_before_pawn: 0,
                    interest_by_date: 0,
                    interest_period: 0,
                    days_of_delayed: 0,
                    pawn_date: '',
                    pawn_note: ''
                },
            }
        },
        mounted(){
            this.contract.id = this.$route.params.id;
            this.getCommodities();
            this.getContract();
        },
        methods:{
            customFormatter(date) { return moment(date, 'YYYY-MM-DD').format('DD-MM-YYYY') },
            getCommodities(){let app = this;axios.get('/api/v1/commodities-without-paginate', {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {app.commodities = response.data;});},
            getContract(){
                let app = this;
                axios.get('/api/v1/contracts/' + app.contract.id, {
                    headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}
                }).then(response => {
                    app.contract = response.data;
                });
            },
            updateForm(){
                let app = this;
                event.preventDefault();
                app.contract.pawn_date = moment(app.contract.pawn_date).format('YYYY-MM-DD');
                app.contract.customer.issued_date = moment(app.contract.customer.issued_date).format('YYYY-MM-DD');

                axios.patch('/api/v1/contracts/' + app.contract.id, app.contract, {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                }).then(function (response) {
                    app.$swal({ // is succeed
                        type: 'success',
                        title: 'Thêm mới thành công?',
                        text: "Cập nhật hợp đồng thành công!",
                        confirmButtonColor: '#3085d6'
                    }).then((result) => {
                        if (result.value) {
                            app.$router.push({path: '/contracts'});
                        } else {
                            app.$swal({type: 'error', title: 'Thêm mới thất bại!', text: 'Lỗi hệ thống ' + error + ', vui lòng thử lại sau.'});
                        }
                    });
                }).catch(function (error) {
                    app.$swal({type: 'error', title: 'Thêm mới thất bại!', text: 'Lỗi hệ thống ' + error + ', vui lòng thử lại sau.'});
                });
            }
        }
    }
</script>

<style scoped>

</style>