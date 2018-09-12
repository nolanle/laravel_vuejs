<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        \App\Models\Role::create([
            'name' => 'admin',
            'display_name' => 'Quản Trị Viên',
            'description' => 'Quản Trị Viên',
        ]);

        \App\Models\Role::create([
            'name' => 'employee',
            'display_name' => 'Nhân Viên',
            'description' => 'Nhân Viên',
        ]);
    }
}
