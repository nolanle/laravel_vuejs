<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $role = \App\Models\Role::whereName('admin')->first();

        #################### DASHBOARD ####################
        $perm = new Permission();
        $perm->name = 'dashboard';
        $perm->display_name = "Bảng điều khiển";
        $perm->save();
        $role->attachPermission($perm);
        #################### DASHBOARD ####################

        #################### COMPANIES ####################
        $perm = new Permission();
        $perm->name = 'index-company';
        $perm->display_name = "Xem danh sách công ty";
        $perm->save();
        $role->attachPermission($perm);

        $perm = new Permission();
        $perm->name = 'create-company';
        $perm->display_name = "Tạo mới công ty";
        $perm->save();
        $role->attachPermission($perm);

        $perm = new Permission();
        $perm->name = 'edit-company';
        $perm->display_name = "Chỉnh sửa công ty";
        $perm->save();
        $role->attachPermission($perm);

        $perm = new Permission();
        $perm->name = 'delete-company';
        $perm->display_name = "Xóa công ty";
        $perm->save();
        $role->attachPermission($perm);
        #################### COMPANIES ####################

        ################### COMMODITIES ###################
        $perm = new Permission();
        $perm->name = 'index-commodity';
        $perm->display_name = "Xem danh sách hàng hóa";
        $perm->save();
        $role->attachPermission($perm);

        $perm = new Permission();
        $perm->name = 'create-commodity';
        $perm->display_name = "Tạo mới hàng hóa";
        $perm->save();
        $role->attachPermission($perm);

        $perm = new Permission();
        $perm->name = 'edit-commodity';
        $perm->display_name = "Chỉnh sửa hàng hóa";
        $perm->save();
        $role->attachPermission($perm);

        $perm = new Permission();
        $perm->name = 'delete-commodity';
        $perm->display_name = "Xóa hàng hóa";
        $perm->save();
        $role->attachPermission($perm);
        ################### COMMODITIES ###################

        ###################### ROLES ######################
        $perm = new Permission();
        $perm->name = 'index-role';
        $perm->display_name = "Xem danh sách vai trò";
        $perm->save();
        $role->attachPermission($perm);

        $perm = new Permission();
        $perm->name = 'create-role';
        $perm->display_name = "Tạo mới vai trò";
        $perm->save();
        $role->attachPermission($perm);

        $perm = new Permission();
        $perm->name = 'edit-role';
        $perm->display_name = "Chỉnh sửa vai trò";
        $perm->save();
        $role->attachPermission($perm);

        $perm = new Permission();
        $perm->name = 'delete-role';
        $perm->display_name = "Xóa vai trò";
        $perm->save();
        $role->attachPermission($perm);
        ###################### ROLES ######################

        #################### EMPLOYEES ####################
        $perm = new Permission();
        $perm->name = 'index-employee';
        $perm->display_name = "Xem danh sách nhân viên";
        $perm->save();
        $role->attachPermission($perm);

        $perm = new Permission();
        $perm->name = 'create-employee';
        $perm->display_name = "Tạo mới nhân viên";
        $perm->save();
        $role->attachPermission($perm);

        $perm = new Permission();
        $perm->name = 'edit-employee';
        $perm->display_name = "Chỉnh sửa nhân viên";
        $perm->save();
        $role->attachPermission($perm);

        $perm = new Permission();
        $perm->name = 'delete-employee';
        $perm->display_name = "Xóa nhân viên";
        $perm->save();
        $role->attachPermission($perm);
        #################### EMPLOYEES ####################

        #################### CUSTOMERS ####################
        $perm = new Permission();
        $perm->name = 'index-customer';
        $perm->display_name = "Xem danh sách khách hàng";
        $perm->save();
        $role->attachPermission($perm);

        $perm = new Permission();
        $perm->name = 'create-customer';
        $perm->display_name = "Tạo mới khách hàng";
        $perm->save();
        $role->attachPermission($perm);

        $perm = new Permission();
        $perm->name = 'edit-customer';
        $perm->display_name = "Chỉnh sửa khách hàng";
        $perm->save();
        $role->attachPermission($perm);

        $perm = new Permission();
        $perm->name = 'delete-customer';
        $perm->display_name = "Xóa khách hàng";
        $perm->save();
        $role->attachPermission($perm);
        #################### CUSTOMERS ####################

        #################### CONTRACTS ####################
        $perm = new Permission();
        $perm->name = 'index-contract';
        $perm->display_name = "Xem danh sách hợp đồng";
        $perm->save();
        $role->attachPermission($perm);

        $perm = new Permission();
        $perm->name = 'create-contract';
        $perm->display_name = "Tạo mới hợp đồng";
        $perm->save();
        $role->attachPermission($perm);

        $perm = new Permission();
        $perm->name = 'edit-contract';
        $perm->display_name = "Chỉnh sửa hợp đồng";
        $perm->save();
        $role->attachPermission($perm);

        $perm = new Permission();
        $perm->name = 'paid-contract';
        $perm->display_name = "Trả phí hợp đồng";
        $perm->save();
        $role->attachPermission($perm);

        $perm = new Permission();
        $perm->name = 'renew-contract';
        $perm->display_name = "Gia hạn hợp đồng";
        $perm->save();
        $role->attachPermission($perm);

        $perm = new Permission();
        $perm->name = 'liquidate-contract';
        $perm->display_name = "Thanh lý hợp đồng";
        $perm->save();
        $role->attachPermission($perm);
        #################### CONTRACTS ####################
    }
}
