<template>
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mb-0">Chi Tiết Hằng Ngày</h4>
                    <div class="delete-button"></div>
                </div>
                <div class="col-sm-6">
                    <nav class="float-left float-sm-right" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}"><i class="ti-home"></i> Dashboard</router-link></li>
                            <li class="breadcrumb-item active" aria-current="page">Chi Tiết Hằng Ngày</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="mb-30 col-xl-12">
                <div class="card-statistics h-100 card">
                    <div class="card-body react-bs-table-container">

                        <div class="react-bs-table react-bs-table-bordered">
                            <div class="react-bs-container-body">
                                <table class="table table-striped table-bordered table-hover table-condensed">
                                    <thead>
                                    <tr>
                                        <th>LOẠI CHI PHÍ</th>
                                        <th class="text-right">SỐ TIỀN</th>
                                        <th>THÔNG TIN THÊM</th>
                                        <th>THỜI GIAN</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(arise, index) in arises.data">
                                        <td>{{ arise.type_text }}</td>
                                        <td class="text-right">{{ arise.addition === 1 ? ' + ' : ' - ' }} {{ arise.amount | currency }}</td>
                                        <td>{{ arise.description }}</td>
                                        <td>{{ arise.created_at | moment("D/M/Y") }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="react-bs-table-pagination">
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-4 col-xs-4 col-sm-4 col-lg-4 offset-4">
                                    <pagination :data="arises" @pagination-change-page="getResults"></pagination>
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
    export default {
        name: "IndexArises",
        data: function () {
            return {
                page: 1,
                arises: {},
            }
        },
        mounted() {
            this.getResults();
        },
        methods: {
            getResults(page = 1) {
                let app = this;
                app.page = page;
                axios.get('/api/v1/arises?page=' + page, {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                }).then(response => {
                    app.arises = response.data;
                });
            },
        },

    }
</script>

<style scoped>

</style>