<template>
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mb-0">Chỉnh sửa công ty</h4>
                    <div class="delete-button"></div>
                </div>
                <div class="col-sm-6">
                    <nav class="float-left float-sm-right" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link :to="{name: 'dashboard'}"><i class="ti-home"></i> Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa công ty</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card-statistics mb-30 card">
            <div class="card-body">
                <h5 class="card-title"><span>{{ company.name }}</span></h5>
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <form v-on:submit="updateForm()">

                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="name">Tên Công Ty</label>
                                    <input v-model="company.name" type="text" id="name" class="form-control" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone">Số Điện Thoại</label>
                                <input v-model="company.phone" type="text" id="phone" class="form-control" />
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="province">Tỉnh / Thành Phố</label>
                                    <select v-on:change="getDistricts" v-model="company.province" id="province" class="form-control">
                                        <option v-for="item in provinces" v-bind:value="item.id">{{ item.name }}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="district">Quận / Huyện / Thị Xã</label>
                                    <select v-on:change="districtChanged" v-model="company.district" id="district" class="form-control">
                                        <option v-for="district in districts" v-bind:value="district.id">{{ district.name }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address">Số Nhà, Tên Đường</label>
                                <input v-model="company.address" type="text" id="address" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label for="represent">Người Đại Diện</label>
                                <input v-model="company.represent" type="text" id="represent" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label for="interested">Số Vốn Đầu Tư</label>
                                <input v-model="company.interested" type="text" id="interested" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label for="activated">Trạng Thái</label>
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
    export default {
        name: "EditCompany",
        mounted() {
            this.companyId = this.$route.params.id;
            this.getCompany();
            this.getProvinces();
        },
        data: function () {
            return {
                companyId: null,
                company: {
                    name: '', phone: '', province: '', province_id: '',
                    district: '', district_id: '', address: '',
                    represent: '', interested: 0, activated: 0
                },
                provinces: {}, districts: {}
            };
        },
        methods: {
            convertProvinceId(id = 1) { if (id < 10) return '0' + id; return id; },
            convertDistrictId(id = 1) { if (id < 10) return '00' + id; else if (id < 100) return '0' + id; return id; },
            districtChanged () { this.company.district_id = this.convertDistrictId(this.company.district); },

            getProvinces() {
                let app = this;
                axios.get('/api/v1/provinces', { headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }}).then( response => {
                    app.provinces = response.data;
                });
            },

            getDistricts() {
                let app = this;
                axios.get('/api/v1/provinces/' + app.convertProvinceId(app.company.province), { headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }}).then( response => {
                    app.districts = response.data;
                });
            },

            getCompany() {
                let app = this;
                axios.get('/api/v1/companies/' + app.companyId, { headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }}).then(response => {
                    app.company = response.data;
                });
            },

            updateForm() {
                event.preventDefault();
                let app = this;
                axios.patch('/api/v1/companies/' + app.company.id, app.company, { headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }}).then(function (response) {
                    app.$swal({
                        type: 'success',
                        title: 'Cập nhật thành công?',
                        text: "Cập nhật thông tin công ty thành công!",
                        confirmButtonColor: '#3085d6',
                    }).then((result) => {
                        if (result.value) {
                            app.$router.replace('/companies');
                        } else {
                            app.$swal({
                                type: 'error',
                                title: 'Cập nhật thất bại!',
                                text: 'Lỗi hệ thống, vui lòng thử lại sau.'
                            });
                        }
                    });
                }).catch(function (error) {
                    app.$swal({
                        type: 'error',
                        title: 'Cập nhật thất bại!',
                        text: 'Lỗi hệ thống ' + error + ', vui lòng thử lại sau.'
                    });
                });
            }

        }
    }
</script>

<style scoped>

</style>