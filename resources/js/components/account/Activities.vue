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

        <div class="mb-30">
            <div class="card-statistics h-100 card">
                <div class="card-body">
                    <h5 class="card-title">Lịch sử hoạt động</h5>
                    <div class="row">
                        <div class="col-sm-10 offset-1">
                            <ul class="list list-unstyled mb-30 list-group">
                                <li v-for="activity in activities" class="p-0 pl-40 list-group-item">
                                    <i :class="activity.properties.icon"></i>
                                    {{ activity.description + ' tại địa chỉ ' + activity.properties.ip }}
                                    <span class="pull-right">{{ activity.created_at | moment("h:mm:ss a D/M/Y") }}</span>
                                </li>
                            </ul>
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
        data() { return { activities: {}, token: '' } },
        mounted() {
            let app = this;
            app.token = localStorage.getItem('token');

            axios.get('/api/v1/activities', {
                headers: { Authorization: 'Bearer ' + app.token }
            }).then(response => {

                // console.log(response.data);
                app.activities = response.data;

            }).catch(error => {
                console.log("Lỗi tải xuống nội dung!");
            });

        }
    }
</script>

<style scoped></style>
