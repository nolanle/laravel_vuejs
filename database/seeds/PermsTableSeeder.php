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
        $perm->name = 'delete-contract';
        $perm->display_name = "Xóa hợp đồng";
        $perm->save();
        $role->attachPermission($perm);

    }
}
