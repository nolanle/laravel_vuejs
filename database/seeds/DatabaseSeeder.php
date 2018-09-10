<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        $this->call(UsersTableSeeder::class);

        ini_set('memory_limit', '-1');
        DB::unprepared(File::get(__DIR__ . '/don_vi_hanh_chinh.sql'));

        $this->call(CompaniesTableSeeder::class);
    }
}
