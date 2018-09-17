<template>
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mb-0">Thêm Hợp Đồng</h4></div>
                <div class="col-sm-6">
                    <nav class="float-left float-sm-right" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}"><i class="ti-home"></i> Dashboard</router-link></li>
                            <li class="breadcrumb-item"><router-link :to="{name: 'indexContracts'}">Cầm Đồ</router-link></li>
                            <li class="breadcrumb-item active" aria-current="page">Thêm Hợp Đồng</li>
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
                        <form v-on:submit="createForm()">
                            <h4 class="text-danger">Thông Tin Khách Hàng</h4><hr>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="address">Loại khách hàng <span class="text-danger">(*)</span></label>
                                    <span class="form-control">
                                        <p-radio class="p-icon p-round" name="customer_type" v-model="customer_type" value="new" color="primary">
                                            <i slot="extra" class="icon mdi mdi-check"></i> Khách Hàng Mới
                                        </p-radio>
                                        <p-radio class="p-icon p-round" name="customer_type" v-model="customer_type" value="old" color="success">
                                            <i slot="extra" class="icon mdi mdi-check"></i> Khách Hàng Đã Có Trong Hệ Thống
                                        </p-radio>
                                    </span>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="fullname">Khách Hàng <span class="text-danger">(*)</span></label>
                                    <input v-if="customer_type === 'new'" v-model="customer.fullname" id="fullname" type="text" class="form-control" required />
                                    <v-autocomplete v-if="customer_type === 'old'" :auto-select-one-item="false" :id="'fullname-autocompete'" :items="items" v-model="item" @update-items="updateSearch" @item-clicked="itemSelected" :get-label="getCustomerName" :component-item="template" :input-class="'form-control'"></v-autocomplete>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="government_id">CMND / Passport <span class="text-danger">(*)</span></label>
                                    <input v-model="customer.government_id" id="government_id" type="text" class="form-control" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="phone">Số Điện Thoại <span class="text-danger">(*)</span></label>
                                    <input v-model="customer.phone" id="phone" type="text" class="form-control" required />
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="address">Địa Chỉ <span class="text-danger">(*)</span></label>
                                    <input v-model="customer.address" id="address" type="text" class="form-control" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="issued_date">Ngày Cấp <span class="text-danger">(*)</span></label>
                                    <!--<input v-model="customer.issued_date" id="issued_date" type="text" class="form-control" required />-->
                                    <datepicker v-model="customer.issued_date" :format="customFormatter" :language="vi" :input-class="'form-control'"></datepicker>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="issued_at">Cấp Tại <span class="text-danger">(*)</span></label>
                                    <input v-model="customer.issued_at" id="issued_at" type="text" class="form-control" required />
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
                                    <money v-model="contract.pawn_amount" id="pawn_amount" :class="'form-control'"></money>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="interest_by_date">Số Tiền Lãi <span class="text-danger">(*)</span> <small>(VNĐ / 1 Triệu / Ngày)</small></label>
                                    <money v-model="contract.interest_by_date" id="interest_by_date" :class="'form-control'"></money>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="interest_period">Kỳ Lãi <span class="text-danger">(*)</span></label>
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
                                    <money v-model="contract.days_of_delayed" id="days_of_delayed" :class="'form-control'"></money>
                                    <!--<input v-model="contract.days_of_delayed" id="days_of_delayed" type="text" class="form-control" required />-->
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
                            <div class="mt-5 pull-right">
                                <router-link :to="{name: 'indexContracts'}" class="btn btn-secondary"><i class="fa fa-arrow-left"></i><span> QUAY LẠI</span></router-link>
                                <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i><span> THÊM MỚI</span></button>
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
    import SearchCustomer from './SearchCustomer.vue'

    export default {
        name: "CreateContract",
        data: function () {
            return {
                en: en, vi: vi,
                template: SearchCustomer, items: [], customer_type: 'new', commodities: {},
                item: { fullname: '', address: '', phone: '', government_id: '', issued_date: '', issued_at: '' },
                customer: { fullname: '', address: '', phone: '', government_id: '', issued_date: '', issued_at: '' },
                contract: {
                    commodity_id: 1,
                    commodity_name: '',
                    pawn_amount: 0,
                    interest_before_pawn: 0,
                    interest_by_date: 3000,
                    interest_period: 10,
                    days_of_delayed: 15,
                    pawn_date: new Date(),
                    pawn_note: ''
                },
            }
        },
        mounted(){
            this.getCustomers();
            this.getCommodities();
        },
        methods:{
            customFormatter(date) { return moment(date, 'YYYY-MM-DD').format('DD-MM-YYYY') },
            getCustomerName(customer){try{return customer.fullname;}catch(e){console.log("Không tìm thấy!");}},itemSelected(){this.customer=this.item;},
            updateSearch(text){ if (this.customer_type === 'old') { let app = this; axios.post('/api/v1/customers-search/', { text: text },{ headers: {Authorization: 'Bearer ' + localStorage.getItem('token')} }).then(response => { app.items = response.data; }); } },
            getCustomer(id){let app = this;axios.get('/api/v1/customers/' + id, {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {app.contract.customer = response.data;});},
            getCustomers(){let app = this;axios.get('/api/v1/customers-without-paginate', {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {app.customers = response.data;app.item = app.items[0];});},
            getCommodities(){let app = this;axios.get('/api/v1/commodities-without-paginate', {headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}}).then(response => {app.commodities = response.data;});},
            createForm(){
                let app = this;
                event.preventDefault();

                app.customer.issued_date      = moment(app.customer.issued_date).format('YYYY-MM-DD');
                app.contract.customer       = app.customer;
                app.contract.customer.type  = app.customer_type;
                app.contract.pawn_date      = moment(app.contract.pawn_date).format('YYYY-MM-DD');

                axios.post('/api/v1/contracts', app.contract, {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                }).then(function (response) {
                    app.$swal({type: 'success', title: 'Thêm mới thành công?', text: "Đã thêm mới hợp đồng thành công!", confirmButtonColor: '#3085d6'}).then((result) => {
                        if (result.value) {app.$router.push({path: '/contracts'});} else {app.$swal({type: 'error', title: 'Thêm mới thất bại!', text: 'Lỗi hệ thống ' + error + ', vui lòng thử lại sau.'});}
                    });
                }).catch(function (error) {
                    app.$swal({
                        type: 'error',
                        title: 'Thêm mới thất bại!',
                        text: 'Lỗi hệ thống ' + error + ', vui lòng thử lại sau.'
                    });
                });
            }
        }
    }
</script>

<style scoped>

</style>