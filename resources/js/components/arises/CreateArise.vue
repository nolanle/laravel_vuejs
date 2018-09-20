<template>
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mb-0">Xem Chi Tiết</h4>
                    <div class="delete-button"></div>
                </div>
                <div class="col-sm-6">
                    <nav class="float-left float-sm-right" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}"><i class="ti-home"></i> Dashboard</router-link></li>
                            <li class="breadcrumb-item"><router-link :to="{name: 'indexArises'}">Chi Tiết Hằng Ngày</router-link></li>
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

                        <form v-on:submit="createForm()">

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="type">Loại Chi Phí <span class="text-danger">(*)</span></label>

                                    <span id="type" class="form-control">
                                    <p-radio v-model="arise.type" class="p-icon p-round" name="customer_type" value="deposit" color="primary">
                                        <i slot="extra" class="icon mdi mdi-check"></i> Nhập Vốn
                                    </p-radio>
                                    <p-radio v-model="arise.type" class="p-icon p-round" name="customer_type" value="withdraw" color="primary">
                                        <i slot="extra" class="icon mdi mdi-check"></i> Xuất Vốn
                                    </p-radio>
                                    <p-radio v-model="arise.type" class="p-icon p-round" name="customer_type" value="deposit_other" color="success">
                                        <i slot="extra" class="icon mdi mdi-check"></i> Thu Khác
                                    </p-radio>
                                    <p-radio v-model="arise.type" class="p-icon p-round" name="customer_type" value="withdraw_other" color="success">
                                        <i slot="extra" class="icon mdi mdi-check"></i> Chi Khác
                                    </p-radio>
                                </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="company_id">Công Ty <span class="text-danger">(*)</span></label>
                                <select v-model="arise.company_id" id="company_id" class="form-control">
                                    <option v-for="company in companies" v-bind:value="company.id">{{ company.name }}</option>
                                </select>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="amount">Số Tiền <span class="text-danger">(*)</span></label>
                                    <money v-model="arise.amount" id="amount" :class="'form-control text-right'"></money>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="created_at">Thời Gian <span class="text-danger">(*)</span></label>
                                    <datepicker v-model="arise.created_at" :format="customFormatter" :language="vi" :input-class="'form-control'"></datepicker>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Ghi Chú</label>
                                <textarea-autosize v-model="arise.description" id="description" :min-height="180" ref="description" :class="'form-control'"></textarea-autosize>
                            </div>

                            <div class="mt-5 pull-right">
                                <button @click="$router.go(-1)" type="button" class="btn btn-secondary"><i class="fa fa-arrow-left"></i><span> QUAY LẠI</span></button>
                                <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i><span>THÊM MỚI</span></button>
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
        name: "CreateArise",
        data: function () {
            return {
                en: en, vi: vi,
                companies: {},
                arise: {
                    type: 'deposit',
                    company_id: 0,
                    amount: 0,
                    description: '',
                    created_at: new Date(),
                },
            }
        },
        mounted() {
            this.getCompanies();
            this.getProfile();
        },
        methods: {
            customFormatter(date) { return moment(date, 'YYYY-MM-DD').format('DD-MM-YYYY') },
            getProfile() {
                let app = this;
                axios.get('/api/auth/me', {
                    headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}
                }).then(response => {
                    this.arise.company_id = response.data.company.value;
                });
            },
            getCompanies() {
                axios.get('/api/v1/companies-without-paginate', {
                    headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}
                }).then(response => {
                    this.companies = response.data;
                });
            },
            createForm() {
                let app = this;
                event.preventDefault();

                app.arise.created_at = moment(app.arise.created_at).format('YYYY-MM-DD');
                axios.post('/api/v1/arises', app.arise, {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                }).then(function (response) {

                    console.log(response.data);

                    // is succeed
                    app.$swal({
                        type: 'success',
                        title: 'Thêm mới thành công?',
                        text: "Thêm mới chi phí thành công!",
                        confirmButtonColor: '#3085d6',
                    });
                    app.$router.go("/arises");

                }).catch(function (error) {
                    app.$swal({
                        type: 'error',
                        title: 'Thêm mới thất bại!',
                        text: 'Lỗi hệ thống ' + error + ', vui lòng thử lại sau.'
                    });
                });
            }
        },
    }
</script>

<style scoped>

</style>