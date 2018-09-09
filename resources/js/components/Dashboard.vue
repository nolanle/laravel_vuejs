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
            <div class="mb-30 col-md-12">
                <div class="card-statistics h-100 card">
                    <div class="card-body">

                        <div class="col-md-12 form-group">
                            <label for="token" class="form-label col-md-3">Token: </label>
                            <div class="col-md-9">
                                <textarea type="text" id="token" class="form-control" rows="10">{{ token }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-12 form-group">
                            <label class="form-label col-md-3">LoggedIn: </label>
                            <div class="col-md-9">
                                <code>{{ data }}</code>
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
        name: "Dashboard",
        data() {
            return {
                data: 'nothing',
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
