<template>
    <div class="react-bs-table-container">
        <div class="react-bs-table-tool-bar ">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-8">
                    <div class="btn-group btn-group-sm" role="group">
                        <router-link :to="{name: 'createCompany'}" class="btn btn-success"><i class="fa fa-plus"></i> THÊM MỚI</router-link>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
                    <div class="form-group form-group-sm react-bs-table-search-form">
                        <input placeholder="Tìm kiếm công ty" class="form-control" type="text" style="z-index: 0;"><span class="input-group-btn"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="react-bs-table react-bs-table-bordered" style="height: 100%;">
            <div class="react-bs-container-header table-header-wrapper">
                <table class="table table-hover table-bordered table-condensed">
                    <colgroup>
                        <col style="width: 15%;">
                        <col style="width: 15%;">
                        <col style="width: 15%;">
                        <col style="width: 15%;">
                        <col style="width: 15%;">
                        <col style="width: 15%;">
                        <col style="width: 10%;">
                    </colgroup>
                    <thead>
                    <tr>
                        <th style="text-align: left;">TÊN CÔNG TY</th>
                        <th style="text-align: left;">ĐIỆN THOẠI</th>
                        <th style="text-align: left;">ĐỊA CHỈ</th>
                        <th style="text-align: left;">NGƯỜI ĐẠI DIỆN</th>
                        <th style="text-align: left;">VỐN ĐẦU TƯ</th>
                        <th style="text-align: left;">QUỸ TIỀN MẶT</th>
                        <th style="text-align: center;">&nbsp;</th>
                    </tr>
                    </thead>
                </table>
            </div>
            <div class="react-bs-container-body" style="height: 100%;">
                <table class="table table-striped table-bordered table-hover table-condensed">
                    <colgroup>
                        <col style="width: 15%;">
                        <col style="width: 15%;">
                        <col style="width: 15%;">
                        <col style="width: 15%;">
                        <col style="width: 15%;">
                        <col style="width: 15%;">
                        <col style="width: 10%;">
                    </colgroup>
                    <tbody>
                    <tr v-for="company, index in companies.data">
                        <td style="text-align: left;" tabindex="1">
                            <router-link :to="{name: 'editCompany', params: {id: company.id}}" class="btn btn-xs btn-default">
                                <span class="text-success">{{ company.name }}</span>
                            </router-link>
                        </td>
                        <td style="text-align: left;" tabindex="2">{{ company.phone }}</td>
                        <td style="text-align: left;" tabindex="3">{{ company.address }}</td>
                        <td style="text-align: left;" tabindex="4">{{ company.represent }}</td>
                        <td style="text-align: left;" tabindex="5">{{ company.interested }}</td>
                        <td style="text-align: left;" tabindex="5">{{ company.total_investment }}</td>
                        <td style="text-align: center;" tabindex="6">
                            <a href="#" class="btn btn-xs btn-danger" v-on:click="deleteEntry(company.id, index)">Delete</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="react-bs-table-pagination">
            <div class="row" style="margin-top: 15px;">
                <div class="col-md-6 col-xs-6 col-sm-6 col-lg-6 offset-3" style="display: block;">
                    <pagination :data="companies" @pagination-change-page="getResults"></pagination>
                </div>
            </div>
        </div>
        <div class="s-alert-wrapper"></div>
    </div>
</template>

<script>
    export default {
        name: "IndexCompanies",
        data: function () {
            return {
                companies: []
            }
        },
        mounted() {
            this.getResults();
        },
        methods: {
            getResults(page = 1) { axios.get('/api/v1/companies?page=' + page).then(
                response => {
                    this.companies = response.data;
                    // this.$swal({ type: 'success', title: 'Thành công', text: 'Tải danh sách công ty thành công!' });
                });
            },
            deleteEntry(id, index) {
                this.$swal({
                    type: 'warning',
                    title: 'Bạn có chắc xóa?',
                    text: "Hành động này không thể hoàn tác, vui lòng xác nhận!",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Chắc chắn, xóa luôn đi!',
                    cancelButtonText: '<i class="fa fa-ban"></i> Hủy bỏ',
                }).then((result) => {
                    if (result.value) {

                        var app = this;
                        axios.delete('/api/v1/companies/' + id)
                            .then(function (resp) {
                                app.$swal({
                                    type: 'success',
                                    title: 'Đã xóa thành công!',
                                    text: 'Công ty do bạn quản lý đã bị xóa khỏi hệ thống.'
                                });
                                app.companies.data.splice(index, 1);
                            })
                            .catch(function (error) {
                                // alert("Could not delete company");
                                app.$swal({
                                    type: 'error',
                                    title: 'Xóa thất bại!',
                                    text: 'Lỗi hệ thống ' + error + ', vui lòng thử lại sau.'
                                });
                            });
                    }
                })
            }
        }
    }
</script>

<style scoped>

</style>