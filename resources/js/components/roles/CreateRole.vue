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
                            <h4 class="text-danger">Giới Hạn Quyền Lực</h4>
                            <div class="form-group">
                                <v-jstree
                                        :data="permissions"
                                        :show-checkbox="true"
                                        :multiple="true"
                                        :allow-batch="true"
                                        :collapse="true"
                                        :allow-transition="false"
                                        @item-click="itemClick">
                                </v-jstree>
                            </div>

                            <div class="mt-5 pull-right">
                                <!--<router-link :to="{name: 'indexRoles'}" class="btn btn-secondary">-->
                                    <!--<i class="fa fa-arrow-left"></i>-->
                                    <!--<span>QUAY LẠI</span>-->
                                <!--</router-link>-->
                                <button @click="$router.go(-1)" type="button" class="btn btn-secondary"><i class="fa fa-arrow-left"></i><span> QUAY LẠI</span></button>
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
            return {
                role: { display_name: '', description: '' },
                permissions: [
                    {
                        "text": "Bảng điều khiển",
                        "value": "dashboard",
                        "selected": true,
                    },
                    {
                        "text": "Quản lý công ty",
                        "value": "all-company",
                        "children": [
                            {
                                "text": "Xem danh sách công ty",
                                "value": "index-company",
                            },
                            {
                                "text": "Tạo mới công ty",
                                "value": "create-company",
                            },
                            {
                                "text": "Chỉnh sửa công ty",
                                "value": "edit-company",
                            },
                            {
                                "text": "Xóa công ty",
                                "value": "delete-company",
                            },
                        ],
                    },
                    {
                        "text": "Quản lý hàng hóa",
                        "value": "all-commodity",
                        "children": [
                            {
                                "text": "Xem danh sách hàng hóa",
                                "value": "index-commodity",
                                "selected": true,
                            },
                            {
                                "text": "Tạo mới hàng hóa",
                                "value": "create-commodity",
                                "selected": true,
                            },
                            {
                                "text": "Chỉnh sửa hàng hóa",
                                "value": "edit-commodity",
                                "selected": true,
                            },
                            {
                                "text": "Xóa hàng hóa",
                                "value": "delete-commodity",
                            },
                        ],
                    },
                    {
                        "text": "Quản lý vai trò",
                        "value": "all-role",
                        "children": [
                            {
                                "text": "Xem danh sách vai trò",
                                "value": "index-role",
                            },
                            {
                                "text": "Tạo mới vai trò",
                                "value": "create-role",
                            },
                            {
                                "text": "Chỉnh sửa vai trò",
                                "value": "edit-role",
                            },
                            {
                                "text": "Xóa vai trò",
                                "value": "delete-role",
                            },
                        ],
                    },
                    {
                        "text": "Quản lý nhân viên",
                        "value": "all-employee",
                        "children": [
                            {
                                "text": "Xem danh sách nhân viên",
                                "value": "index-employee",
                            },
                            {
                                "text": "Tạo mới nhân viên",
                                "value": "create-employee",
                            },
                            {
                                "text": "Chỉnh sửa nhân viên",
                                "value": "edit-employee",
                            },
                            {
                                "text": "Xóa nhân viên",
                                "value": "delete-employee",
                            },
                        ],
                    },
                    {
                        "text": "Quản lý khách hàng",
                        "value": "all-customer",
                        "children": [
                            {
                                "text": "Xem danh sách khách hàng",
                                "value": "index-customer",
                                "selected": true,
                            },
                            {
                                "text": "Tạo mới khách hàng",
                                "value": "create-customer",
                                "selected": true,
                            },
                            {
                                "text": "Chỉnh sửa khách hàng",
                                "value": "edit-customer",
                                "selected": true,
                            },
                            {
                                "text": "Xóa khách hàng",
                                "value": "delete-customer",
                            },
                        ],
                    },
                    {
                        "text": "Hợp đồng cầm đồ",
                        "value": "all-contract",
                        "selected": true,
                        "children": [
                            {
                                "text": "Xem danh sách hợp đồng",
                                "value": "index-contract",
                                "selected": true,
                            },
                            {
                                "text": "Xem danh sách hợp đồng bị cảnh báo",
                                "value": "warning-contract",
                                "selected": true,
                            },
                            {
                                "text": "Tạo mới hợp đồng",
                                "value": "create-contract",
                                "selected": true,
                            },
                            {
                                "text": "Chỉnh sửa hợp đồng",
                                "value": "edit-contract",
                                "selected": true,
                            },
                            {
                                "text": "Trả phí hợp đồng",
                                "value": "paid-contract",
                                "selected": true,
                            },
                            {
                                "text": "Gia hạn hợp đồng",
                                "value": "renew-contract",
                                "selected": true,
                            },
                            {
                                "text": "Thanh lý hợp đồng",
                                "value": "liquidate-contract",
                                "selected": true,
                            },
                        ],
                    },
                    {
                        "text": "Chức năng nâng cao",
                        "value": "all-utils",
                        "children": [
                            {
                                "text": "Thay đổi công ty từ hồ sơ",
                                "value": "change-company-account"
                            }
                        ]
                    }
                ]
            }
        },
        mounted() {
        },
        methods: {
            itemClick (node) {
                console.log(node.model.selected)
            },
            createForm() {
                let app = this;
                event.preventDefault();

                app.role.permissions = app.permissions;

                axios.post('/api/v1/roles', this.role, {
                    headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
                }).then(function (response) {
                    // is succeed
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