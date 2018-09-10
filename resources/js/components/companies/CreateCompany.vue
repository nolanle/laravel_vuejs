<template>
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mb-0">Thêm Công Ty Mới</h4>
                    <div class="delete-button"></div>
                </div>
                <div class="col-sm-6">
                    <nav class="float-left float-sm-right" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}"><i class="ti-home"></i> Dashboard</router-link></li>
                            <li class="breadcrumb-item"><router-link :to="{name: 'indexCompanies'}">Danh Sách Công Ty</router-link></li>
                            <li class="breadcrumb-item active" aria-current="page">Thêm Công Ty Mới</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card-statistics mb-30 card">
            <div class="card-body">
                <h5 class="card-title"><span>Thêm công ty mới</span></h5>
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <form v-on:submit="createForm()">

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="name">Tên Công Ty <span class="text-danger">(*)</span></label>
                                    <input v-model="company.name" type="text" id="name" class="form-control" required />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone">Số Điện Thoại <span class="text-danger">(*)</span></label>
                                <input v-model="company.phone" type="text" id="phone" class="form-control" required />
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="province">Tỉnh / Thành Phố <span class="text-danger">(*)</span></label>
                                    <select v-on:change="getDistricts" v-model="company.province" id="province" class="form-control">
                                        <option> ~~~~~~~ Chọn ~~~~~~~ </option>
                                        <option v-for="item in provinces" v-bind:value="item.id">{{ item.name }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="district">Quận / Huyện / Thị Xã <span class="text-danger">(*)</span></label>
                                    <select v-on:change="districtChanged" v-model="company.district" id="district" class="form-control">
                                        <option> ~~~~~~~ Chọn ~~~~~~~ </option>
                                        <option v-for="district in districts" v-bind:value="district.id">{{ district.name }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address">Số Nhà, Tên Đường <span class="text-danger">(*)</span></label>
                                <input v-model="company.address" type="text" id="address" class="form-control" required />
                            </div>

                            <div class="form-group">
                                <label for="represent">Người Đại Diện <span class="text-danger">(*)</span></label>
                                <input v-model="company.represent" type="text" id="represent" class="form-control" required />
                            </div>

                            <div class="form-group">
                                <label for="interested">Số Vốn Đầu Tư <span class="text-danger">(*)</span></label>
                                <input v-model="company.interested" type="text" id="interested" class="form-control" required />
                            </div>

                            <div class="form-group">
                                <label for="activated">Trạng Thái <span class="text-danger">(*)</span></label>
                                <div class="pull-right">
                                    <switches v-model="company.activated" id="activated" theme="bootstrap" color="success"></switches>
                                </div>
                            </div>

                            <div class="pull-right">
                                <router-link :to="{name: 'indexCompanies'}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left"></i>
                                    <span>QUAY LẠI</span>
                                </router-link>
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-plus"></i>
                                    <span>THÊM MỚI</span>
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
    export default {
        name: "CreateCompany",
        data: function () {
            return {
                company: {
                    name: '',
                    phone: '',
                    province: '045',
                    district: '',
                    district_id: '',
                    address: '',
                    represent: '',
                    interested: 0,
                    activated: 1,
                },
                provinces: {},
                districts: {}
            }
        },
        mounted() {
            this.getProvinces();
        },
        methods: {
            getProvinces() {
                axios.get('/api/v1/provinces', {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                }).then( response => {
                    this.provinces = response.data;
                });
            },

            getDistricts() {
                axios.get('/api/v1/provinces/' + this.convertProvinceId(this.company.province), {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                }).then( response => {
                    this.districts = response.data;
                });
            },

            districtChanged () {
                this.company.district_id = this.convertDistrictId(this.company.district);
            },

            convertProvinceId(id = 1) { if (id < 10) return '0' + id; return id; },
            convertDistrictId(id = 1) { if (id < 10) return '00' + id; else if (id < 100) return '0' + id; return id; },

            createForm() {
                event.preventDefault();
                // console.log(this.company);
                let app = this;
                axios.post('/api/v1/companies', this.company, { headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }}).then(function (response) {
                    app.$swal({
                        type: 'success',
                        title: 'Thêm mới thành công?',
                        text: "Đã thêm mới công ty thành công!",
                        confirmButtonColor: '#3085d6',
                    }).then((result) => {
                        if (result.value) {
                            app.$router.push({path: '/companies'});
                        } else {
                            app.$swal({
                                type: 'error',
                                title: 'Thêm mới thất bại!',
                                text: 'Lỗi hệ thống ' + error + ', vui lòng thử lại sau.'
                            });
                        }
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