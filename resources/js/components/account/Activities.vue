<template>
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mb-0">Lịch sử hoạt động</h4>
                    <div class="delete-button"></div>
                </div>
                <div class="col-sm-6">
                    <nav class="float-left float-sm-right" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <router-link :to="{name: 'dashboard'}"><i class="ti-home"></i> Dashboard</router-link>
                            </li>
                            <li class="breadcrumb-item">
                                <router-link :to="{name: 'account'}"><i class="ti-home"></i> Tài khoản</router-link>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Lịch sử hoạt động</li>
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
                                        <th>HOẠT ĐỘNG</th>
                                        <th>TÀI KHOẢN</th>
                                        <th>CÔNG TY</th>
                                        <th>THÔNG TIN HOẠT ĐỘNG</th>
                                        <th>THỜI GIAN</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(activity, index) in activities.data">
                                        <td>{{ activity.title }}</td>
                                        <td>{{ activity.employee.username }}</td>
                                        <td>{{ activity.company.name }}</td>
                                        <td>{{ activity.message }}</td>
                                        <td>{{ activity.created_at | moment("D/M/Y") }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="react-bs-table-pagination">
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-md-4 col-xs-4 col-sm-4 col-lg-4 offset-4">
                                    <pagination :data="activities" @pagination-change-page="getResults"></pagination>
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
        name: "Activities",
        data() {
            return {
                page: 1,
                activities: {},
            }
        },
        mounted() {
            this.getResults();
        },
        methods: {
            getResults(page = 1) {
                let app = this;
                app.page = page;
                axios.get('/api/v1/activities?page=' + page, {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                }).then(response => {
                    app.activities = response.data;
                });
            },
        },
    }
</script>

<style scoped></style>
