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

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="type">Loại Chi Phí <span class="text-danger">(*)</span></label>
                                <input v-model="arise.type_text" id="type" type="text" class="form-control" disabled />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="company">Công Ty <span class="text-danger">(*)</span></label>
                            <input v-model="arise.company.name" id="company" type="text" class="form-control" disabled />
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="amount">Số Tiền <span class="text-danger">(*)</span></label>
                                <money v-model="arise.amount" id="amount" :class="'form-control text-right'" disabled></money>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="created_at">Thời Gian <span class="text-danger">(*)</span></label>
                                <datepicker v-model="arise.created_at" :format="customFormatter" :language="vi" :input-class="'form-control text-right'" disabled></datepicker>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Ghi Chú</label>
                            <textarea-autosize v-model="arise.description" id="description" :min-height="180" ref="description" :class="'form-control'" disabled></textarea-autosize>
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
        name: "ShowArise",
        data: function () {
            return {
                en: en, vi: vi,
                companies: {},
                ariseId: 0,
                arise: {
                    type: 'deposit',
                    company_id: 0,
                    company: {},
                    amount: 0,
                    description: '',
                    created_at: new Date(),
                },
            }
        },
        mounted() {
            this.ariseId = this.$route.params.id;
            this.getArise();

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
            getArise() {
                let app = this;
                axios.get('/api/v1/arises/' + app.ariseId, {
                    headers: {Authorization: 'Bearer ' + localStorage.getItem('token')}
                }).then(response => {
                    this.arise = response.data;
                });
            },
        },
    }
</script>

<style scoped>

</style>