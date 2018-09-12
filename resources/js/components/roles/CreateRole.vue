<template>
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h4 class="mb-0">Thêm Mới Quyền</h4>
                    <div class="delete-button"></div>
                </div>
                <div class="col-sm-6">
                    <nav class="float-left float-sm-right" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><router-link :to="{name: 'dashboard'}"><i class="ti-home"></i> Dashboard</router-link></li>
                            <li class="breadcrumb-item"><router-link :to="{name: 'indexRoles'}">Phân Quyền</router-link></li>
                            <li class="breadcrumb-item active" aria-current="page">Thêm Mới Quyền</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="card-statistics mb-30 card">
            <div class="card-body">
                <h5 class="card-title"><span>Thêm mới quyền</span></h5>
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <form v-on:submit="createForm()">

                            <div class="form-group">
                                <label for="display_name">Tên Hiển Thị <span class="text-danger">(*)</span></label>
                                <input v-model="role.display_name" id="display_name" type="text" class="form-control" required />
                            </div>

                            <div class="form-group">
                                <label for="display_name">Mô Tả Quyền</label>
                                <textarea-autosize v-model="role.description" :min-height="180" ref="description" :class="'form-control'"></textarea-autosize>
                            </div>
                            <hr>

                            <div class="mt-5 pull-right">
                                <router-link :to="{name: 'indexRoles'}" class="btn btn-secondary">
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
        name: "CreateRole",
        data: function () {
            return { role: { display_name: '', description: '' } }
        },
        mounted() {
        },
        methods: {
            createForm() {
                let app = this;
                event.preventDefault();

                axios.post('/api/v1/roles', this.role, {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                }).then(function (response) {
                    app.$swal({
                        type: 'success',
                        title: 'Thêm mới thành công?',
                        text: "Thêm mới phân quyền thành công!",
                        confirmButtonColor: '#3085d6',
                    }).then((result) => {
                        if (result.value) {
                            app.$router.push({path: '/roles'});
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