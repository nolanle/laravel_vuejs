<template>
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mb-0">Dashboard</h4></div>
                <div class="col-sm-6">
                    <nav class="float-left float-sm-right" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="mb-30 col-md-6 col-lg-6 col-xl-3">
                <div class="card-statistics h-100 card">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-left"><span class="text-danger"><i class="fa fa-bar-chart-o highlight-icon" aria-hidden="true"></i></span></div>
                            <div class="float-right text-right">
                                <p class="card-text text-dark">Visitors</p>
                                <h4>65,650</h4></div>
                        </div>
                        <p class="text-muted pt-3 mb-0 mt-2 border-top"><i class="fa fa-exclamation-circle mr-1" aria-hidden="true"></i> 81% lower growth</p>
                    </div>
                </div>
            </div>
            <div class="mb-30 col-md-6 col-lg-6 col-xl-3">
                <div class="card-statistics h-100 card">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-left"><span class="text-warning"><i class="fa fa-shopping-cart highlight-icon" aria-hidden="true"></i></span></div>
                            <div class="float-right text-right">
                                <p class="card-text text-dark">Orders</p>
                                <h4>656</h4></div>
                        </div>
                        <p class="text-muted pt-3 mb-0 mt-2 border-top"><i class="fa fa-bookmark-o mr-1" aria-hidden="true"></i> Total sales</p>
                    </div>
                </div>
            </div>
            <div class="mb-30 col-md-6 col-lg-6 col-xl-3">
                <div class="card-statistics h-100 card">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-left"><span class="text-success"><i class="fa fa-dollar highlight-icon" aria-hidden="true"></i></span></div>
                            <div class="float-right text-right">
                                <p class="card-text text-dark">Revenue</p>
                                <h4>$65656</h4></div>
                        </div>
                        <p class="text-muted pt-3 mb-0 mt-2 border-top"><i class="fa fa-calendar mr-1" aria-hidden="true"></i> Sales Per Week</p>
                    </div>
                </div>
            </div>
            <div class="mb-30 col-md-6 col-lg-6 col-xl-3">
                <div class="card-statistics h-100 card">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-left"><span class="text-primary"><i class="fa fa-twitter highlight-icon" aria-hidden="true"></i></span></div>
                            <div class="float-right text-right">
                                <p class="card-text text-dark">Followers</p>
                                <h4>62,500+</h4></div>
                        </div>
                        <p class="text-muted pt-3 mb-0 mt-2 border-top"><i class="fa fa-repeat mr-1" aria-hidden="true"></i> Just Updated</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Dashboard",
        data() {
            return {
                data: 'Unauthenticated',
                token: '',
            }
        },
        mounted() {
            this.token = localStorage.getItem('token');
            axios.get('/api/v1/dashboard', {
                headers: { Authorization: 'Bearer ' + this.token }
            }).then(response => {
                this.data = response.data.data
            }).catch(error => {});
        }
    }
</script>
