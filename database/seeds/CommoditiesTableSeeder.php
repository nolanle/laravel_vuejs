<?php

use Illuminate\Database\Seeder;

class CommoditiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        \App\Models\Commodity::create([
            'name' => 'Xe máy', 'code' => 'XM',
            'mortgage_amount' => 10000000,
            'interest_by_date' => 3000,
            'interest_period' => 10,
            'days_of_delayed' => 15,
            'activated' => TRUE,
            'attrs' => json_encode(['Biển số xe', 'Số khung', 'Số máy']),
        ]);

        \App\Models\Commodity::create([
            'name' => 'Ô tô', 'code' => 'OTO',
            'mortgage_amount' => 10000000,
            'interest_by_date' => 3000,
            'interest_period' => 10,
            'days_of_delayed' => 15,
            'activated' => TRUE,
            'attrs' => json_encode(['Biển số xe', 'Số khung', 'Số máy']),
        ]);

        \App\Models\Commodity::create([
            'name' => 'Điện thoại', 'code' => 'ĐT',
            'mortgage_amount' => 10000000,
            'interest_by_date' => 3000,
            'interest_period' => 10,
            'days_of_delayed' => 15,
            'activated' => TRUE,
            'attrs' => json_encode(['IMEI', 'Password']),
        ]);

        \App\Models\Commodity::create([
            'name' => 'Laptop', 'code' => 'LT',
            'mortgage_amount' => 10000000,
            'interest_by_date' => 3000,
            'interest_period' => 10,
            'days_of_delayed' => 15,
            'activated' => TRUE,
            'attrs' => json_encode(['IMEI', 'Password', 'Tình trạng']),
        ]);

        \App\Models\Commodity::create([
            'name' => 'Vàng', 'code' => 'VANG',
            'mortgage_amount' => 10000000,
            'interest_by_date' => 3000,
            'interest_period' => 10,
            'days_of_delayed' => 15,
            'activated' => TRUE,
        ]);
    }
}
